@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header & Rating Summary -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Ulasan Produk</h1>
                    <p class="text-gray-600 mt-1">{{ $product->name }}</p>
                </div>
                <div class="text-right">
                    <div class="flex items-center gap-2 justify-end">
                        <span class="text-4xl font-bold text-yellow-400">
                            {{ number_format($averageRating, 1) }}
                        </span>
                        <div>
                            <div class="text-yellow-400 text-xl">
                                @for($i = 1; $i <= 5; $i++)
                                    <span>@if($i <= round($averageRating))★@else☆@endif</span>
                                @endfor
                            </div>
                            <p class="text-gray-600 text-sm">{{ $reviewCount }} ulasan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Tambah Review -->
            @auth
                @if(!$userReview)
                    <a href="{{ route('reviews.create', $product->id) }}" 
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                        Tulis Ulasan Anda
                    </a>
                @else
                    <div class="text-sm text-gray-600">
                        ✓ Anda sudah memberikan ulasan untuk produk ini
                    </div>
                @endif
            @else
                <a href="{{ route('login') }}" 
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                    Login untuk Memberi Ulasan
                </a>
            @endauth
        </div>

        <!-- Ulasan User Saat Ini -->
        @if($userReview)
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 border-l-4 border-blue-500">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Ulasan Anda</h3>
                        <p class="text-yellow-400 text-lg mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $userReview->rating)★@else☆@endif
                            @endfor
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('reviews.edit', $userReview->id) }}" 
                           class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                            Edit
                        </a>
                        <form action="{{ route('reviews.destroy', $userReview->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm"
                                    onclick="return confirm('Yakin ingin menghapus ulasan?')">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
                @if($userReview->comment)
                    <p class="text-gray-700 mb-3">{{ $userReview->comment }}</p>
                @endif
                <p class="text-gray-500 text-sm">
                    {{ $userReview->created_at->locale('id')->diffForHumans() }}
                </p>
            </div>
        @endif

        <!-- Daftar Semua Ulasan -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Semua Ulasan ({{ $reviewCount }})</h2>
            </div>

            @forelse($reviews as $review)
                <div class="px-6 py-4 border-b border-gray-200 hover:bg-gray-50 transition">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $review->user->name }}</h3>
                            <p class="text-yellow-400 text-lg">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)★@else☆@endif
                                @endfor
                            </p>
                        </div>
                        <p class="text-gray-500 text-sm">
                            {{ $review->created_at->locale('id')->diffForHumans() }}
                        </p>
                    </div>

                    @if($review->comment)
                        <p class="text-gray-700 mt-2">{{ $review->comment }}</p>
                    @endif
                </div>
            @empty
                <div class="px-6 py-12 text-center">
                    <p class="text-gray-500">Belum ada ulasan untuk produk ini</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($reviews->hasPages())
            <div class="mt-6">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
