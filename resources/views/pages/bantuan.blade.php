@extends('layouts.app')

@section('title', 'Bantuan - NusaMart')

@section('content')
<div class="breadcrumb-section">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Beranda</a></li>
            <li class="active">Bantuan</li>
        </ul>
    </div>
</div>

<section class="info-page-section">
    <div class="container">
        <div class="info-page-card">
            <div class="info-page-header">
                <div class="info-page-icon"><i class="fa fa-life-ring"></i></div>
                <h1>Pusat Bantuan</h1>
                <p>Temukan jawaban atas pertanyaan Anda seputar belanja di NusaMart</p>
            </div>

            <div class="info-page-content">
                <h2><i class="fa fa-shopping-cart"></i> Pemesanan</h2>
                <div class="faq-item">
                    <h3>Bagaimana cara melakukan pemesanan?</h3>
                    <p>Pilih produk yang diinginkan, klik "Tambah ke Keranjang", lalu klik ikon keranjang untuk menuju halaman checkout. Isi data pengiriman dan pilih metode pembayaran, kemudian konfirmasi pesanan Anda.</p>
                </div>
                <div class="faq-item">
                    <h3>Bisakah saya membatalkan pesanan?</h3>
                    <p>Pesanan dapat dibatalkan selama status masih "Menunggu Pembayaran" atau "Diproses". Setelah pesanan dikirim, pembatalan tidak dapat dilakukan. Hubungi customer service kami untuk bantuan pembatalan.</p>
                </div>
                <div class="faq-item">
                    <h3>Bagaimana cara melacak pesanan saya?</h3>
                    <p>Masuk ke akun Anda, buka menu "Pesanan Saya", dan klik detail pesanan. Anda akan melihat nomor resi dan status pengiriman terkini.</p>
                </div>

                <h2><i class="fa fa-credit-card"></i> Pembayaran</h2>
                <div class="faq-item">
                    <h3>Metode pembayaran apa saja yang tersedia?</h3>
                    <p>NusaMart menerima pembayaran melalui transfer bank (BCA, BNI, Mandiri), e-wallet (GoPay, OVO, Dana), kartu kredit/debit (Visa, Mastercard), dan virtual account.</p>
                </div>
                <div class="faq-item">
                    <h3>Berapa lama batas waktu pembayaran?</h3>
                    <p>Batas waktu pembayaran adalah 1x24 jam setelah pesanan dibuat. Jika pembayaran tidak dilakukan dalam waktu tersebut, pesanan akan otomatis dibatalkan.</p>
                </div>
                <div class="faq-item">
                    <h3>Apakah pembayaran di NusaMart aman?</h3>
                    <p>Ya, semua transaksi di NusaMart dilindungi dengan enkripsi SSL dan sistem keamanan berlapis untuk menjaga data pembayaran Anda.</p>
                </div>

                <h2><i class="fa fa-truck"></i> Pengiriman</h2>
                <div class="faq-item">
                    <h3>Berapa lama estimasi pengiriman?</h3>
                    <p>Estimasi pengiriman tergantung lokasi tujuan dan jasa pengiriman yang dipilih. Umumnya 2-5 hari kerja untuk pulau Jawa dan 5-10 hari kerja untuk luar Jawa.</p>
                </div>
                <div class="faq-item">
                    <h3>Berapa ongkos kirimnya?</h3>
                    <p>Ongkos kirim dihitung berdasarkan berat produk dan lokasi tujuan pengiriman. Rincian ongkos kirim akan ditampilkan di halaman checkout sebelum Anda melakukan pembayaran.</p>
                </div>

                <h2><i class="fa fa-refresh"></i> Pengembalian & Refund</h2>
                <div class="faq-item">
                    <h3>Bagaimana jika barang yang diterima rusak?</h3>
                    <p>Segera hubungi customer service kami dalam waktu 2x24 jam setelah barang diterima dengan menyertakan foto bukti kerusakan. Kami akan memproses pengembalian atau penggantian produk.</p>
                </div>
                <div class="faq-item">
                    <h3>Berapa lama proses refund?</h3>
                    <p>Proses refund memakan waktu 3-7 hari kerja setelah pengajuan pengembalian disetujui. Dana akan dikembalikan ke metode pembayaran yang sama saat pemesanan.</p>
                </div>

                <h2><i class="fa fa-user"></i> Akun</h2>
                <div class="faq-item">
                    <h3>Bagaimana cara mendaftar akun?</h3>
                    <p>Klik tombol "Daftar" di halaman utama, isi data diri Anda (nama, email, dan password), lalu verifikasi email untuk mengaktifkan akun.</p>
                </div>
                <div class="faq-item">
                    <h3>Saya lupa password, bagaimana cara mengatasinya?</h3>
                    <p>Klik "Lupa Password?" di halaman login, masukkan email yang terdaftar, dan kami akan mengirimkan link untuk mengatur ulang password Anda.</p>
                </div>

                <h2><i class="fa fa-headphones"></i> Masih Butuh Bantuan?</h2>
                <div class="info-features-grid">
                    <div class="info-feature-item">
                        <div class="info-feature-icon"><i class="fa fa-envelope-o"></i></div>
                        <h3>Email</h3>
                        <p>cs@tokonusamart.com<br>Respon dalam 1x24 jam</p>
                    </div>
                    <div class="info-feature-item">
                        <div class="info-feature-icon"><i class="fa fa-whatsapp"></i></div>
                        <h3>WhatsApp</h3>
                        <p>+62 812-0000-0000<br>Senin - Jumat, 08:00 - 17:00</p>
                    </div>
                    <div class="info-feature-item">
                        <div class="info-feature-icon"><i class="fa fa-phone"></i></div>
                        <h3>Telepon</h3>
                        <p>+62 21-1000-000<br>Senin - Jumat, 08:00 - 17:00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
