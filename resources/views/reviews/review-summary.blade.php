{{-- Komponen untuk menampilkan ringkasan review di product detail page --}}
{{-- Gunakan: @include('reviews.review-summary', ['product' => $product]) --}}

@php
    $averageRating = \App\Models\Review::getAverageRating($product->id);
    $reviewCount = \App\Models\Review::getReviewCount($product->id);
@endphp

<div class="mt-8 pt-6 border-t">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold text-gray-900">Ulasan Pembeli</h3>
        <a href="{{ route('reviews.show', $product->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
            Lihat Semua
        </a>
    </div>

    <!-- Rating Summary -->
    <div class="bg-gray-50 p-4 rounded-lg mb-6">
        <div class="flex items-center gap-4">
            <div class="text-center">
                <div class="text-4xl font-bold text-gray-900">{{ number_format($averageRating, 1) }}</div>
                <div class="text-yellow-400 text-xl mt-1">
                    @for($i = 1; $i <= 5; $i++)
                        <span>@if($i <= round($averageRating))★@else☆@endif</span>
                    @endfor
                </div>
                <p class="text-gray-600 text-sm mt-2">{{ $reviewCount }} ulasan</p>
            </div>

            <div class="flex-1">
                {{-- Rating distribution --}}
                @php
                    $ratingCounts = [];
                    for($i = 5; $i >= 1; $i--) {
                        $ratingCounts[$i] = \App\Models\Review::forProduct($product->id)->byRating($i)->count();
                    }
                @endphp

                @for($i = 5; $i >= 1; $i--)
                    <div class="flex items-center gap-2 text-sm mb-2">
                        <span class="w-12 text-yellow-400">
                            @for($j = 1; $j <= $i; $j++)★@endfor@for($j = $i; $j < 5; $j++)☆@endfor
                        </span>
                        <div class="flex-1 bg-gray-300 h-2 rounded-full overflow-hidden">
                            <div class="bg-yellow-400 h-full transition-all" 
                                 style="width: {{ $reviewCount > 0 ? ($ratingCounts[$i] / $reviewCount * 100) : 0 }}%"></div>
                        </div>
                        <span class="w-12 text-right text-gray-600">{{ $ratingCounts[$i] }}</span>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    @auth
        @php
            $userReview = \App\Models\Review::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->first();
        @endphp

        @if(!$userReview)
            <a href="{{ route('reviews.create', $product->id) }}" 
               class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                Tulis Ulasan
            </a>
        @endif
    @else
        <a href="{{ route('login') }}" 
           class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
            Login untuk Memberi Ulasan
        </a>
    @endauth
</div>
