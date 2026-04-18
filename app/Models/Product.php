<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'category',
        'image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function promos()
    {
        return $this->hasMany(Promo::class);
    }

    /**
     * Ambil promo aktif untuk produk ini (jika ada)
     */
    public function activePromo()
    {
        return $this->promos()
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
    }

    /**
     * Cek apakah produk sedang ada promo
     */
    public function hasActivePromo(): bool
    {
        $promo = $this->activePromo();
        return $promo && $promo->isActive();
    }

    /**
     * Dapatkan harga promo (jika ada), jika tidak kembalikan harga normal
     */
    public function getDisplayPrice()
    {
        $promo = $this->activePromo();
        if ($promo && $promo->isActive()) {
            return $promo->promo_price;
        }
        return $this->price;
    }

    /**
     * Dapatkan promo aktif beserta info discount
     */
    public function getPromoInfo(): ?array
    {
        $promo = $this->activePromo();
        if (!$promo) {
            return null;
        }

        return [
            'id' => $promo->id,
            'original_price' => $promo->original_price,
            'promo_price' => $promo->promo_price,
            'discount_percentage' => $promo->getDiscountPercentage(),
            'end_date' => $promo->end_date,
            'remaining_quota' => $promo->getRemainingQuota(),
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
