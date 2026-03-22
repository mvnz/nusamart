@extends('layouts.app')

@section('title', 'Kebijakan Privasi - NusaMart')

@section('content')
<div class="breadcrumb-section">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Beranda</a></li>
            <li class="active">Kebijakan Privasi</li>
        </ul>
    </div>
</div>

<section class="info-page-section">
    <div class="container">
        <div class="info-page-card">
            <div class="info-page-header">
                <div class="info-page-icon"><i class="fa fa-lock"></i></div>
                <h1>Kebijakan Privasi</h1>
                <p>Terakhir diperbarui: 22 Maret 2026</p>
            </div>

            <div class="info-page-content">
                <h2>1. Informasi yang Kami Kumpulkan</h2>
                <p>Saat Anda menggunakan NusaMart, kami mengumpulkan beberapa informasi sebagai berikut:</p>
                <ul>
                    <li><strong>Informasi Akun:</strong> Nama lengkap, email, username, nomor telepon, dan alamat yang Anda berikan saat mendaftar.</li>
                    <li><strong>Informasi Transaksi:</strong> Detail pesanan, riwayat pembelian, dan informasi pembayaran.</li>
                    <li><strong>Informasi Perangkat:</strong> Jenis perangkat, sistem operasi, browser, dan alamat IP.</li>
                    <li><strong>Cookies:</strong> Data sesi untuk menjaga pengalaman penggunaan yang optimal.</li>
                </ul>

                <h2>2. Penggunaan Informasi</h2>
                <p>Informasi yang kami kumpulkan digunakan untuk:</p>
                <ul>
                    <li>Memproses dan mengelola akun Anda</li>
                    <li>Memproses transaksi dan pengiriman pesanan</li>
                    <li>Mengirimkan notifikasi terkait pesanan dan akun</li>
                    <li>Meningkatkan layanan dan pengalaman pengguna</li>
                    <li>Mendeteksi dan mencegah aktivitas penipuan</li>
                </ul>

                <h2>3. Perlindungan Data</h2>
                <p>Kami menerapkan langkah-langkah keamanan teknis dan organisasi untuk melindungi data pribadi Anda, termasuk:</p>
                <ul>
                    <li>Enkripsi data dengan standar industri</li>
                    <li>Pembatasan akses data hanya untuk pihak yang berwenang</li>
                    <li>Pemantauan sistem keamanan secara berkala</li>
                    <li>Password disimpan dalam bentuk hash yang tidak dapat dibaca</li>
                </ul>

                <h2>4. Berbagi Informasi</h2>
                <p>Kami tidak menjual atau menyewakan data pribadi Anda kepada pihak ketiga. Informasi hanya dapat dibagikan dalam kondisi berikut:</p>
                <ul>
                    <li>Kepada mitra pengiriman untuk memproses pengiriman pesanan</li>
                    <li>Kepada penyedia layanan pembayaran untuk memproses transaksi</li>
                    <li>Jika diwajibkan oleh hukum atau peraturan yang berlaku</li>
                </ul>

                <h2>5. Hak Pengguna</h2>
                <p>Anda memiliki hak untuk:</p>
                <ul>
                    <li>Mengakses dan memperbarui data pribadi Anda melalui halaman profil</li>
                    <li>Meminta penghapusan akun dan data pribadi Anda</li>
                    <li>Menolak pengiriman email promosi</li>
                </ul>

                <h2>6. Perubahan Kebijakan</h2>
                <p>Kami berhak memperbarui kebijakan privasi ini sewaktu-waktu. Perubahan akan diinformasikan melalui halaman ini. Penggunaan layanan setelah perubahan dianggap sebagai persetujuan terhadap kebijakan yang baru.</p>

                <h2>7. Kontak</h2>
                <p>Jika Anda memiliki pertanyaan terkait kebijakan privasi, silakan hubungi kami melalui email di <strong>cs@tokonusamart.com</strong> atau melalui halaman <a href="{{ route('page.kontak') }}">Hubungi Kami</a>.</p>
            </div>
        </div>
    </div>
</section>
@endsection
