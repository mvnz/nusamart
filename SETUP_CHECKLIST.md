# ✅ PBI09 Quick Checklist

## 📦 File yang Sudah Dibuat

- [x] Migration: `database/migrations/2024_04_18_create_reviews_table.php`
- [x] Model: `app/Models/Review.php`
- [x] Controller: `app/Http/Controllers/ReviewController.php`
- [x] Routes: Sudah ditambahkan ke `routes/web.php`
- [x] Blade - Create Form: `resources/views/reviews/create.blade.php`
- [x] Blade - Edit Form: `resources/views/reviews/edit.blade.php`
- [x] Blade - Show All: `resources/views/reviews/show.blade.php`
- [x] Blade - Summary Component: `resources/views/reviews/review-summary.blade.php`
- [x] Documentation: `PBI09_REVIEW_IMPLEMENTATION.md`

## 🚀 Langkah Implementasi

### 1️⃣ Run Migration
```bash
php artisan migrate
```

### 2️⃣ (Opsional) Tambah Relasi ke Product Model
File: `app/Models/Product.php`
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

### 3️⃣ (Opsional) Tambah Relasi ke User Model
File: `app/Models/User.php`
```php
public function reviews()
{
    return $this->hasMany(Review::class);
}
```

### 4️⃣ Tampilkan Review Summary di Product Show Page
File: `resources/views/products/show.blade.php`

Di tempat yang sesuai, tambahkan:
```blade
@include('reviews.review-summary', ['product' => $product])
```

### 5️⃣ Test Fitur
- Buka halaman produk → harus melihat rating summary
- Login dengan user yang belum membeli → klik "Tulis Ulasan" → error message
- Login dengan user yang sudah membeli (order delivered) → bisa tulis review
- Review kedua kalinya → error message "sudah pernah review"

## 📋 Routes yang Tersedia

```
GET    /review/produk/{product}        → ReviewController@create    (form input)
POST   /review/produk/{product}        → ReviewController@store     (save review)
GET    /produk/{product}/reviews       → ReviewController@show      (lihat semua)
GET    /review/{review}/edit           → ReviewController@edit      (form edit)
PUT    /review/{review}                → ReviewController@update    (update)
DELETE /review/{review}                → ReviewController@destroy   (delete)
```

## 🔑 Key Features Implemented

✅ **Validasi Pembelian:**
- Hanya user dengan order status 'completed'/'delivered' bisa review
- Double-check di create dan store

✅ **Unique Constraint:**
- Satu user hanya bisa review 1x per produk
- Database level + aplikasi level

✅ **Rating & Comment:**
- Rating: 1-5 (wajib)
- Comment: max 1000 karakter (opsional)
- Real-time character counter di form

✅ **CRUD:**
- Create, Read, Edit, Delete semua tersedia
- Hanya user pemilik review yang bisa edit/delete

✅ **Statistic:**
- Average rating otomatis
- Rating distribution chart
- Review count

✅ **UI:**
- Form yang user-friendly
- Visual rating (★☆)
- Edit/Delete buttons buat review milik user
- Call-to-action buttons

## 💡 Query Helpers (Di Controller/Blade)

```php
// Get average rating
$avg = Review::getAverageRating($productId);

// Get review count
$count = Review::getReviewCount($productId);

// Get all reviews for product (paginated)
$reviews = Review::forProduct($productId)->paginate(10);

// Get reviews by rating
$fiveStars = Review::forProduct($productId)->byRating(5)->get();

// Check if user has reviewed
$hasReview = Review::where('user_id', auth()->id())
                    ->where('product_id', $productId)
                    ->exists();
```

## 🎯 Acceptance Criteria Status

1. ✅ **Sistem dapat menampilkan rating dan ulasan berdasarkan produk**
   - Ada page `/produk/{id}/reviews` untuk lihat semua
   - Ada component untuk summary di product detail
   - Rating rata-rata dan distribution chart

2. ✅ **Hanya user yang telah membeli produk yang dapat memberikan ulasan**
   - Validasi di controller `create()` dan `store()`
   - Cek OrderItem + order status
   - Error message jika user tidak lolos validasi

## ❗ Important Notes

- Status order harus 'completed' atau 'delivered' untuk bisa review (configurable)
- Unique constraint (user_id, product_id) di database
- Comment max 1000 karakter
- Rating required 1-5
- All CRUD operations authenticated via middleware

## 🧪 Contoh Testing

```bash
# Test di Tinker
php artisan tinker

# Get average rating for product 1
Review::getAverageRating(1)

# Count reviews for product 1
Review::getReviewCount(1)

# Check if user 1 reviewed product 1
Review::where('user_id', 1)->where('product_id', 1)->exists()
```

---

**Ready to deploy!** Jangan lupa run migration dulu 🚀
