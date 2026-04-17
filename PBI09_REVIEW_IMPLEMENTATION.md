# PBI09 - Implementasi Fitur Rating & Review Produk

## 📋 Daftar File yang Dibuat

### 1. **Migration**
```
database/migrations/2024_04_18_create_reviews_table.php
```
- Membuat tabel `reviews` dengan fields:
  - `id` (Primary Key)
  - `user_id` (FK ke users)
  - `product_id` (FK ke products)
  - `order_id` (FK ke orders)
  - `rating` (1-5)
  - `comment` (nullable)
  - `created_at`, `updated_at`
  - Unique constraint pada (user_id, product_id)

### 2. **Model**
```
app/Models/Review.php
```
**Relasi:**
- `user()` - Pemilik review
- `product()` - Produk yang di-review
- `order()` - Order terkait

**Methods:**
- `getStarDisplayAttribute()` - Return visual rating (★☆)
- `scopeByRating($rating)` - Filter by rating
- `scopeForProduct($productId)` - Filter by product
- `getAverageRating($productId)` - Static method untuk rata-rata rating
- `getReviewCount($productId)` - Static method untuk jumlah review

### 3. **Controller**
```
app/Http/Controllers/ReviewController.php
```
**Methods:**
- `create($productId)` - Form input review (dengan validasi pembelian)
- `store(Request $request, $productId)` - Simpan review
- `show($productId)` - Tampilkan semua review produk
- `edit($reviewId)` - Form edit review
- `update(Request $request, $reviewId)` - Update review
- `destroy($reviewId)` - Hapus review

**Validasi Pembelian:**
- Cek OrderItem: user harus sudah membeli produk
- Cek Order status: hanya 'completed' atau 'delivered'
- Cek unique review: satu user hanya bisa review 1x per produk

### 4. **Routes**
```
routes/web.php
```
```php
// Review routes (authenticated)
Route::get('/review/produk/{product:id}', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/review/produk/{product:id}', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/review/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
Route::put('/review/{review}', [ReviewController::class, 'update'])->name('reviews.update');
Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

// Public review display
Route::get('/produk/{product:id}/reviews', [ReviewController::class, 'show'])->name('reviews.show');
```

### 5. **Blade Templates**
```
resources/views/reviews/
├── create.blade.php      - Form input review
├── edit.blade.php        - Form edit review
├── show.blade.php        - Tampilkan semua review produk
└── review-summary.blade.php  - Component ringkasan review (untuk product detail)
```

---

## 🚀 Setup & Integrasi

### Step 1: Run Migration
```bash
php artisan migrate
```

### Step 2: Update Product Model (Relasi Opsional)
Tambahkan ke `app/Models/Product.php`:
```php
public function reviews()
{
    return $this->hasMany(Review::class);
}

public function getAverageRatingAttribute()
{
    return Review::getAverageRating($this->id);
}

public function getReviewCountAttribute()
{
    return Review::getReviewCount($this->id);
}
```

### Step 3: Update User Model (Relasi Opsional)
Tambahkan ke `app/Models/User.php`:
```php
public function reviews()
{
    return $this->hasMany(Review::class);
}
```

### Step 4: Integrasikan Component di Product Detail Page
Edit `resources/views/products/show.blade.php`:
```blade
<!-- Tempat yang sesuai di product detail page -->
@include('reviews.review-summary', ['product' => $product])

<!-- Atau untuk menampilkan review lengkap -->
<a href="{{ route('reviews.show', $product->id) }}" class="btn btn-primary">
    Lihat Semua Ulasan
</a>
```

### Step 5: Tambahkan Link di Order Page (Opsional)
Di halaman pesanan, tambahkan tombol untuk review:
```blade
@if($order->status === 'delivered' || $order->status === 'completed')
    @foreach($order->items as $item)
        @php
            $hasReview = \App\Models\Review::where('user_id', auth()->id())
                ->where('product_id', $item->product_id)
                ->exists();
        @endphp
        
        @if(!$hasReview)
            <a href="{{ route('reviews.create', $item->product_id) }}" class="btn btn-sm btn-outline">
                Beri Ulasan
            </a>
        @endif
    @endforeach
@endif
```

---

## ✅ Acceptance Criteria Terpenuhi

### 1. ✅ Sistem dapat menampilkan rating dan ulasan berdasarkan produk
- **Show Page:** `reviews/show.blade.php` menampilkan semua review
- **Summary Component:** `reviews/review-summary.blade.php` menampilkan ringkasan
- **Average Rating:** Otomatis dihitung dengan `Review::getAverageRating($productId)`
- **Rating Distribution:** Grafik batang rating 1-5

### 2. ✅ Hanya user yang telah membeli produk yang dapat memberikan ulasan
- **Validasi di `ReviewController::create()`:**
  - Cek OrderItem dengan product_id = $productId
  - Cek User = Auth::user()
  - Cek Order status = 'completed' atau 'delivered'
  - Jika tidak lolos → redirect dengan pesan error
  
- **Validasi di `ReviewController::store()`:**
  - Double-check sebelum insert
  - Validasi unique constraint di database

---

## 📝 Cara Penggunaan

### Untuk Pembeli:
1. Setelah order diterima (status = 'delivered' atau 'completed')
2. Kunjungi halaman produk: `/produk/{product-id}`
3. Klik "Tulis Ulasan" atau button "Lihat Semua Ulasan"
4. Isi rating (1-5 bintang) dan komentar (opsional)
5. Klik "Kirim Ulasan"

### Untuk Developer (Query Examples):

**Dapatkan rating rata-rata produk:**
```php
$avgRating = Review::getAverageRating($productId); // float
```

**Dapatkan jumlah review produk:**
```php
$count = Review::getReviewCount($productId); // int
```

**Dapatkan semua review produk (terbaru dulu):**
```php
$reviews = Review::forProduct($productId)->paginate(10);
```

**Filter by rating:**
```php
$fiveStarReviews = Review::forProduct($productId)->byRating(5)->get();
```

**Cek apakah user sudah review produk:**
```php
$hasReview = Review::where('user_id', auth()->id())
    ->where('product_id', $productId)
    ->exists();
```

---

## 🔧 Customization

### Mengubah Validasi Pembelian
Edit `app/Http/Controllers/ReviewController.php` → `create()` method:
```php
// Ubah status order yang diizinkan:
$query->whereIn('status', ['completed', 'delivered']);
// Menjadi:
$query->whereIn('status', ['completed', 'delivered', 'shipped']);
```

### Mengubah Max Characters Comment
Di Controller:
```php
'comment' => 'nullable|string|max:1000', // ubah 1000
```
Di Blade:
```blade
maxlength="1000" {{-- ubah 1000 --}}
```

### Menampilkan Rating di Product List
Edit `resources/views/products/index.blade.php`:
```blade
@php
    $avgRating = \App\Models\Review::getAverageRating($product->id);
@endphp

<div class="rating">
    @for($i = 1; $i <= 5; $i++)
        <span class="@if($i <= round($avgRating)) text-yellow-400 @else text-gray-300 @endif">
            ★
        </span>
    @endfor
    <span class="text-gray-600 text-sm">({{ \App\Models\Review::getReviewCount($product->id) }})</span>
</div>
```

---

## 🐛 Testing

### Test Case 1: User yang belum membeli tidak bisa review
```php
// Login dengan user tanpa order untuk produk ini
// Coba akses /review/produk/1
// Expected: Error message "Anda hanya dapat memberikan review untuk produk yang telah dibeli"
```

### Test Case 2: User hanya bisa review 1x per produk
```php
// Login user yang sudah review produk
// Coba akses /review/produk/1 lagi
// Expected: Info message "Anda sudah memberikan review untuk produk ini"
```

### Test Case 3: Edit dan hapus review
```php
// Login user, edit review → update berhasil
// Hapus review → review hilang dari list
// Expected: Tombol "Tulis Ulasan" muncul lagi
```

---

## 📊 Database Schema

```sql
CREATE TABLE reviews (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    order_id BIGINT UNSIGNED NOT NULL,
    rating INT UNSIGNED NOT NULL (1-5),
    comment LONGTEXT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_product (user_id, product_id)
);
```

---

## 🎨 Styling Notes

Template menggunakan **Tailwind CSS** dengan class utility. Jika project menggunakan framework CSS lain:
- Ganti `bg-blue-600`, `text-white`, dll dengan class framework Anda
- Atau custom className di template sesuai kebutuhan

---

## 📌 Next Steps (Opsional)

1. **Email Notification:** Kirim email ke seller saat ada review baru
2. **Admin Review Moderation:** Admin bisa hide/approve review
3. **Review Badges:** Badge "Verified Purchase" untuk review dari pembeli
4. **Review Image Upload:** User bisa upload foto saat memberi review
5. **Review Helpful Vote:** User lain bisa vote "helpful" untuk review
6. **Review Response:** Seller bisa reply ulasan pembeli

---

**Status:** ✅ Selesai - Siap untuk testing dan deployment
**Date:** 18 April 2026
