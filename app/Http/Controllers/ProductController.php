<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->with(['seller', 'category']);
        $selectedCategory = null;

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $selectedCategory = Category::find($request->category_id);
            $query->where('category_id', $request->category_id);
        } elseif ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $perPage = in_array((int)$request->per_page, [15, 30, 60]) ? (int)$request->per_page : 15;

        $sort = $request->get('sort', 'terbaru');
        switch ($sort) {
            case 'harga_tertinggi':
                $query->orderBy('price', 'desc');
                break;
            case 'harga_terendah':
                $query->orderBy('price', 'asc');
                break;
            case 'terlaris':
                $query->withCount(['orderItems' => fn($q) => $q->whereHas('order', fn($o) => $o->where('status', 'delivered'))])
                      ->orderBy('order_items_count', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate($perPage);

        return view('products.index', compact('products', 'selectedCategory'));
    }

    public function categories()
    {
        $categories = Category::withCount('products')->orderBy('name')->get();

        // Group alphabetically
        $grouped = $categories->groupBy(fn($c) => strtoupper(substr($c->name, 0, 1)));

        return view('categories.categories', compact('grouped'));
    }

    public function show(Product $product)
    {
        abort_if(!$product->is_active, 404);

        $isWishlisted = false;
        if (auth()->check()) {
            $isWishlisted = \App\Models\Wishlist::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->exists();
        }

        return view('products.show', compact('product', 'isWishlisted'));
    }

    /**
     * Menampilkan produk milik seller yang login
     */
    public function myProducts(Request $request)
    {
        $user = auth()->user();
        abort_if($user->role !== 'penjual', 403);

        $query = $user->products();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            if ($request->status === 'available') {
                $query->where('is_active', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_active', false);
            }
        }

        $products = $query->latest()->paginate(12);
        $categories = \App\Models\Category::orderBy('name')->get();

        return view('products.my-products', compact('products', 'categories'));
    }

    /**
     * Membuat produk baru
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        abort_if($user->role !== 'penjual', 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $validated;
        $data['user_id'] = $user->id;
        // Also store the category name string for backward compatibility
        $data['category'] = \App\Models\Category::find($validated['category_id'])?->name ?? '';

        // Upload foto jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        $product = Product::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dibuat!',
            'product' => $product
        ]);
    }

    /**
     * Update produk (nama, harga, stock, status)
     */
    public function update(Request $request, Product $product)
    {
        $user = auth()->user();
        abort_if((int)$product->user_id !== (int)$user->id, 403);

        $validated = $request->validate([
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'numeric|min:0',
            'stock' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        if (array_key_exists('category_id', $validated)) {
            $validated['category'] = $validated['category_id']
                ? \App\Models\Category::find($validated['category_id'])?->name ?? ''
                : '';
        }

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diperbarui!'
        ]);
    }

    /**
     * Upload foto produk
     */
    public function uploadPhoto(Request $request, Product $product)
    {
        $user = auth()->user();
        abort_if((int)$product->user_id !== (int)$user->id, 403);

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Hapus foto lama jika ada
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Upload foto baru
        $path = $request->file('image')->store('products', 'public');
        $product->update(['image' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Foto produk berhasil diperbarui!',
            'image' => asset('storage/' . $path)
        ]);
    }

    /**
     * Hapus foto produk
     */
    public function deletePhoto(Request $request, Product $product)
    {
        $user = auth()->user();
        abort_if((int)$product->user_id !== (int)$user->id, 403);

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->update(['image' => null]);

        return response()->json([
            'success' => true,
            'message' => 'Foto produk berhasil dihapus!'
        ]);
    }

    /**
     * Hapus produk
     */
    public function destroy(Request $request, Product $product)
    {
        $user = auth()->user();
        abort_if((int)$product->user_id !== (int)$user->id, 403);

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus!'
        ]);
    }
}
