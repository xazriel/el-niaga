<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesAnalysisController extends Controller
{
    public function index(Request $request)
    {
        $paidStatuses = ['success', 'paid', 'shipped', 'completed'];

        // 1. Metrics Overview
        $totalSales = Order::whereIn('status', $paidStatuses)->sum('grand_total');
        $totalTransactions = Order::whereIn('status', $paidStatuses)->count();
        $totalCustomers = User::where('role', '!=', 'admin')->count();
        
        $productsSold = OrderItem::whereHas('order', function ($q) use ($paidStatuses) {
            $q->whereIn('status', $paidStatuses);
        })->sum('quantity');

        // 2. Monthly Omset & Growth Calculation
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        $salesThisMonth = Order::whereIn('status', $paidStatuses)
            ->where('created_at', '>=', $thisMonth)
            ->sum('grand_total');

        $salesLastMonth = Order::whereIn('status', $paidStatuses)
            ->where('created_at', '>=', $lastMonth)
            ->where('created_at', '<', $thisMonth)
            ->sum('grand_total');

        $growthRate = 0;
        if ($salesLastMonth > 0) {
            $growthRate = (($salesThisMonth - $salesLastMonth) / $salesLastMonth) * 100;
        } elseif ($salesThisMonth > 0) {
            $growthRate = 100; // Mulai dari 0 ke positif
        }

        // 3. Best Seller Products Ranking
        $bestSellers = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(quantity * price) as revenue'))
            ->whereHas('order', function ($q) use ($paidStatuses) {
                $q->whereIn('status', $paidStatuses);
            })
            ->groupBy('product_id')
            ->orderBy('total_qty', 'desc')
            ->with(['product.category', 'product.images'])
            ->take(5)
            ->get();

        // 4. Top Loyalty Points Customers
        $topPointsCustomers = User::where('role', '!=', 'admin')
            ->orderBy('points', 'desc')
            ->take(5)
            ->get();

        // 5. Chart Data (Harian / Mingguan / Bulanan / Tahunan)
        $filter = $request->query('chart_filter', 'monthly'); // daily, weekly, monthly, yearly
        $chartData = $this->getChartData($filter, $paidStatuses);

        // 6. Slow Moving Products Identification (Cuci Gudang 20%)
        $slowDays = (int) Setting::get('slow_moving_threshold_days', 30);
        $maxSold = (int) Setting::get('slow_moving_max_sold', 5);

        // Slow-moving: Created > X days ago, and total units sold in the last X days is < Y
        $slowMovingProducts = Product::where('created_at', '<=', now()->subDays($slowDays))
            ->with(['category', 'images', 'variants'])
            ->get()
            ->filter(function ($product) use ($paidStatuses, $maxSold, $slowDays) {
                $soldCount = OrderItem::where('product_id', $product->id)
                    ->whereHas('order', function ($q) use ($paidStatuses, $slowDays) {
                        $q->whereIn('status', $paidStatuses)
                          ->where('created_at', '>=', now()->subDays($slowDays));
                    })->sum('quantity');

                $product->sold_count_recent = $soldCount;
                return $soldCount < $maxSold;
            });

        return view('admin.analysis.index', compact(
            'totalSales',
            'totalTransactions',
            'totalCustomers',
            'productsSold',
            'salesThisMonth',
            'salesLastMonth',
            'growthRate',
            'bestSellers',
            'topPointsCustomers',
            'chartData',
            'slowMovingProducts',
            'filter'
        ));
    }

    public function applyClearanceDiscount(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Jika original_price belum diisi, simpan harga sekarang sebagai original_price
        if (empty($product->original_price) || $product->original_price <= $product->price) {
            $product->original_price = $product->price;
        }

        // Terapkan diskon 20%
        $product->price = $product->original_price * 0.80;
        $product->custom_tag = 'Cuci Gudang';
        $product->save();

        return back()->with('success', "Diskon cuci gudang 20% berhasil diterapkan ke produk: {$product->name}");
    }

    private function getChartData($filter, $paidStatuses)
    {
        $labels = [];
        $totals = [];
        $counts = [];

        if ($filter === 'daily') {
            // Last 7 days
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $labels[] = $date->format('d M');
                
                $sales = Order::whereIn('status', $paidStatuses)
                    ->whereDate('created_at', $date->toDateString())
                    ->sum('grand_total');

                $txCount = Order::whereIn('status', $paidStatuses)
                    ->whereDate('created_at', $date->toDateString())
                    ->count();

                $totals[] = (int) $sales;
                $counts[] = $txCount;
            }
        } elseif ($filter === 'weekly') {
            // Last 4 weeks
            for ($i = 3; $i >= 0; $i--) {
                $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
                $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();
                $labels[] = 'W' . Carbon::now()->subWeeks($i)->weekOfYear;

                $sales = Order::whereIn('status', $paidStatuses)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->sum('grand_total');

                $txCount = Order::whereIn('status', $paidStatuses)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->count();

                $totals[] = (int) $sales;
                $counts[] = $txCount;
            }
        } elseif ($filter === 'yearly') {
            // Last 3 years
            for ($i = 2; $i >= 0; $i--) {
                $year = Carbon::now()->subYears($i)->year;
                $labels[] = (string) $year;

                $sales = Order::whereIn('status', $paidStatuses)
                    ->whereYear('created_at', $year)
                    ->sum('grand_total');

                $txCount = Order::whereIn('status', $paidStatuses)
                    ->whereYear('created_at', $year)
                    ->count();

                $totals[] = (int) $sales;
                $counts[] = $txCount;
            }
        } else { // monthly
            // Last 6 months
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $labels[] = $date->format('M Y');

                $sales = Order::whereIn('status', $paidStatuses)
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->sum('grand_total');

                $txCount = Order::whereIn('status', $paidStatuses)
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count();

                $totals[] = (int) $sales;
                $counts[] = $txCount;
            }
        }

        return [
            'labels' => $labels,
            'totals' => $totals,
            'counts' => $counts,
        ];
    }
}
