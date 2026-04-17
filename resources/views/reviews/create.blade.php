@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Berikan Ulasan Produk</h1>
            <p class="text-gray-600">Bagikan pengalaman Anda membeli produk ini</p>
        </div>

        <!-- Produk Info -->
        <div class="flex gap-4 mb-8 pb-8 border-b">
            @if($product->image)
                <img src="{{ asset('uploads/' . $product->image) }}" 
                     alt="{{ $product->name }}" 
                     class="w-24 h-24 object-cover rounded-lg">
            @else
                <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                    <span class="text-gray-400">No Image</span>
                </div>
            @endif
            
            <div class="flex-1">
                <h2 class="text-xl font-semibold text-gray-900">{{ $product->name }}</h2>
                <p class="text-gray-600 text-sm mt-1">{{ Str::limit($product->description, 100) }}</p>
                <p class="text-lg font-bold text-blue-600 mt-2">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('reviews.store', $product->id) }}" method="POST">
            @csrf

            <!-- Rating -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Rating</label>
                <div class="flex gap-2">
                    @for($i = 1; $i <= 5; $i++)
                        <label class="cursor-pointer group relative">
                            <input type="radio" name="rating" value="{{ $i }}" 
                                   class="sr-only peer" 
                                   @if(old('rating') == $i) checked @endif>
                            <span class="text-4xl text-gray-300 peer-checked:text-yellow-400 group-hover:text-yellow-300 transition">
                                ★
                            </span>
                        </label>
                    @endfor
                </div>
                @error('rating')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Komentar -->
            <div class="mb-6">
                <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                    Komentar (Opsional)
                </label>
                <textarea id="comment" name="comment" rows="5" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                          placeholder="Bagikan pengalaman Anda... max 1000 karakter"
                          maxlength="1000">{{ old('comment') }}</textarea>
                @error('comment')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-2" id="char-count">0 / 1000</p>
            </div>

            <!-- Tombol -->
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                    Kirim Ulasan
                </button>
                <a href="{{ route('products.show', $product->id) }}" 
                   class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg text-center transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const textarea = document.getElementById('comment');
    const charCount = document.getElementById('char-count');
    
    textarea.addEventListener('input', function() {
        charCount.textContent = this.value.length + ' / 1000';
    });
    
    // Initialize on page load
    charCount.textContent = textarea.value.length + ' / 1000';
</script>
@endsection
