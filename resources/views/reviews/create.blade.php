@extends('layouts.app')

@section('title', 'Tulis Ulasan - NusaMart')

@push('styles')
<style>
.rv-page { padding: 30px 0 60px; }
.rv-breadcrumb { font-size: 13px; color: #888; margin-bottom: 20px; }
.rv-breadcrumb a { color: #D10024; text-decoration: none; }
.rv-breadcrumb span { margin: 0 6px; }

.rv-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,.07); padding: 32px; max-width: 680px; margin: 0 auto; }

.rv-page-title { font-size: 20px; font-weight: 800; color: #1e1f29; display: flex; align-items: center; gap: 10px; margin-bottom: 4px; }
.rv-page-title i { color: #D10024; }
.rv-page-sub { font-size: 13px; color: #888; margin-bottom: 24px; }

.rv-product-box { display: flex; gap: 16px; align-items: center; padding: 16px; background: #f8f9fa; border-radius: 10px; margin-bottom: 28px; }
.rv-product-img { width: 72px; height: 72px; border-radius: 8px; object-fit: cover; background: #eee; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
.rv-product-img img { width: 72px; height: 72px; border-radius: 8px; object-fit: cover; }
.rv-product-img i { font-size: 28px; color: #ccc; }
.rv-product-name { font-size: 15px; font-weight: 700; color: #1e1f29; margin-bottom: 4px; }
.rv-product-price { font-size: 15px; font-weight: 800; color: #D10024; }

.rv-form-group { margin-bottom: 22px; }
.rv-label { font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 10px; display: block; }

/* Star rating */
.rv-stars { display: flex; gap: 6px; }
.rv-stars input[type=radio] { display: none; }
.rv-stars label { font-size: 36px; color: #d1d5db; cursor: pointer; line-height: 1; transition: color .15s; }
.rv-stars input[type=radio]:checked ~ label,
.rv-stars label:hover,
.rv-stars label:hover ~ label { color: #d1d5db; }
.rv-stars input[type=radio]:checked + label,
.rv-stars label:hover { color: #f59e0b; }
/* Forward fill trick — stars are reversed in DOM */
.rv-stars { flex-direction: row-reverse; justify-content: flex-end; }
.rv-stars label:hover,
.rv-stars label:hover ~ label { color: #f59e0b; }
.rv-stars input[type=radio]:checked ~ label { color: #f59e0b; }

.rv-star-hint { font-size: 12px; color: #aaa; margin-top: 6px; }

.rv-textarea { width: 100%; padding: 12px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-family: inherit; resize: vertical; min-height: 110px; color: #1e1f29; box-sizing: border-box; transition: border-color .2s; }
.rv-textarea:focus { outline: none; border-color: #D10024; }
.rv-char-count { font-size: 12px; color: #aaa; margin-top: 6px; text-align: right; }

.rv-error { font-size: 12px; color: #ef4444; margin-top: 6px; }
.rv-alert-error { background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; }

.rv-actions { display: flex; gap: 12px; margin-top: 8px; }
.rv-btn-submit { flex: 1; padding: 12px; background: #D10024; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; transition: background .2s; font-family: inherit; }
.rv-btn-submit:hover { background: #a8001e; }
.rv-btn-cancel { flex: 1; padding: 12px; background: #f4f5f7; color: #555; border: none; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; text-decoration: none; text-align: center; transition: background .2s; font-family: inherit; }
.rv-btn-cancel:hover { background: #e5e7eb; color: #333; }
</style>
@endpush

@section('content')
<div class="rv-page">
    <div class="container">

        <div class="rv-breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span>&rsaquo;</span>
            <a href="{{ route('orders.index') }}">Pesanan Saya</a>
            <span>&rsaquo;</span>
            <span>Tulis Ulasan</span>
        </div>

        <div class="rv-card">
            <h1 class="rv-page-title"><i class="fa fa-star"></i> Berikan Ulasan Produk</h1>
            <p class="rv-page-sub">Bagikan pengalaman Anda membeli produk ini</p>

            @if($errors->any())
                <div class="rv-alert-error"><i class="fa fa-exclamation-circle"></i> {{ $errors->first() }}</div>
            @endif

            <!-- Info Produk -->
            <div class="rv-product-box">
                <div class="rv-product-img">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <i class="fa fa-shopping-bag"></i>
                    @endif
                </div>
                <div>
                    <div class="rv-product-name">{{ $product->name }}</div>
                    <div class="rv-product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                </div>
            </div>

            <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                @csrf

                <!-- Rating -->
                <div class="rv-form-group">
                    <label class="rv-label">Rating <span style="color:#D10024">*</span></label>
                    <div class="rv-stars">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}"
                                   @if(old('rating') == $i) checked @endif>
                            <label for="star{{ $i }}">&#9733;</label>
                        @endfor
                    </div>
                    @error('rating')
                        <div class="rv-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <!-- Komentar -->
                <div class="rv-form-group">
                    <label for="comment" class="rv-label">Komentar <span style="color:#aaa;font-weight:400">(Opsional)</span></label>
                    <textarea id="comment" name="comment" class="rv-textarea"
                              placeholder="Ceritakan pengalaman Anda dengan produk ini..."
                              maxlength="1000">{{ old('comment') }}</textarea>
                    @error('comment')
                        <div class="rv-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                    <div class="rv-char-count"><span id="char-count">0</span> / 1000</div>
                </div>

                <div class="rv-actions">
                    <button type="submit" class="rv-btn-submit"><i class="fa fa-paper-plane"></i> Kirim Ulasan</button>
                    <a href="{{ route('products.show', $product->id) }}" class="rv-btn-cancel">Batal</a>
                </div>
            </form>
        </div>

    </div>
</div>

@push('scripts')
<script>
    const textarea = document.getElementById('comment');
    const charCount = document.getElementById('char-count');
    textarea.addEventListener('input', function() { charCount.textContent = this.value.length; });
    charCount.textContent = textarea.value.length;
</script>
@endpush
@endsection
