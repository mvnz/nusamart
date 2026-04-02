<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        return view('products.my-products', compact('products'));
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
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $validated;
        $data['user_id'] = $user->id;

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
        abort_if($product->user_id !== $user->id, 403);

        $validated = $request->validate([
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'price' => 'numeric|min:0',
            'stock' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

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
        abort_if($product->user_id !== $user->id, 403);

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
        abort_if($product->user_id !== $user->id, 403);

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
        abort_if($product->user_id !== $user->id, 403);

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
