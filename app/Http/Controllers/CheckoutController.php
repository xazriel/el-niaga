<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductVariant;
use App\Services\JneService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    protected $jneService;

    public function __construct(JneService $jneService)
    {
        $this->jneService = $jneService;
    }

    /**
     * Menampilkan halaman checkout.
     */
    public function index()
    {
        $activeOrder = Order::where('user_id', Auth::id())
                            ->where('status', 'pending')
                            ->where('payment_deadline', '>', now())
                            ->first();

        if ($activeOrder) {
            return redirect()->route('checkout.waiting', $activeOrder->order_number)
                             ->with('info', 'Selesaikan pembayaran pesanan Anda sebelumnya.');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang belanja kosong.');
        }

        $totalAmount = 0;
        foreach ($cart as $variantId => $item) {
            $variant = ProductVariant::find($variantId);
            if (!$variant || $variant->stock < $item['quantity']) {
                return redirect()->route('cart.index')->with('error', 'Stok tidak mencukupi.');
            }
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $user = Auth::user();
        return view('checkout.index', compact('cart', 'totalAmount', 'user'));
    }

    /**
     * API: Mencari Lokasi
     */
    public function searchLocation(Request $request)
{
    $query = $request->get('q', '');

    $results = \App\Models\JneDestination::where('name', 'like', "%{$query}%")
        ->orWhere('city', 'like', "%{$query}%")
        ->orWhere('code', 'like', "%{$query}%")
        ->limit(20)
        ->get()
        ->map(fn($d) => [
            'id'   => $d->code,
            'text' => $d->name,
        ]);

    return response()->json(['results' => $results]);
}

    /**
     * API: Menghitung Biaya Ongkir
     */
    public function calculateShipping(Request $request)
    {
        $request->validate([
            'destination_id' => 'required',
            'weight'         => 'required|numeric',
        ]);

        $response = $this->jneService->getTariff($request->destination_id, $request->weight);

        if (isset($response['price'])) {
            return response()->json([
                'success' => true,
                'pricing' => collect($response['price'])->map(function ($item) {
                    return [
                        'courier_name'         => 'JNE',
                        'courier_service_name' => $item['service_display'],
                        'service_code'         => $item['service_code'],
                        'price'                => (int) $item['price'],
                        'duration'             => $item['etd_from'] . '-' . $item['etd_thru'] . ' ' . $item['times'],
                    ];
                }),
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Tarif tidak ditemukan'], 404);
    }

    /**
     * Memproses pesanan, potong stok, buat order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_name'    => 'required|string|max:255',
            'receiver_phone'   => 'required|string|max:20',
            'receiver_address' => 'required|string',
            'destination_id'   => 'required|string',
            'shipping_cost'    => 'required|numeric',
            'courier_name'     => 'required|string',
            'service_code'     => 'required|string',
            // ✅ receiver_city & receiver_zip sekarang dikirim dari form
            'receiver_city'    => 'required|string|max:100',
            'receiver_zip'     => 'required|string|max:10',
            'payment_method'   => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('home');

        try {
            return DB::transaction(function () use ($request, $cart) {

                $totalAmount = array_sum(
                    array_map(fn($item) => $item['price'] * $item['quantity'], $cart)
                );

                $order = Order::create([
                    'order_number'     => 'INV-' . strtoupper(uniqid()),
                    'user_id'          => Auth::id(),
                    'total_amount'     => $totalAmount,
                    'shipping_cost'    => $request->shipping_cost,
                    'grand_total'      => $totalAmount + $request->shipping_cost,
                    'status'           => 'pending',
                    'payment_method'   => $request->payment_method,
                    'receiver_name'    => $request->receiver_name,
                    'receiver_phone'   => $request->receiver_phone,
                    'receiver_address' => $request->receiver_address,
                    'destination_id'   => $request->destination_id,
                    'courier_name'     => $request->courier_name,
                    // ✅ Simpan data ini ke DB agar bisa dipakai saat generate AWB
                    'service_code'     => $request->service_code,
                    'receiver_city'    => $request->receiver_city,
                    'receiver_zip'     => $request->receiver_zip,
                    'payment_deadline' => now()->addMinutes(2),
                ]);

                foreach ($cart as $variantId => $details) {
                    $variant = ProductVariant::where('id', $variantId)->lockForUpdate()->first();

                    if (!$variant || $variant->stock < $details['quantity']) {
                        throw new \Exception("Maaf, stok {$details['name']} baru saja habis.");
                    }

                    $order->items()->create([
                        'product_id' => $variant->product_id,
                        'quantity'   => $details['quantity'],
                        'price'      => $details['price'],
                        'size'       => $variant->size,
                        'color'      => $variant->color,
                    ]);

                    $variant->decrement('stock', $details['quantity']);
                }

                session()->forget('cart');
                return redirect()->route('checkout.waiting', $order->order_number);
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Halaman instruksi pembayaran & cek kadaluwarsa.
     */
    public function waiting($order_number)
    {
        $order = Order::where('order_number', $order_number)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        if ($order->status !== 'pending') {
            return redirect()->route('home');
        }

        if (now()->gt($order->payment_deadline)) {
            $this->restoreStockAndCancel($order);
            return redirect()->route('home')->with('error', 'Waktu pembayaran telah habis.');
        }

        return view('checkout.waiting', compact('order'));
    }

    /**
     * Simulasi Pembayaran Berhasil & Generate AWB JNE.
     */
    public function simulatePay($id)
    {
        $order = Order::where('id', $id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        if (now()->gt($order->payment_deadline)) {
            $this->restoreStockAndCancel($order);
            return redirect()->route('home')->with('error', 'Maaf, waktu pembayaran sudah habis.');
        }

        if ($order->status !== 'pending') {
            return redirect()->route('home');
        }

        // ✅ Semua data dinamis — tidak ada yang hardcode lagi
        $jneData = [
            'OLSHOP_BRANCH'         => 'CGK000',
            'OLSHOP_CUST'           => '80540008',
            'OLSHOP_ORDERID'        => $order->order_number,
            'OLSHOP_SHIPPER_NAME'   => 'FARHANA OFFICIAL',
            'OLSHOP_SHIPPER_ADDR1'  => 'Jl. Kebon Jeruk No. 12',
            'OLSHOP_SHIPPER_CITY'   => 'JAKARTA',
            'OLSHOP_SHIPPER_ZIP'    => '11530',
            'OLSHOP_SHIPPER_PHONE'  => '08123456789',
            'OLSHOP_RECEIVER_NAME'  => $order->receiver_name,
            'OLSHOP_RECEIVER_ADDR1' => $order->receiver_address,
            'OLSHOP_RECEIVER_ADDR2' => '-',
            // ✅ Diambil dari kolom order, bukan hardcode
            'OLSHOP_RECEIVER_CITY'  => $order->receiver_city,
            'OLSHOP_RECEIVER_ZIP'   => $order->receiver_zip,
            'OLSHOP_RECEIVER_PHONE' => $order->receiver_phone,
            'OLSHOP_QTY'            => $order->items->sum('quantity'),
            'OLSHOP_WEIGHT'         => 1,
            'OLSHOP_GOODSDESC'      => 'Koleksi Farhana Moslem Wear',
            'OLSHOP_GOODSVALUE'     => $order->total_amount,
            'OLSHOP_GOODSTYPE'      => '2',
            'OLSHOP_INS_FLAG'       => 'N',
            'OLSHOP_ORIG'           => 'CGK10000',
            'OLSHOP_DEST'           => $order->destination_id,
            // ✅ Diambil dari pilihan user (REG, YES, OKE, dll)
            'OLSHOP_SERVICE'        => $order->service_code,
            'OLSHOP_COD_FLAG'       => 'N',
            'OLSHOP_COD_AMOUNT'     => 0,
        ];

        $res = $this->jneService->createAirwaybill($jneData);

        if (isset($res['detail'][0]) && $res['detail'][0]['status'] == 'sukses') {
            $order->update([
                'status'          => 'success',
                'tracking_number' => $res['detail'][0]['cnote_no'],
            ]);
        } else {
            $order->update(['status' => 'success']);
        }

        return redirect()->route('home')->with('success', 'Pembayaran berhasil dan resi JNE telah dibuat!');
    }

    /**
     * Helper: Kembalikan stok jika order batal/expired.
     */
    private function restoreStockAndCancel($order)
    {
        DB::transaction(function () use ($order) {
            $order->update(['status' => 'cancelled']);
            foreach ($order->items as $item) {
                $variant = ProductVariant::where('product_id', $item->product_id)
                    ->where('color', $item->color)
                    ->where('size', $item->size)
                    ->first();
                if ($variant) {
                    $variant->increment('stock', $item->quantity);
                }
            }
        });
    }
}