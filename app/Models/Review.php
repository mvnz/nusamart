<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'rating',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relasi ke Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Accessor untuk rating bintang visual
     */
    public function getStarDisplayAttribute(): string
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    /**
     * Scope untuk mendapatkan review dengan rating tertentu
     */
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Scope untuk mendapatkan review berdasarkan produk
     */
    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId)->orderBy('created_at', 'desc');
    }

    /**
     * Mendapatkan rating rata-rata produk
     */
    public static function getAverageRating($productId)
    {
        return static::where('product_id', $productId)->avg('rating') ?? 0;
    }

    /**
     * Mendapatkan jumlah review untuk produk
     */
    public static function getReviewCount($productId)
    {
        return static::where('product_id', $productId)->count();
    }
}
