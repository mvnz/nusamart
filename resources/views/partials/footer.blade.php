<style>
.site-footer { background: linear-gradient(135deg,#15161d,#1a1b28,#15161d); padding: 40px 0 20px; color: #b9babc; font-family: 'Montserrat', sans-serif; }
.site-footer .container { max-width: 1200px; margin: 0 auto; padding: 0 15px; }
.footer-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 30px; margin-bottom: 30px; }
.footer-col h4 { color: #fff; font-size: 16px; font-weight: 700; text-transform: uppercase; margin-bottom: 16px; letter-spacing: .5px; }
.footer-col p { font-size: 13px; line-height: 1.7; margin-bottom: 12px; }
.footer-col ul { list-style: none; padding: 0; margin: 0; }
.footer-col ul li { margin-bottom: 8px; }
.footer-col ul li a { color: #b9babc; font-size: 13px; text-decoration: none; transition: all 0.2s; }
.footer-col ul li a:hover { color: #D10024; padding-left: 6px; }
.footer-contact { list-style: none; padding: 0; margin: 0; }
.footer-contact li { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; font-size: 13px; }
.footer-contact .fa { color: #D10024; width: 16px; text-align: center; }
.footer-bottom { border-top: 1px solid rgba(255,255,255,.08); padding-top: 20px; display: flex; justify-content: space-between; align-items: center; }
.footer-bottom p { font-size: 12px; color: #8d8d8d; }
/* ===== PAYMENT SECTION ===== */
.footer-payment { border-top: 1px solid rgba(255,255,255,.08); padding: 22px 0 18px; }
.fp-title { font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: #555; font-weight: 700; margin-bottom: 16px; text-align: center; }
.fp-groups { display: flex; gap: 0; align-items: flex-start; flex-wrap: wrap; justify-content: center; }
.fp-group { display: flex; flex-direction: column; gap: 8px; padding: 0 20px; }
.fp-group:not(:last-child) { border-right: 1px solid rgba(255,255,255,.08); }
.fp-group-label { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #555; font-weight: 700; }
.fp-badges { display: flex; gap: 5px; flex-wrap: wrap; }
.pay-badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 9px; border-radius: 6px; font-size: 11px; font-weight: 700; letter-spacing: .2px; border: 1px solid rgba(255,255,255,.06); transition: transform 0.2s, box-shadow 0.2s; cursor: default; white-space: nowrap; }
.pay-badge:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.45); }
.pay-badge .fa { font-size: 13px; }
/* Kartu */
.pay-visa    { background: #1a1f71; color: #fff; }
.pay-mc      { background: #252525; color: #fff; }
/* Bank */
.pay-bca     { background: #005baa; color: #fff; }
.pay-bni     { background: #f15a24; color: #fff; }
.pay-bri     { background: #003d7c; color: #f0c020; }
.pay-mandiri { background: #003087; color: #F7A800; }
.pay-bsi     { background: #166534; color: #fff; }
.pay-cimb    { background: #D71A21; color: #fff; }
.pay-permata { background: #7c3aed; color: #fff; }
.pay-btn     { background: #f26522; color: #fff; }
.pay-danamon { background: #e31837; color: #fff; }
.pay-mega    { background: #004a8d; color: #fff; }
.pay-maybank { background: #f7d200; color: #1a1a1a; }
.pay-ocbc    { background: #e2001a; color: #fff; }
.pay-jago    { background: #00c896; color: #fff; }
/* E-Wallet */
.pay-gopay   { background: #00aed6; color: #fff; }
.pay-ovo     { background: #4c3494; color: #fff; }
.pay-dana    { background: #108ee9; color: #fff; }
.pay-shopee  { background: #ee4d2d; color: #fff; }
.pay-linkaja { background: #e82529; color: #fff; }
/* QRIS */
.pay-qris    { background: linear-gradient(135deg,#c0392b,#e74c3c); color: #fff; }
@media (max-width: 768px) { .fp-group { padding: 12px 14px; border-right: none !important; border-bottom: 1px solid rgba(255,255,255,.08); } .fp-group:last-child { border-bottom: none; } }
@media (max-width: 992px) { .footer-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 576px) { .footer-grid { grid-template-columns: 1fr; } .footer-bottom { flex-direction: column; gap: 10px; text-align: center; } }
</style>

<!-- Footer -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>Tentang Kami</h4>
                <p>NusaMart adalah marketplace produk lokal UMKM dari Desa Manud Jaya. Kami menghubungkan pelaku usaha desa dengan pembeli di seluruh Indonesia.</p>
                <ul class="footer-contact">
                    <li><i class="fa fa-map-marker"></i> Jakarta, Indonesia</li>
                    <li><i class="fa fa-phone"></i> +62 21-1000-000</li>
                    <li><i class="fa fa-envelope-o"></i> cs@tokonusamart.com</li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Kategori</h4>
                <ul>
                    @foreach(\App\Models\Category::inRandomOrder()->limit(6)->get() as $cat)
                    <li><a href="{{ route('products.index', ['category_id' => $cat->id]) }}">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="footer-col">
                <h4>Informasi</h4>
                <ul>
                    <li><a href="{{ route('page.tentang') }}">Tentang NusaMart</a></li>
                    <li><a href="{{ route('page.kontak') }}">Hubungi Kami</a></li>
                    <li><a href="{{ route('page.privasi') }}">Kebijakan Privasi</a></li>
                    <li><a href="{{ route('page.syarat') }}">Syarat & Ketentuan</a></li>
                    <li><a href="{{ route('page.pengembalian') }}">Pengembalian</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Layanan</h4>
                <ul>
                    <li><a href="{{ route('profile') }}">Akun Saya</a></li>
                    <li><a href="{{ route('page.bantuan') }}">Bantuan</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-payment">
            <div class="fp-title">Metode Pembayaran yang Diterima</div>
            <div class="fp-groups">
                <div class="fp-group">
                    <span class="fp-group-label"><i class="fa fa-credit-card"></i> Kartu Kredit / Debit</span>
                    <div class="fp-badges">
                        <span class="pay-badge pay-visa"><i class="fa fa-cc-visa"></i> VISA</span>
                        <span class="pay-badge pay-mc"><i class="fa fa-cc-mastercard"></i> Mastercard</span>
                    </div>
                </div>
                <div class="fp-group">
                    <span class="fp-group-label"><i class="fa fa-university"></i> Transfer Bank / Virtual Account</span>
                    <div class="fp-badges">
                        <span class="pay-badge pay-bca"><i class="fa fa-bank"></i> BCA</span>
                        <span class="pay-badge pay-bni"><i class="fa fa-bank"></i> BNI</span>
                        <span class="pay-badge pay-bri"><i class="fa fa-bank"></i> BRI</span>
                        <span class="pay-badge pay-mandiri"><i class="fa fa-bank"></i> Mandiri</span>
                        <span class="pay-badge pay-bsi"><i class="fa fa-bank"></i> BSI</span>
                        <span class="pay-badge pay-cimb"><i class="fa fa-bank"></i> CIMB</span>
                        <span class="pay-badge pay-permata"><i class="fa fa-bank"></i> Permata</span>
                        <span class="pay-badge pay-btn"><i class="fa fa-bank"></i> BTN</span>
                        <span class="pay-badge pay-danamon"><i class="fa fa-bank"></i> Danamon</span>
                        <span class="pay-badge pay-mega"><i class="fa fa-bank"></i> Mega</span>
                        <span class="pay-badge pay-maybank"><i class="fa fa-bank"></i> Maybank</span>
                        <span class="pay-badge pay-ocbc"><i class="fa fa-bank"></i> OCBC</span>
                        <span class="pay-badge pay-jago"><i class="fa fa-bank"></i> Bank Jago</span>
                    </div>
                </div>
                <div class="fp-group">
                    <span class="fp-group-label"><i class="fa fa-mobile"></i> E-Wallet</span>
                    <div class="fp-badges">
                        <span class="pay-badge pay-gopay"><i class="fa fa-mobile"></i> GoPay</span>
                        <span class="pay-badge pay-ovo"><i class="fa fa-mobile"></i> OVO</span>
                        <span class="pay-badge pay-dana"><i class="fa fa-mobile"></i> DANA</span>
                        <span class="pay-badge pay-shopee"><i class="fa fa-mobile"></i> ShopeePay</span>
                        <span class="pay-badge pay-linkaja"><i class="fa fa-mobile"></i> LinkAja</span>
                    </div>
                </div>
                <div class="fp-group">
                    <span class="fp-group-label"><i class="fa fa-qrcode"></i> Scan & Pay</span>
                    <div class="fp-badges">
                        <span class="pay-badge pay-qris"><i class="fa fa-qrcode"></i> QRIS</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 NusaMart. All rights reserved.</p>
            <p style="font-size:11px;color:#555;">Transaksi aman &amp; terenkripsi <i class="fa fa-lock" style="color:#D10024;"></i></p>
        </div>
    </div>
</footer>
