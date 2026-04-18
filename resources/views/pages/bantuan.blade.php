@extends('layouts.app')

@section('title', 'Pusat Bantuan - NusaMart')

@push('styles')
<style>
/* ── Hero ── */
.hb-hero {
    background: linear-gradient(135deg, #1a1a2e 0%, #2d1b3d 50%, #1a1a2e 100%);
    padding: 52px 0 48px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.hb-hero::before {
    content: '';
    position: absolute;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(209,0,36,.25) 0%, transparent 70%);
    top: -100px; left: 50%; transform: translateX(-50%);
    pointer-events: none;
}
.hb-hero-icon {
    width: 72px; height: 72px; border-radius: 20px;
    background: rgba(209,0,36,.15);
    border: 1.5px solid rgba(209,0,36,.35);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
    font-size: 28px; color: #D10024;
    position: relative; z-index: 1;
    animation: hbPulse 2.5s infinite;
}
@keyframes hbPulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(209,0,36,.3); }
    50%      { box-shadow: 0 0 0 14px rgba(209,0,36,0); }
}
.hb-hero h1 { font-size: 28px; font-weight: 800; color: #fff; position: relative; z-index: 1; margin-bottom: 8px; }
.hb-hero p  { font-size: 14px; color: rgba(255,255,255,.6); position: relative; z-index: 1; margin-bottom: 28px; }

.hb-search-wrap {
    max-width: 520px; margin: 0 auto;
    display: flex; position: relative; z-index: 1;
}
.hb-search-wrap input {
    flex: 1; padding: 14px 20px 14px 48px;
    border: none; border-radius: 12px 0 0 12px;
    font-family: inherit; font-size: 14px;
    outline: none; background: rgba(255,255,255,.97);
    color: #1e1f29;
}
.hb-search-wrap input::placeholder { color: #aaa; }
.hb-search-icon {
    position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
    color: #bbb; font-size: 15px; pointer-events: none; z-index: 2;
}
.hb-search-btn {
    padding: 14px 22px; background: #D10024; color: #fff;
    border: none; border-radius: 0 12px 12px 0;
    font-family: inherit; font-size: 14px; font-weight: 700;
    cursor: pointer; transition: background .18s; white-space: nowrap;
}
.hb-search-btn:hover { background: #a8001e; }

/* Quick-stats strip */
.hb-stats { background: #fff; border-bottom: 1px solid #f0f0f0; padding: 16px 0; }
.hb-stats-inner { display: flex; justify-content: center; gap: 0; flex-wrap: wrap; }
.hb-stat-item {
    display: flex; align-items: center; gap: 10px;
    padding: 8px 28px; border-right: 1px solid #f0f0f0;
}
.hb-stat-item:last-child { border-right: none; }
.hb-stat-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; }
.hb-stat-num  { font-size: 15px; font-weight: 800; color: #1e1f29; line-height: 1.1; }
.hb-stat-lbl  { font-size: 11px; color: #888; }

/* ── Main Layout ── */
.hb-page { padding: 36px 0 64px; background: #f7f8fa; }
.hb-layout { display: grid; grid-template-columns: 220px 1fr; gap: 24px; }
@media(max-width: 820px) { .hb-layout { grid-template-columns: 1fr; } }

/* Sidebar nav */
.hb-sidebar { position: sticky; top: 20px; height: fit-content; }
.hb-sidebar-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 12px rgba(0,0,0,.07); overflow: hidden; }
.hb-sidebar-title { font-size: 11px; font-weight: 800; color: #bbb; text-transform: uppercase; letter-spacing: .8px; padding: 14px 16px 10px; }
.hb-nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 11px 16px; cursor: pointer;
    font-size: 13px; font-weight: 600; color: #555;
    transition: background .15s, color .15s;
    border-left: 3px solid transparent;
}
.hb-nav-item:hover { background: #fef2f2; color: #D10024; }
.hb-nav-item.active { background: #fff5f5; color: #D10024; border-left-color: #D10024; }
.hb-nav-item .hb-nav-icon { width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0; }
.hb-nav-badge { margin-left: auto; background: #f3f4f6; color: #888; font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 20px; }
.hb-nav-item.active .hb-nav-badge { background: #fee2e2; color: #D10024; }

/* FAQ Sections */
.hb-section { display: none; }
.hb-section.active { display: block; }

.hb-section-header {
    display: flex; align-items: center; gap: 12px;
    margin-bottom: 16px;
}
.hb-section-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.hb-section-title { font-size: 18px; font-weight: 800; color: #1e1f29; }
.hb-section-sub   { font-size: 12px; color: #aaa; margin-top: 2px; }

/* Accordion */
.hb-accordion { display: flex; flex-direction: column; gap: 10px; }
.hb-acc-item {
    background: #fff; border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    overflow: hidden;
    transition: box-shadow .2s;
}
.hb-acc-item:hover { box-shadow: 0 4px 16px rgba(0,0,0,.1); }
.hb-acc-item.open  { box-shadow: 0 4px 20px rgba(209,0,36,.12); }

.hb-acc-trigger {
    display: flex; align-items: center; gap: 14px;
    padding: 16px 20px; cursor: pointer;
    user-select: none;
}
.hb-acc-q {
    flex: 1; font-size: 14px; font-weight: 700; color: #1e1f29;
    transition: color .15s;
}
.hb-acc-item.open .hb-acc-q { color: #D10024; }
.hb-acc-arrow {
    width: 28px; height: 28px; border-radius: 50%;
    background: #f3f4f6; display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 11px; color: #888;
    transition: transform .25s, background .2s, color .2s;
}
.hb-acc-item.open .hb-acc-arrow { transform: rotate(180deg); background: #fee2e2; color: #D10024; }

.hb-acc-body {
    max-height: 0; overflow: hidden;
    transition: max-height .3s ease, padding .3s ease;
    padding: 0 20px;
}
.hb-acc-item.open .hb-acc-body { max-height: 400px; padding: 0 20px 18px; }
.hb-acc-body p { font-size: 13.5px; color: #555; line-height: 1.7; margin: 0; }

/* No results */
.hb-no-results { text-align: center; padding: 48px 20px; background: #fff; border-radius: 14px; display: none; }
.hb-no-results .fa { font-size: 44px; color: #e0e0e0; display: block; margin-bottom: 12px; }
.hb-no-results h3 { font-size: 15px; color: #777; margin-bottom: 6px; }
.hb-no-results p  { font-size: 13px; color: #aaa; }

/* Contact Card */
.hb-contact { margin-top: 24px; background: #fff; border-radius: 14px; box-shadow: 0 2px 12px rgba(0,0,0,.07); overflow: hidden; }
.hb-contact-header {
    background: linear-gradient(135deg, #1a1a2e, #2d1b3d);
    padding: 20px 24px;
    display: flex; align-items: center; gap: 14px;
}
.hb-contact-header .fa { color: #D10024; font-size: 22px; }
.hb-contact-header div h3 { font-size: 15px; font-weight: 800; color: #fff; margin-bottom: 3px; }
.hb-contact-header div p  { font-size: 12px; color: rgba(255,255,255,.5); }
.hb-contact-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 0; }
@media(max-width:600px){ .hb-contact-grid { grid-template-columns: 1fr; } }
.hb-contact-item {
    padding: 20px; text-align: center;
    border-right: 1px solid #f0f0f0;
    transition: background .15s;
}
.hb-contact-item:last-child { border-right: none; }
.hb-contact-item:hover { background: #fef2f2; }
.hb-contact-ic {
    width: 48px; height: 48px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; margin: 0 auto 10px;
}
.hb-contact-item h4 { font-size: 13px; font-weight: 800; color: #1e1f29; margin-bottom: 4px; }
.hb-contact-item p  { font-size: 12px; color: #888; line-height: 1.6; }
.hb-contact-item a  { font-size: 12px; color: #D10024; font-weight: 600; text-decoration: none; }
.hb-contact-item a:hover { text-decoration: underline; }

@media(max-width:820px) {
    .hb-sidebar { position: static; }
    .hb-stats-inner { gap: 0; }
    .hb-stat-item { padding: 8px 16px; }
}
</style>
@endpush

@section('content')

{{-- Hero --}}
<div class="hb-hero">
    <div class="container">
        <div class="hb-hero-icon"><i class="fa fa-life-ring"></i></div>
        <h1>Pusat Bantuan NusaMart</h1>
        <p>Temukan jawaban cepat atas pertanyaan seputar belanja Anda</p>
        <div class="hb-search-wrap">
            <i class="fa fa-search hb-search-icon"></i>
            <input type="text" id="hbSearch" placeholder="Cari pertanyaan... misal: cara membayar, lacak pesanan" oninput="hbDoSearch(this.value)">
            <button class="hb-search-btn" onclick="hbDoSearch(document.getElementById('hbSearch').value)">Cari</button>
        </div>
    </div>
</div>

{{-- Stats strip --}}
<div class="hb-stats">
    <div class="container">
        <div class="hb-stats-inner">
            <div class="hb-stat-item">
                <div class="hb-stat-icon" style="background:#fff0f0;color:#D10024;"><i class="fa fa-question-circle"></i></div>
                <div>
                    <div class="hb-stat-num">18</div>
                    <div class="hb-stat-lbl">Pertanyaan umum</div>
                </div>
            </div>
            <div class="hb-stat-item">
                <div class="hb-stat-icon" style="background:#f0fdf4;color:#10b981;"><i class="fa fa-clock-o"></i></div>
                <div>
                    <div class="hb-stat-num">&lt; 1 mnt</div>
                    <div class="hb-stat-lbl">Waktu baca rata-rata</div>
                </div>
            </div>
            <div class="hb-stat-item">
                <div class="hb-stat-icon" style="background:#eff6ff;color:#3b82f6;"><i class="fa fa-headphones"></i></div>
                <div>
                    <div class="hb-stat-num">08-17</div>
                    <div class="hb-stat-lbl">Jam CS aktif</div>
                </div>
            </div>
            <div class="hb-stat-item">
                <div class="hb-stat-icon" style="background:#fdf4ff;color:#a855f7;"><i class="fa fa-bolt"></i></div>
                <div>
                    <div class="hb-stat-num">24 jam</div>
                    <div class="hb-stat-lbl">Respon email maks.</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Main content --}}
<div class="hb-page">
    <div class="container">
        <div class="hb-layout">

            {{-- Sidebar --}}
            <div class="hb-sidebar">
                <div class="hb-sidebar-card">
                    <div class="hb-sidebar-title">Topik Bantuan</div>
                    <div class="hb-nav-item active" onclick="hbSwitch('pemesanan', this)">
                        <div class="hb-nav-icon" style="background:#fff0f0;color:#D10024;"><i class="fa fa-shopping-cart"></i></div>
                        Pemesanan
                        <span class="hb-nav-badge">3</span>
                    </div>
                    <div class="hb-nav-item" onclick="hbSwitch('pembayaran', this)">
                        <div class="hb-nav-icon" style="background:#eff6ff;color:#3b82f6;"><i class="fa fa-credit-card"></i></div>
                        Pembayaran
                        <span class="hb-nav-badge">3</span>
                    </div>
                    <div class="hb-nav-item" onclick="hbSwitch('pengiriman', this)">
                        <div class="hb-nav-icon" style="background:#f0fdf4;color:#10b981;"><i class="fa fa-truck"></i></div>
                        Pengiriman
                        <span class="hb-nav-badge">2</span>
                    </div>
                    <div class="hb-nav-item" onclick="hbSwitch('pengembalian', this)">
                        <div class="hb-nav-icon" style="background:#fff7ed;color:#f97316;"><i class="fa fa-refresh"></i></div>
                        Pengembalian
                        <span class="hb-nav-badge">2</span>
                    </div>
                    <div class="hb-nav-item" onclick="hbSwitch('akun', this)">
                        <div class="hb-nav-icon" style="background:#fdf4ff;color:#a855f7;"><i class="fa fa-user"></i></div>
                        Akun
                        <span class="hb-nav-badge">2</span>
                    </div>
                    <div class="hb-nav-item" onclick="hbSwitch('promo', this)">
                        <div class="hb-nav-icon" style="background:#fefce8;color:#ca8a04;"><i class="fa fa-tag"></i></div>
                        Promo & Voucher
                        <span class="hb-nav-badge">3</span>
                    </div>
                    <div class="hb-nav-item" onclick="hbSwitch('penjual', this)">
                        <div class="hb-nav-icon" style="background:#f0fdf4;color:#16a34a;"><i class="fa fa-store"></i></div>
                        Jadi Penjual
                        <span class="hb-nav-badge">3</span>
                    </div>
                </div>
            </div>

            {{-- FAQ Content --}}
            <div>
                {{-- Search no-results --}}
                <div class="hb-no-results" id="hbNoResults">
                    <i class="fa fa-search"></i>
                    <h3>Tidak ditemukan</h3>
                    <p>Coba kata kunci lain atau pilih topik di samping.</p>
                </div>

                {{-- Pemesanan --}}
                <div class="hb-section active" id="sec-pemesanan">
                    <div class="hb-section-header">
                        <div class="hb-section-icon" style="background:#fff0f0;color:#D10024;"><i class="fa fa-shopping-cart"></i></div>
                        <div>
                            <div class="hb-section-title">Pemesanan</div>
                            <div class="hb-section-sub">Cara memesan, membatalkan & melacak pesanan</div>
                        </div>
                    </div>
                    <div class="hb-accordion">
                        <div class="hb-acc-item">
                            <div class="hb-acc-trigger" onclick="hbToggle(this)">
                                <div class="hb-acc-q">Bagaimana cara melakukan pemesanan?</div>
                                <div class="hb-acc-arrow"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="hb-acc-body"><p>Pilih produk yang diinginkan, klik <strong>"Tambah ke Keranjang"</strong> atau <strong>"Beli Langsung"</strong>, lalu menuju halaman checkout. Isi data pengiriman, pilih metode pembayaran, dan klik <strong>"Buat Pesanan"</strong> untuk mengonfirmasi.</p></div>
                        </div>
                        <div class="hb-acc-item">
                            <div class="hb-acc-trigger" onclick="hbToggle(this)">
                                <div class="hb-acc-q">Bisakah saya membatalkan pesanan?</div>
                                <div class="hb-acc-arrow"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="hb-acc-body"><p>Pesanan dapat dibatalkan selama status masih <strong>"Menunggu Pembayaran"</strong> atau <strong>"Diproses"</strong>. Setelah pesanan dikemas/dikirim, pembatalan tidak dapat dilakukan. Hubungi customer service kami untuk bantuan lebih lanjut.</p></div>
                        </div>
                        <div class="hb-acc-item">
                            <div class="hb-acc-trigger" onclick="hbToggle(this)">
                                <div class="hb-acc-q">Bagaimana cara melacak pesanan saya?</div>
                                <div class="hb-acc-arrow"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="hb-acc-body"><p>Masuk ke akun Anda, buka menu <strong>"Pesanan Saya"</strong>, dan klik detail pesanan. Anda akan melihat nomor resi dan status pengiriman terkini secara real-time.</p></div>
                        </div>
                    </div>
                </div>

                {{-- Pembayaran --}}
                <div class="hb-section" id="sec-pembayaran">
                    <div class="hb-section-header">
                        <div class="hb-section-icon" style="background:#eff6ff;color:#3b82f6;"><i class="fa fa-credit-card"></i></div>
                        <div>
                            <div class="hb-section-title">Pembayaran</div>
                            <div class="hb-section-sub">Metode bayar, batas waktu & keamanan transaksi</div>
                        </div>
                    </div>
                    <div class="hb-accordion">
                        <div class="hb-acc-item">
                            <div class="hb-acc-trigger" onclick="hbToggle(this)">
                                <div class="hb-acc-q">Metode pembayaran apa saja yang tersedia?</div>
                                <div class="hb-acc-arrow"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="hb-acc-body"><p>NusaMart menerima pembayaran melalui <strong>transfer bank manual</strong> (BCA, BNI, Mandiri, BRI) dan <strong>virtual account</strong> yang digenerate otomatis. Pilih metode saat di halaman checkout.</p></div>
                        </div>
                        <div class="hb-acc-item">
                            <div class="hb-acc-trigger" onclick="hbToggle(this)">
                                <div class="hb-acc-q">Berapa lama batas waktu pembayaran?</div>
                                <div class="hb-acc-arrow"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="hb-acc-body"><p>Batas waktu pembayaran adalah <strong>1×24 jam</strong> setelah pesanan dibuat. Jika pembayaran tidak dilakukan dalam waktu tersebut, pesanan akan otomatis dibatalkan oleh sistem.</p></div>
                        </div>
                        <div class="hb-acc-item">
                            <div class="hb-acc-trigger" onclick="hbToggle(this)">
                                <div class="hb-acc-q">Apakah pembayaran di NusaMart aman?</div>
                                <div class="hb-acc-arrow"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="hb-acc-body"><p>Ya, semua transaksi di NusaMart dilindungi dengan <strong>enkripsi SSL</strong> dan sistem keamanan berlapis untuk menjaga data pembayaran Anda tetap aman.</p></div>
                        </div>
                    </div>
                </div>

                {{-- Pengiriman --}}
                <div class="hb-section" id="sec-pengiriman">
                    <div class="hb-section-header">
                        <div class="hb-section-icon" style="background:#f0fdf4;color:#10b981;"><i class="fa fa-truck"></i></div>
                        <div>
                            <div class="hb-section-title">Pengiriman</div>
                            <div class="hb-section-sub">Estimasi waktu, ongkos kirim & kurir</div>
                        </div>
                    </div>
                    <div class="hb-accordion">
                        <div class="hb-acc-item">
                            <div class="hb-acc-trigger" onclick="hbToggle(this)">
                                <div class="hb-acc-q">Berapa lama estimasi pengiriman?</div>
                                <div class="hb-acc-arrow"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="hb-acc-body"><p>Estimasi pengiriman bergantung lokasi & jasa kurir yang dipilih penjual. Umumnya <strong>2–5 hari kerja</strong> untuk Pulau Jawa dan <strong>5–10 hari kerja</strong> untuk luar Jawa.</p></div>
                        </div>
                        <div class="hb-acc-item">
                            <div class="hb-acc-trigger" onclick="hbToggle(this)">
                                <div class="hb-acc-q">Berapa ongkos kirimnya?</div>
                                <div class="hb-acc-arrow"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="hb-acc-body"><p>Ongkos kirim dihitung berdasarkan berat produk dan lokasi tujuan. Rinciannya akan ditampilkan di halaman checkout sebelum Anda melakukan pembayaran.</p></div>
                        </div>
                    </div>
                </div>

                {{-- Pengembalian --}}
                <div class="hb-section" id="sec-pengembalian">
                    <div class="hb-section-header">
                        <div class="hb-section-icon" style="background:#fff7ed;color:#f97316;"><i class="fa fa-refresh"></i></div>
                        <div>
                            <div class="hb-section-title">Pengembalian & Refund</div>
                            <div class="hb-section-sub">Kebijakan retur dan proses pengembalian dana</div>
                        </div>
                    </div>
                    <div class="hb-accordion">
                        <div class="hb-acc-item">
                            <div class="hb-acc-trigger" onclick="hbToggle(this)">
                                <div class="hb-acc-q">Bagaimana jika barang yang diterima rusak?</div>
                                <div class="hb-acc-arrow"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="hb-acc-body"><p>Segera hubungi customer service kami dalam <strong>2×24 jam</strong> setelah barang diterima dengan menyertakan foto bukti kerusakan. Kami akan memproses pengembalian atau penggantian produk.</p></div>
                        </div>
                        <div class="hb-acc-item">
                            <div class="hb-acc-trigger" onclick="hbToggle(this)">
                                <div class="hb-acc-q">Berapa lama proses refund?</div>
                                <div class="hb-acc-arrow"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="hb-acc-body"><p>Proses refund memakan waktu <strong>3–7 hari kerja</strong> setelah pengajuan pengembalian disetujui. Dana akan dikembalikan ke metode pembayaran yang sama saat pemesanan.</p></div>
                        </div>
                    </div>
                </div>

                {{-- Akun --}}
                <div class="hb-section" id="sec-akun">
                    <div class="hb-section-header">
                        <div class="hb-section-icon" style="background:#fdf4ff;color:#a855f7;"><i class="fa fa-user"></i></div>
                        <div>
                            <div class="hb-section-title">Akun</div>
                            <div class="hb-section-sub">Daftar, login, dan kelola akun Anda</div>
                        </div>
                    </div>
                    <div class="hb-accordion">
                        <div class="hb-acc-item">
                            <div class="hb-acc-trigger" onclick="hbToggle(this)">
                                <div class="hb-acc-q">Bagaimana cara mendaftar akun?</div>
                                <div class="hb-acc-arrow"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="hb-acc-body"><p>Klik tombol <strong>"Daftar"</strong> di halaman utama, isi data diri Anda (nama, email, dan password), lalu verifikasi email untuk mengaktifkan akun. Proses ini hanya memakan waktu 1–2 menit.</p></div>
                        </div>
                        <div class="hb-acc-item">
                            <div class="hb-acc-trigger" onclick="hbToggle(this)">
                                <div class="hb-acc-q">Saya lupa password, bagaimana mengatasinya?</div>
                                <div class="hb-acc-arrow"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="hb-acc-body"><p>Klik <strong>"Lupa Password?"</strong> di halaman login, masukkan email yang terdaftar, dan kami akan mengirimkan link reset password. Periksa juga folder spam jika email tidak masuk ke inbox.</p></div>
                        </div>
                    </div>
                </div>

                {{-- Promo --}}
                <div class="hb-section" id="sec-promo">
                    <div class="hb-section-header">
                        <div class="hb-section-icon" style="background:#fefce8;color:#ca8a04;"><i class="fa fa-tag"></i></div>
                        <div>
                            <div class="hb-section-title">Promo & Voucher</div>
                            <div class="hb-section-sub">Cara pakai voucher, flash sale, dan promo penjual</div>
                        </div>
                    </div>
                    <div class="hb-accordion">
                        <div class="hb-acc-item">
                            <div class="hb-acc-trigger" onclick="hbToggle(this)">
                                <div class="hb-acc-q">Bagaimana cara menggunakan kode voucher?</div>
                                <div class="hb-acc-arrow"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="hb-acc-body"><p>Di halaman <a href="{{ route('page.vouchers') }}" style="color:#D10024;font-weight:700;">Voucher</a>, klik <strong>"Pakai"</strong> untuk menyalin kode. Tempel kode tersebut di kolom <strong>"Kode Voucher"</strong> pada halaman checkout dan klik Terapkan.</p></div>
                        </div>
                        <div class="hb-acc-item">
                            <div class="hb-acc-trigger" onclick="hbToggle(this)">
                                <div class="hb-acc-q">Apa itu flash sale / promo produk?</div>
                                <div class="hb-acc-arrow"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="hb-acc-body"><p>Flash sale adalah potongan harga sementara yang di-set langsung oleh penjual pada produk tertentu. Harga promo akan otomatis teraplikasikan saat Anda membeli produk tersebut — tanpa perlu kode voucher.</p></div>
                        </div>
                        <div class="hb-acc-item">
                            <div class="hb-acc-trigger" onclick="hbToggle(this)">
                                <div class="hb-acc-q">Kenapa voucher saya tidak bisa dipakai?</div>
                                <div class="hb-acc-arrow"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="hb-acc-body"><p>Kemungkinan penyebabnya: <strong>(1)</strong> Voucher sudah kedaluwarsa, <strong>(2)</strong> Kuota voucher habis, <strong>(3)</strong> Total belanja Anda di bawah minimum pembelian voucher, atau <strong>(4)</strong> Kode yang dimasukkan salah (perhatikan huruf kapital).</p></div>
                        </div>
                    </div>
                </div>

                {{-- Penjual --}}
                <div class="hb-section" id="sec-penjual">
                    <div class="hb-section-header">
                        <div class="hb-section-icon" style="background:#f0fdf4;color:#16a34a;"><i class="fa fa-store"></i></div>
                        <div>
                            <div class="hb-section-title">Jadi Penjual</div>
                            <div class="hb-section-sub">Cara berjualan dan mengelola toko di NusaMart</div>
                        </div>
                    </div>
                    <div class="hb-accordion">
                        <div class="hb-acc-item">
                            <div class="hb-acc-trigger" onclick="hbToggle(this)">
                                <div class="hb-acc-q">Bagaimana cara mulai berjualan di NusaMart?</div>
                                <div class="hb-acc-arrow"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="hb-acc-body"><p>Buka halaman <strong>Daftar</strong>, isi data diri Anda, lalu pilih peran <strong>"Penjual"</strong> sebelum submit. Akun Penjual langsung aktif setelah pendaftaran — tidak perlu menunggu persetujuan. Anda langsung bisa menambahkan produk dan menerima pesanan dari dashboard penjual.</p></div>
                        </div>
                        <div class="hb-acc-item">
                            <div class="hb-acc-trigger" onclick="hbToggle(this)">
                                <div class="hb-acc-q">Apakah ada biaya untuk berjualan?</div>
                                <div class="hb-acc-arrow"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="hb-acc-body"><p>Berjualan di NusaMart <strong>gratis</strong>, tidak ada biaya pendaftaran maupun biaya bulanan. NusaMart mengambil komisi kecil per transaksi yang berhasil sesuai ketentuan yang berlaku.</p></div>
                        </div>
                        <div class="hb-acc-item">
                            <div class="hb-acc-trigger" onclick="hbToggle(this)">
                                <div class="hb-acc-q">Bagaimana cara membuat promo untuk produk saya?</div>
                                <div class="hb-acc-arrow"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="hb-acc-body"><p>Masuk ke Dashboard Penjual, buka menu <strong>"Promo Saya"</strong>, lalu klik <strong>"Buat Promo Baru"</strong>. Pilih produk, atur harga promo, pilih jadwal promo, dan tentukan kuota maksimal.</p></div>
                        </div>
                    </div>
                </div>

                {{-- Contact --}}
                <div class="hb-contact">
                    <div class="hb-contact-header">
                        <i class="fa fa-headphones"></i>
                        <div>
                            <h3>Masih butuh bantuan?</h3>
                            <p>Tim kami siap membantu Anda</p>
                        </div>
                    </div>
                    <div class="hb-contact-grid">
                        <div class="hb-contact-item">
                            <div class="hb-contact-ic" style="background:#fff0f0;color:#D10024;"><i class="fa fa-envelope-o"></i></div>
                            <h4>Email</h4>
                            <p><a href="mailto:cs@nusamart.id">cs@nusamart.id</a></p>
                            <p>Respon maks. 1×24 jam</p>
                        </div>
                        <div class="hb-contact-item">
                            <div class="hb-contact-ic" style="background:#f0fdf4;color:#25d366;"><i class="fa fa-whatsapp"></i></div>
                            <h4>WhatsApp</h4>
                            <p><a href="https://wa.me/6281200000000" target="_blank">+62 812-0000-0000</a></p>
                            <p>Senin–Jumat, 08:00–17:00</p>
                        </div>
                        <div class="hb-contact-item">
                            <div class="hb-contact-ic" style="background:#eff6ff;color:#3b82f6;"><i class="fa fa-phone"></i></div>
                            <h4>Telepon</h4>
                            <p><a href="tel:+622110000000">+62 21-1000-000</a></p>
                            <p>Senin–Jumat, 08:00–17:00</p>
                        </div>
                    </div>
                </div>

            </div>{{-- end FAQ content --}}
        </div>{{-- end layout --}}
    </div>
</div>
@endsection

@push('scripts')
<script>
// ── Sidebar navigation ──────────────────────────────────────
function hbSwitch(id, el) {
    document.querySelectorAll('.hb-section').forEach(function(s){ s.classList.remove('active'); });
    document.querySelectorAll('.hb-nav-item').forEach(function(n){ n.classList.remove('active'); });
    var sec = document.getElementById('sec-' + id);
    if (sec) sec.classList.add('active');
    if (el)  el.classList.add('active');
    document.getElementById('hbSearch').value = '';
    document.getElementById('hbNoResults').style.display = 'none';
}

// ── Accordion ───────────────────────────────────────────────
function hbToggle(trigger) {
    var item = trigger.parentElement;
    var isOpen = item.classList.contains('open');
    // close all in same accordion
    var parent = item.parentElement;
    parent.querySelectorAll('.hb-acc-item.open').forEach(function(i){ i.classList.remove('open'); });
    if (!isOpen) item.classList.add('open');
}

// ── Search ──────────────────────────────────────────────────
function hbDoSearch(query) {
    query = query.trim().toLowerCase();
    var noResults = document.getElementById('hbNoResults');

    if (!query) {
        // restore — show whichever section was active, hide no-results
        noResults.style.display = 'none';
        var anyActive = document.querySelector('.hb-section.active');
        if (!anyActive) {
            document.getElementById('sec-pemesanan').classList.add('active');
            document.querySelector('.hb-nav-item').classList.add('active');
        }
        document.querySelectorAll('.hb-acc-item').forEach(function(i){ i.style.display = ''; });
        return;
    }

    // hide all sections, show all accordion items then filter
    document.querySelectorAll('.hb-section').forEach(function(s){ s.classList.remove('active'); });
    document.querySelectorAll('.hb-nav-item').forEach(function(n){ n.classList.remove('active'); });
    noResults.style.display = 'none';

    // collect matches across all sections
    var found = false;
    document.querySelectorAll('.hb-section').forEach(function(sec) {
        var sectionHit = false;
        sec.querySelectorAll('.hb-acc-item').forEach(function(item) {
            var text = item.textContent.toLowerCase();
            if (text.indexOf(query) >= 0) {
                item.style.display = '';
                sectionHit = true;
                found = true;
            } else {
                item.style.display = 'none';
            }
        });
        if (sectionHit) sec.classList.add('active');
    });

    if (!found) {
        noResults.style.display = 'block';
    }
}

// Close accordion when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.hb-acc-trigger')) {
        // do nothing — let toggle handle it
    }
});
</script>
@endpush

