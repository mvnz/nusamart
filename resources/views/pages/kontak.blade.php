@extends('layouts.app')

@section('title', 'Hubungi Kami - NusaMart')

@section('content')
<div class="breadcrumb-section">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Beranda</a></li>
            <li class="active">Hubungi Kami</li>
        </ul>
    </div>
</div>

<section class="info-page-section">
    <div class="container">
        <div class="info-page-card">
            <div class="info-page-header">
                <div class="info-page-icon"><i class="fa fa-envelope"></i></div>
                <h1>Hubungi Kami</h1>
                <p>Kami siap membantu Anda. Jangan ragu untuk menghubungi kami.</p>
            </div>

            <div class="info-page-content">
                <div class="contact-grid">
                    <div class="contact-card">
                        <div class="contact-card-icon"><i class="fa fa-map-marker"></i></div>
                        <h3>Alamat</h3>
                        <p>Jakarta, Indonesia</p>
                    </div>
                    <div class="contact-card">
                        <div class="contact-card-icon"><i class="fa fa-phone"></i></div>
                        <h3>Telepon</h3>
                        <p>+62 21-1000-000<br>Senin - Jumat, 08:00 - 17:00 WIB</p>
                    </div>
                    <div class="contact-card">
                        <div class="contact-card-icon"><i class="fa fa-envelope-o"></i></div>
                        <h3>Email</h3>
                        <p>cs@tokonusamart.com<br>Respon dalam 1x24 jam</p>
                    </div>
                    <div class="contact-card">
                        <div class="contact-card-icon"><i class="fa fa-whatsapp"></i></div>
                        <h3>WhatsApp</h3>
                        <p>+62 812-0000-0000<br>Chat langsung dengan CS kami</p>
                    </div>
                </div>

                <h2><i class="fa fa-clock-o"></i> Jam Operasional</h2>
                <table class="info-table">
                    <tr>
                        <td>Senin - Jumat</td>
                        <td>08:00 - 17:00 WIB</td>
                    </tr>
                    <tr>
                        <td>Sabtu</td>
                        <td>09:00 - 15:00 WIB</td>
                    </tr>
                    <tr>
                        <td>Minggu & Hari Libur</td>
                        <td>Tutup</td>
                    </tr>
                </table>

                <h2><i class="fa fa-question-circle"></i> FAQ</h2>
                <div class="faq-item">
                    <h3>Bagaimana cara melakukan pemesanan?</h3>
                    <p>Pilih produk yang diinginkan, tambahkan ke keranjang, lalu lanjutkan ke pembayaran. Ikuti langkah-langkah yang tertera di halaman checkout.</p>
                </div>
                <div class="faq-item">
                    <h3>Berapa lama waktu pengiriman?</h3>
                    <p>Waktu pengiriman bervariasi tergantung lokasi dan layanan ekspedisi yang dipilih, umumnya 2-7 hari kerja.</p>
                </div>
                <div class="faq-item">
                    <h3>Bagaimana cara menjadi penjual di NusaMart?</h3>
                        <p>Daftar akun dengan memilih peran "Penjual" sebagai pelaku UMKM Desa Manud Jaya, lengkapi profil, dan mulai berjualan di NusaMart.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
