@extends('layouts.app')

@section('title', 'Tentang NusaMart')

@section('content')
<div class="breadcrumb-section">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Beranda</a></li>
            <li class="active">Tentang NusaMart</li>
        </ul>
    </div>
</div>

<section class="info-page-section">
    <div class="container">
        <div class="info-page-card">
            <div class="info-page-header">
                <div class="info-page-icon"><i class="fa fa-info-circle"></i></div>
                <h1>Tentang NusaMart</h1>
                <p>Mengenal lebih dekat marketplace produk lokal UMKM Desa Manud Jaya</p>
            </div>

            <div class="info-page-content">
                <h2><i class="fa fa-building"></i> Siapa Kami?</h2>
                <p>NusaMart adalah marketplace produk lokal yang didedikasikan untuk menghubungkan Usaha Mikro, Kecil, dan Menengah (UMKM) Desa Manud Jaya dengan pembeli di seluruh Indonesia. Kami percaya bahwa produk unggulan desa memiliki kualitas yang tidak kalah dengan produk lainnya.</p>

                <h2><i class="fa fa-eye"></i> Visi</h2>
                <p>Menjadi marketplace terdepan yang memajukan produk lokal dan memberdayakan UMKM Desa Manud Jaya.</p>

                <h2><i class="fa fa-bullseye"></i> Misi</h2>
                <ul>
                    <li>Menyediakan platform jual beli yang mudah, aman, dan terpercaya bagi UMKM Desa Manud Jaya</li>
                    <li>Memperkenalkan produk-produk unggulan desa ke pasar yang lebih luas</li>
                    <li>Memberikan pengalaman belanja online yang nyaman bagi seluruh pelanggan</li>
                    <li>Mendukung pertumbuhan ekonomi Desa Manud Jaya melalui digitalisasi UMKM</li>
                </ul>

                <h2><i class="fa fa-star"></i> Mengapa Memilih NusaMart?</h2>
                <div class="info-features-grid">
                    <div class="info-feature-item">
                        <div class="info-feature-icon"><i class="fa fa-check-circle"></i></div>
                        <h3>Produk Asli Desa Manud Jaya</h3>
                        <p>Semua produk dijamin keasliannya langsung dari pengrajin dan UMKM Desa Manud Jaya.</p>
                    </div>
                    <div class="info-feature-item">
                        <div class="info-feature-icon"><i class="fa fa-shield"></i></div>
                        <h3>Pembayaran Aman</h3>
                        <p>Sistem pembayaran yang terenkripsi dan terpercaya untuk keamanan transaksi Anda.</p>
                    </div>
                    <div class="info-feature-item">
                        <div class="info-feature-icon"><i class="fa fa-truck"></i></div>
                        <h3>Pengiriman Luas</h3>
                        <p>Jaringan pengiriman ke seluruh Indonesia dengan berbagai pilihan ekspedisi.</p>
                    </div>
                    <div class="info-feature-item">
                        <div class="info-feature-icon"><i class="fa fa-headphones"></i></div>
                        <h3>Dukungan 24/7</h3>
                        <p>Tim customer service kami siap membantu Anda kapan saja.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
