<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->withCount(['orders' => function ($q) {
            $q->where('status', 'success');
        }])->withSum(['orders' => function ($q) {
            $q->where('status', 'success');
        }], 'grand_total')
        ->orderBy('created_at', 'desc')
        ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = User::where('role', '!=', 'admin')
            ->withCount(['orders' => function ($q) {
                $q->where('status', 'success');
            }])
            ->withSum(['orders' => function ($q) {
                $q->where('status', 'success');
            }], 'grand_total')
            ->findOrFail($id);

        $orders = $customer->orders()->latest()->get();
        
        $loyaltyTransactions = $customer->loyaltyTransactions()
            ->with('order')
            ->latest()
            ->get();

        return view('admin.customers.show', compact('customer', 'orders', 'loyaltyTransactions'));
    }
}
