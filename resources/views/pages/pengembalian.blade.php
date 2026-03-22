@extends('layouts.app')

@section('title', 'Kebijakan Pengembalian - NusaMart')

@section('content')
<div class="breadcrumb-section">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Beranda</a></li>
            <li class="active">Kebijakan Pengembalian</li>
        </ul>
    </div>
</div>

<section class="info-page-section">
    <div class="container">
        <div class="info-page-card">
            <div class="info-page-header">
                <div class="info-page-icon"><i class="fa fa-refresh"></i></div>
                <h1>Kebijakan Pengembalian</h1>
                <p>Terakhir diperbarui: 22 Maret 2026</p>
            </div>

            <div class="info-page-content">
                <h2><i class="fa fa-question-circle"></i> Kapan Bisa Mengajukan Pengembalian?</h2>
                <p>Anda dapat mengajukan pengembalian produk dalam kondisi berikut:</p>
                <ul>
                    <li>Produk yang diterima tidak sesuai dengan deskripsi atau foto di halaman produk</li>
                    <li>Produk rusak atau cacat saat diterima</li>
                    <li>Jumlah atau jenis produk tidak sesuai dengan pesanan</li>
                    <li>Produk kadaluarsa (untuk produk makanan dan minuman)</li>
                </ul>

                <h2><i class="fa fa-clock-o"></i> Batas Waktu Pengembalian</h2>
                <div class="info-highlight-box">
                    <i class="fa fa-exclamation-circle"></i>
                    <div>
                        <strong>Pengajuan pengembalian harus dilakukan dalam waktu 3x24 jam</strong> setelah produk diterima. Pengajuan yang melewati batas waktu tidak akan diproses.
                    </div>
                </div>

                <h2><i class="fa fa-list-ol"></i> Prosedur Pengembalian</h2>
                <div class="info-steps">
                    <div class="info-step">
                        <div class="info-step-num">1</div>
                        <div class="info-step-content">
                            <h3>Hubungi Customer Service</h3>
                            <p>Kirim email ke cs@tokonusamart.com atau hubungi WhatsApp kami dengan menyertakan nomor pesanan.</p>
                        </div>
                    </div>
                    <div class="info-step">
                        <div class="info-step-num">2</div>
                        <div class="info-step-content">
                            <h3>Lampirkan Bukti</h3>
                            <p>Sertakan foto produk yang diterima beserta foto kemasan dan resi pengiriman.</p>
                        </div>
                    </div>
                    <div class="info-step">
                        <div class="info-step-num">3</div>
                        <div class="info-step-content">
                            <h3>Tunggu Verifikasi</h3>
                            <p>Tim kami akan memverifikasi pengajuan Anda dalam waktu 1x24 jam kerja.</p>
                        </div>
                    </div>
                    <div class="info-step">
                        <div class="info-step-num">4</div>
                        <div class="info-step-content">
                            <h3>Kirim Kembali Produk</h3>
                            <p>Setelah disetujui, kirim produk kembali ke alamat yang kami berikan. Ongkos kirim ditanggung NusaMart.</p>
                        </div>
                    </div>
                    <div class="info-step">
                        <div class="info-step-num">5</div>
                        <div class="info-step-content">
                            <h3>Pengembalian Dana</h3>
                            <p>Dana akan dikembalikan dalam waktu 3-7 hari kerja setelah produk diterima kembali.</p>
                        </div>
                    </div>
                </div>

                <h2><i class="fa fa-ban"></i> Produk yang Tidak Dapat Dikembalikan</h2>
                <ul>
                    <li>Produk yang sudah digunakan atau dipakai</li>
                    <li>Produk custom/pesanan khusus</li>
                    <li>Produk dengan segel/label yang sudah rusak oleh pembeli</li>
                    <li>Produk makanan yang sudah dibuka kemasannya</li>
                    <li>Kerusakan yang disebabkan oleh pembeli</li>
                </ul>

                <h2><i class="fa fa-money"></i> Metode Pengembalian Dana</h2>
                <table class="info-table">
                    <thead>
                        <tr>
                            <th>Metode Pembayaran Asal</th>
                            <th>Estimasi Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Transfer Bank (BCA, BNI, Mandiri)</td>
                            <td>3-5 hari kerja</td>
                        </tr>
                        <tr>
                            <td>GoPay / E-Wallet</td>
                            <td>1-3 hari kerja</td>
                        </tr>
                        <tr>
                            <td>Kartu Kredit / Debit</td>
                            <td>5-7 hari kerja</td>
                        </tr>
                    </tbody>
                </table>

                <h2><i class="fa fa-envelope"></i> Butuh Bantuan?</h2>
                <p>Jika Anda memiliki pertanyaan terkait pengembalian produk, jangan ragu untuk menghubungi kami melalui halaman <a href="{{ route('page.kontak') }}">Hubungi Kami</a>.</p>
            </div>
        </div>
    </div>
</section>
@endsection
