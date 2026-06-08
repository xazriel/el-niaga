<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $paidStatuses = ['success', 'paid', 'shipped', 'completed'];

        $query = Order::with('user');

        // Apply Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->whereIn('status', $paidStatuses);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Get Summary Metrics
        $ordersCount = $query->count();
        $totalRevenue = $query->sum('grand_total');
        $totalItemsCost = $query->sum('total_amount');
        $totalShippingCost = $query->sum('shipping_cost');
        $totalPointsDiscount = $query->sum('points_discount');
        $totalVoucherDiscount = $query->sum('voucher_discount');

        $orders = $query->orderBy('created_at', 'desc')->paginate(30);

        return view('admin.reports.index', compact(
            'orders',
            'ordersCount',
            'totalRevenue',
            'totalItemsCost',
            'totalShippingCost',
            'totalPointsDiscount',
            'totalVoucherDiscount'
        ));
    }
}
