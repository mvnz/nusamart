<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Menampilkan form input review
     */
    public function create($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        // Cek apakah user sudah membeli produk ini dan belum review
        $hasPurchased = OrderItem::where('product_id', $productId)
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::id());
                // Filter hanya order dengan status completed/delivered
                $query->whereIn('status', ['completed', 'delivered']);
            })
            ->exists();

        if (!$hasPurchased) {
            return redirect()->back()->with('error', 'Anda hanya dapat memberikan review untuk produk yang telah dibeli');
        }

        // Cek apakah user sudah pernah review produk ini
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($existingReview) {
            return redirect()->route('products.show', $productId)
                ->with('info', 'Anda sudah memberikan review untuk produk ini');
        }

        return view('reviews.create', compact('product'));
    }

    /**
     * Menyimpan review
     */
    public function store(Request $request, $productId)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Rating harus dipilih',
            'rating.integer' => 'Rating harus berupa angka',
            'rating.min' => 'Rating minimal 1 bintang',
            'rating.max' => 'Rating maksimal 5 bintang',
            'comment.max' => 'Komentar maksimal 1000 karakter',
        ]);

        $product = Product::find($productId);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        $user = Auth::user();

        // Validasi: user harus sudah membeli produk ini
        $orderItem = OrderItem::where('product_id', $productId)
            ->whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id);
                $query->whereIn('status', ['completed', 'delivered']);
            })
            ->first();

        if (!$orderItem) {
            return redirect()->back()->with('error', 'Anda hanya dapat memberikan review untuk produk yang telah dibeli');
        }

        // Cek apakah sudah pernah review
        $existingReview = Review::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk produk ini');
        }

        // Simpan review
        Review::create([
            'user_id' => $user->id,
            'product_id' => $productId,
            'order_id' => $orderItem->order_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return redirect()->route('products.show', $productId)
            ->with('success', 'Review berhasil disimpan!');
    }

    /**
     * Menampilkan review untuk produk
     */
    public function show($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        $reviews = Review::forProduct($productId)->paginate(10);
        $averageRating = Review::getAverageRating($productId);
        $reviewCount = Review::getReviewCount($productId);
        $userReview = null;

        if (Auth::check()) {
            $userReview = Review::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();
        }

        return view('reviews.show', compact('product', 'reviews', 'averageRating', 'reviewCount', 'userReview'));
    }

    /**
     * Menampilkan form edit review
     */
    public function edit($reviewId)
    {
        $review = Review::find($reviewId);

        if (!$review) {
            return redirect()->back()->with('error', 'Review tidak ditemukan');
        }

        // Pastikan review milik user yang login
        if ($review->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengubah review ini');
        }

        // Hanya bisa diedit dalam 1 hari setelah ditulis
        if ($review->created_at->diffInHours(now()) >= 24) {
            return redirect()->route('products.show', $review->product_id)
                ->with('error', 'Ulasan hanya dapat diedit dalam 24 jam setelah ditulis.');
        }

        return view('reviews.edit', compact('review'));
    }

    /**
     * Update review
     */
    public function update(Request $request, $reviewId)
    {
        $review = Review::find($reviewId);

        if (!$review) {
            return redirect()->back()->with('error', 'Review tidak ditemukan');
        }

        // Pastikan review milik user yang login
        if ($review->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengubah review ini');
        }

        // Hanya bisa diupdate dalam 1 hari setelah ditulis
        if ($review->created_at->diffInHours(now()) >= 24) {
            return redirect()->route('products.show', $review->product_id)
                ->with('error', 'Ulasan hanya dapat diedit dalam 24 jam setelah ditulis.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Rating harus dipilih',
            'rating.integer' => 'Rating harus berupa angka',
            'rating.min' => 'Rating minimal 1 bintang',
            'rating.max' => 'Rating maksimal 5 bintang',
            'comment.max' => 'Komentar maksimal 1000 karakter',
        ]);

        $review->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return redirect()->route('products.show', $review->product_id)
            ->with('success', 'Review berhasil diperbarui!');
    }

    /**
     * Menghapus review
     */
    public function destroy($reviewId)
    {
        $review = Review::find($reviewId);

        if (!$review) {
            return redirect()->back()->with('error', 'Review tidak ditemukan');
        }

        // Pastikan review milik user yang login
        if ($review->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus review ini');
        }

        $productId = $review->product_id;
        $review->delete();

        return redirect()->route('products.show', $productId)
            ->with('success', 'Review berhasil dihapus!');
    }
}
