@extends('layouts.app')

@section('title', 'Syarat & Ketentuan - NusaMart')

@section('content')
<div class="breadcrumb-section">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Beranda</a></li>
            <li class="active">Syarat & Ketentuan</li>
        </ul>
    </div>
</div>

<section class="info-page-section">
    <div class="container">
        <div class="info-page-card">
            <div class="info-page-header">
                <div class="info-page-icon"><i class="fa fa-file-text"></i></div>
                <h1>Syarat & Ketentuan</h1>
                <p>Terakhir diperbarui: 22 Maret 2026</p>
            </div>

            <div class="info-page-content">
                <h2>1. Ketentuan Umum</h2>
                <p>Dengan mengakses dan menggunakan layanan NusaMart, Anda menyetujui untuk terikat dengan syarat dan ketentuan berikut. Jika Anda tidak setuju dengan syarat dan ketentuan ini, mohon untuk tidak menggunakan layanan kami.</p>

                <h2>2. Akun Pengguna</h2>
                <ul>
                    <li>Pengguna wajib mendaftar dengan informasi yang benar dan akurat.</li>
                    <li>Setiap pengguna bertanggung jawab atas keamanan akun dan password masing-masing.</li>
                    <li>Pengguna dilarang membagikan akses akun kepada pihak lain.</li>
                    <li>NusaMart berhak menangguhkan atau menutup akun yang melanggar ketentuan.</li>
                </ul>

                <h2>3. Ketentuan Pembeli</h2>
                <ul>
                    <li>Pembeli wajib memberikan informasi pengiriman yang lengkap dan benar.</li>
                    <li>Pembayaran harus dilakukan sesuai metode yang tersedia di platform.</li>
                    <li>Pembeli berhak menerima produk sesuai dengan deskripsi yang tertera.</li>
                    <li>Klaim atas produk yang tidak sesuai harus dilakukan dalam waktu 3x24 jam setelah barang diterima.</li>
                </ul>

                <h2>4. Ketentuan Penjual</h2>
                <ul>
                    <li>Penjual wajib menyediakan deskripsi produk yang akurat dan foto yang sesuai.</li>
                    <li>Penjual bertanggung jawab atas kualitas dan keaslian produk yang dijual.</li>
                    <li>Produk yang dijual harus sesuai dengan hukum dan peraturan yang berlaku di Indonesia.</li>
                    <li>Penjual wajib memproses pesanan dalam waktu maksimal 2x24 jam setelah pembayaran dikonfirmasi.</li>
                    <li>Dilarang menjual produk palsu, ilegal, atau berbahaya.</li>
                </ul>

                <h2>5. Produk yang Dilarang</h2>
                <p>Berikut adalah produk yang tidak diperbolehkan dijual di NusaMart:</p>
                <ul>
                    <li>Produk palsu atau tiruan tanpa izin</li>
                    <li>Narkotika dan obat-obatan terlarang</li>
                    <li>Senjata api, tajam, dan bahan peledak</li>
                    <li>Produk yang melanggar hak cipta atau merek dagang</li>
                    <li>Konten dewasa atau pornografi</li>
                </ul>

                <h2>6. Pembayaran</h2>
                <ul>
                    <li>Semua transaksi menggunakan mata uang Rupiah (IDR).</li>
                    <li>Harga produk sudah termasuk pajak kecuali dinyatakan lain.</li>
                    <li>Biaya pengiriman ditanggung oleh pembeli sesuai tarif ekspedisi yang dipilih.</li>
                    <li>Pembatalan pesanan yang sudah dibayar akan diproses sesuai kebijakan pengembalian.</li>
                </ul>

                <h2>7. Penyelesaian Sengketa</h2>
                <p>Jika terjadi sengketa antara pembeli dan penjual, NusaMart akan bertindak sebagai mediator. Keputusan NusaMart bersifat final dan mengikat kedua belah pihak.</p>

                <h2>8. Batasan Tanggung Jawab</h2>
                <p>NusaMart tidak bertanggung jawab atas:</p>
                <ul>
                    <li>Kerugian yang timbul akibat kelalaian pengguna dalam menjaga keamanan akun</li>
                    <li>Gangguan layanan akibat force majeure (bencana alam, gangguan internet, dll)</li>
                    <li>Perbedaan warna produk akibat pengaturan layar perangkat pengguna</li>
                </ul>

                <h2>9. Perubahan Ketentuan</h2>
                <p>NusaMart berhak mengubah syarat dan ketentuan ini kapan saja. Pengguna akan diberitahu melalui email atau notifikasi di platform. Penggunaan layanan setelah perubahan berlaku dianggap sebagai persetujuan atas ketentuan baru.</p>

                <h2>10. Kontak</h2>
                <p>Untuk pertanyaan terkait syarat dan ketentuan, silakan hubungi kami melalui halaman <a href="{{ route('page.kontak') }}">Hubungi Kami</a>.</p>
            </div>
        </div>
    </div>
</section>
@endsection
