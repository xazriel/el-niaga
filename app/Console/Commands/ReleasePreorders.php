<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\ProductVariant;
use App\Services\JneService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReleasePreorders extends Command
{
    protected $signature   = 'preorders:release';
    protected $description = 'Ubah status pre-order yang sudah release menjadi processing dan generate AWB';

    protected $jneService;

    public function __construct(JneService $jneService)
    {
        parent::__construct();
        $this->jneService = $jneService;
    }

    public function handle(): void
    {
        $orders = Order::readyToRelease()->with('items.product')->get();

        if ($orders->isEmpty()) {
            $this->info('Tidak ada pre-order yang perlu dirilis.');
            return;
        }

        foreach ($orders as $order) {
            DB::transaction(function () use ($order) {

                // Kurangi stok sekarang
                foreach ($order->items as $item) {
                    $variant = ProductVariant::where('product_id', $item->product_id)
                        ->where('color', $item->color)
                        ->where('size', $item->size)
                        ->lockForUpdate()
                        ->first();

                    if ($variant) {
                        $variant->decrement('stock', $item->quantity);
                    }
                }

                // Ubah status ke processing
                $order->update([
                    'status'      => 'processing',
                    'is_preorder' => false,
                ]);

                Log::info("Pre-order released: {$order->order_number}");
            });

            // Generate AWB setelah transaksi selesai
            $this->generateAwb($order);

            $this->info("Released: {$order->order_number}");
        }

        $this->info("Total dirilis: {$orders->count()} order.");
    }

    private function generateAwb(Order $order): void
    {
        try {
            $goodsDesc = $order->items
                ->map(fn($item) => $item->product->name ?? 'Produk Farhana')
                ->implode(', ');

            $serviceCode = $order->service_code ?? 'REG';
            preg_match('/^([A-Z]+)/', strtoupper($serviceCode), $m);
            $parsedService = $m[1] ?? 'REG';

            $jneData = [
                'OLSHOP_BRANCH'         => config('jne.branch'),
                'OLSHOP_CUST'           => config('jne.cust_no'),
                'OLSHOP_ORDERID'        => $order->order_number,
                'OLSHOP_SHIPPER_NAME'   => 'FARHANA OFFICIAL',
                'OLSHOP_SHIPPER_ADDR1'  => 'Jl. Margonda Raya No. 1',
                'OLSHOP_SHIPPER_ADDR2'  => '-',
                'OLSHOP_SHIPPER_CITY'   => 'DEPOK',
                'OLSHOP_SHIPPER_ZIP'    => '16411',
                'OLSHOP_SHIPPER_PHONE'  => '08123456789',
                'OLSHOP_RECEIVER_NAME'  => $order->receiver_name,
                'OLSHOP_RECEIVER_ADDR1' => $order->receiver_address,
                'OLSHOP_RECEIVER_ADDR2' => '-',
                'OLSHOP_RECEIVER_CITY'  => $order->receiver_city  ?? '-',
                'OLSHOP_RECEIVER_ZIP'   => $order->receiver_zip   ?? '00000',
                'OLSHOP_RECEIVER_PHONE' => $order->receiver_phone,
                'OLSHOP_QTY'            => $order->items->sum('quantity'),
                'OLSHOP_WEIGHT'         => 1,
                'OLSHOP_GOODSDESC'      => substr($goodsDesc, 0, 60),
                'OLSHOP_GOODSVALUE'     => (int) $order->total_amount,
                'OLSHOP_GOODSTYPE'      => '2',
                'OLSHOP_INST'           => '',
                'OLSHOP_INS_FLAG'       => 'N',
                'OLSHOP_ORIG'           => config('jne.origin_code'),
                'OLSHOP_DEST'           => $order->destination_id,
                'OLSHOP_SERVICE'        => $parsedService,
                'OLSHOP_COD_FLAG'       => 'N',
                'OLSHOP_COD_AMOUNT'     => 0,
            ];

            $res = $this->jneService->createAirwaybill($jneData);

            if (isset($res['detail'][0]['cnote_no']) && ($res['detail'][0]['status'] ?? '') === 'sukses') {
                $order->update(['tracking_number' => $res['detail'][0]['cnote_no']]);
                Log::info("AWB berhasil: {$res['detail'][0]['cnote_no']} untuk {$order->order_number}");
            } else {
                Log::warning("AWB gagal untuk {$order->order_number}", $res);
            }

        } catch (\Exception $e) {
            Log::warning("AWB exception untuk {$order->order_number}: " . $e->getMessage());
        }
    }
}