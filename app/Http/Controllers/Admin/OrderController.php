<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('user')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->start_date, fn($q) => $q->whereDate('created_at', '>=', $request->start_date))
            ->when($request->end_date, fn($q) => $q->whereDate('created_at', '<=', $request->end_date))
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function export(Request $request)
    {
        $filters = $request->only(['status', 'start_date', 'end_date']);
        $filename = 'orders-' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(new OrdersExport($filters), $filename);
    }

    public function show($order_number)
    {
        $order = Order::with(['user', 'items.product'])
            ->where('order_number', $order_number)
            ->firstOrFail();

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();

        $request->validate([
            'status' => 'required|in:pending,paid,shipped,completed,cancelled',
            'tracking_number' => 'nullable|string|max:100',
        ]);

        $newStatus = $request->status;
        $oldStatus = $order->status;
        $paidStatuses = ['success', 'paid', 'shipped', 'completed'];

        if ($newStatus === 'cancelled') {
            $order->cancelOrder();
        } elseif (in_array($newStatus, $paidStatuses) && !in_array($oldStatus, $paidStatuses)) {
            $order->markAsPaid();
            if ($request->filled('tracking_number')) {
                $order->update(['tracking_number' => $request->tracking_number]);
            }
        } else {
            $order->update([
                'status' => $newStatus,
                'tracking_number' => $request->tracking_number ?? $order->tracking_number,
            ]);
        }

        return back()->with('success', 'Order status updated successfully!');
    }

    public function trackResi($resi)
    {
    $url = config('jne.url_tracking') . '/tracing/api/list/v1/cnote/' . $resi;

    $response = Http::withoutVerifying()
        ->asForm()
        ->withHeaders(['Accept' => 'application/json'])
        ->post($url, [
            'username' => config('jne.username'),
            'api_key'  => config('jne.api_key'),
        ]);

        $data = $response->json();

        if (isset($data['status']) && $data['status'] === false) {
            return response()->json([
                'success' => false,
                'message' => $data['error'],
            ]);
        }

        if (isset($data['cnote'])) {
            return response()->json([
                'success' => true,
                'status'  => $data['cnote']['pod_status'],
                'history' => $data['history'],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan pada server JNE.',
        ], 500);
    }
}