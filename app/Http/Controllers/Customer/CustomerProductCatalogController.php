<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CustomerProductCatalogController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Product::with(['category', 'images' => function ($q) {
            $q->where('is_primary', true);
        }]);

        // Category Filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search Filter
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where('name', 'like', "%{$search}%");
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'newest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);

        return view('products.index', compact('products', 'categories'));
    }
}
