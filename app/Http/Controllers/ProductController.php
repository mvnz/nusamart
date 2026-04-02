<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->with('seller');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->latest()->paginate(12);

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        abort_if(!$product->is_active, 404);

        return view('products.show', compact('product'));
    }
}
