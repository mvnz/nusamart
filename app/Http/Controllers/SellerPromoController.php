<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Promo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SellerPromoController extends Controller
{
    /**
     * Tampilkan daftar promo penjual
     */
    public function index(Request $request)
    {
        $query = Promo::where('user_id', auth()->id())
            ->with('product')
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->whereHas('product', fn($q) => 
                $q->where('name', 'like', '%' . $request->search . '%')
            );
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
            } elseif ($request->status === 'scheduled') {
                $query->where('start_date', '>', now());
            } elseif ($request->status === 'expired') {
                $query->where('end_date', '<', now());
            }
        }

        $promos = $query->paginate(15);
        
        return view('seller.promos.index', compact('promos'));
    }

    /**
     * Tampilkan form membuat promo
     */
    public function create(Request $request)
    {
        $products = Product::where('user_id', auth()->id())
            ->where('is_active', true)
            ->get();

        // Jika dari product detail page
        $productId = $request->get('product_id');
        
        return view('seller.promos.create', compact('products', 'productId'));
    }

    /**
     * Simpan promo baru
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        abort_if($user->role !== 'penjual', 403);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'promo_price' => 'required|numeric|min:0',
            'start_date' => 'required|date|after_or_equal:now',
            'end_date' => 'required|date|after:start_date',
            'quota' => 'required|integer|min:0',
        ]);

        // Verifikasi bahwa product milik user
        $product = Product::findOrFail($validated['product_id']);
        abort_if($product->user_id !== $user->id, 403);

        // Validasi harga promo
        if ($validated['promo_price'] >= $product->price) {
            return back()->withErrors(['promo_price' => 'Harga promo harus lebih rendah dari harga normal']);
        }

        // Cek apakah sudah ada promo aktif untuk produk ini
        $existingPromo = $product->promos()
            ->where('is_active', true)
            ->where('end_date', '>', now())
            ->first();

        if ($existingPromo) {
            return back()->withErrors(['product_id' => 'Produk ini sudah memiliki promo aktif. Nonaktifkan promo lama terlebih dahulu.']);
        }

        $promo = Promo::create([
            'product_id' => $validated['product_id'],
            'user_id' => $user->id,
            'original_price' => $product->price,
            'promo_price' => $validated['promo_price'],
            'discount_percentage' => round((($product->price - $validated['promo_price']) / $product->price) * 100),
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'quota' => $validated['quota'],
            'is_active' => true,
        ]);

        return redirect()->route('seller.promos.index')
            ->with('success', 'Promo berhasil dibuat! Promo akan otomatis aktif pada waktu yang ditentukan.');
    }

    /**
     * Tampilkan detail promo
     */
    public function show(Promo $promo)
    {
        abort_if($promo->user_id !== auth()->id(), 403);
        
        return view('seller.promos.show', compact('promo'));
    }

    /**
     * Tampilkan form edit promo
     */
    public function edit(Promo $promo)
    {
        abort_if($promo->user_id !== auth()->id(), 403);

        // Hanya bisa edit jika belum dimulai
        if ($promo->start_date <= now()) {
            return back()->withErrors(['message' => 'Tidak bisa mengedit promo yang sudah berjalan']);
        }

        return view('seller.promos.edit', compact('promo'));
    }

    /**
     * Update promo
     */
    public function update(Request $request, Promo $promo)
    {
        abort_if($promo->user_id !== auth()->id(), 403);

        // Hanya bisa edit jika belum dimulai
        if ($promo->start_date <= now()) {
            return back()->withErrors(['message' => 'Tidak bisa mengedit promo yang sudah berjalan']);
        }

        $validated = $request->validate([
            'promo_price' => 'required|numeric|min:0',
            'start_date' => 'required|date|after_or_equal:now',
            'end_date' => 'required|date|after:start_date',
            'quota' => 'required|integer|min:0',
        ]);

        // Validasi harga promo
        if ($validated['promo_price'] >= $promo->original_price) {
            return back()->withErrors(['promo_price' => 'Harga promo harus lebih rendah dari harga normal']);
        }

        $promo->update([
            'promo_price' => $validated['promo_price'],
            'discount_percentage' => round((($promo->original_price - $validated['promo_price']) / $promo->original_price) * 100),
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'quota' => $validated['quota'],
        ]);

        return redirect()->route('seller.promos.index')
            ->with('success', 'Promo berhasil diupdate!');
    }

    /**
     * Nonaktifkan promo
     */
    public function deactivate(Promo $promo)
    {
        abort_if($promo->user_id !== auth()->id(), 403);

        $promo->deactivate();

        return back()->with('success', 'Promo berhasil dinonaktifkan');
    }

    /**
     * Aktifkan promo
     */
    public function activate(Promo $promo)
    {
        abort_if($promo->user_id !== auth()->id(), 403);

        $promo->activate();

        return back()->with('success', 'Promo berhasil diaktifkan');
    }

    /**
     * Hapus promo
     */
    public function destroy(Promo $promo)
    {
        abort_if($promo->user_id !== auth()->id(), 403);

        $productName = $promo->product->name;
        $promo->delete();

        return redirect()->route('seller.promos.index')
            ->with('success', "Promo untuk '{$productName}' berhasil dihapus");
    }
}
