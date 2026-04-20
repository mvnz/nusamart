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
.payment-wrap { display: flex; flex-direction: column; align-items: flex-end; gap: 8px; }
.payment-label { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #666; font-weight: 600; }
.payment-icons { display: flex; gap: 6px; flex-wrap: wrap; justify-content: flex-end; }
.pay-badge { display: inline-flex; align-items: center; gap: 5px; padding: 5px 10px; border-radius: 7px; font-size: 12px; font-weight: 700; letter-spacing: .3px; border: 1px solid transparent; transition: transform 0.2s, box-shadow 0.2s; cursor: default; }
.pay-badge:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.35); }
.pay-badge .fa { font-size: 15px; }
.pay-visa    { background: #fff; color: #1a1f71; border-color: rgba(255,255,255,.15); }
.pay-mc      { background: #fff; color: #252525; border-color: rgba(255,255,255,.15); }
.pay-mc .fa  { background: linear-gradient(to right, #eb001b 40%, #f79e1b 60%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.pay-bca     { background: #005baa; color: #fff; }
.pay-bni     { background: #f15a24; color: #fff; }
.pay-mandiri { background: #003087; color: #F7A800; }
.pay-gopay   { background: #00aed6; color: #fff; }
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
        <div class="footer-bottom">
            <p>&copy; 2026 NusaMart. All rights reserved.</p>
            <div class="payment-wrap">
                <span class="payment-label">Metode Pembayaran</span>
                <div class="payment-icons">
                    <span class="pay-badge pay-visa"><i class="fa fa-cc-visa"></i> VISA</span>
                    <span class="pay-badge pay-mc"><i class="fa fa-cc-mastercard"></i> Mastercard</span>
                    <span class="pay-badge pay-bca"><i class="fa fa-university"></i> BCA</span>
                    <span class="pay-badge pay-bni"><i class="fa fa-university"></i> BNI</span>
                    <span class="pay-badge pay-mandiri"><i class="fa fa-university"></i> Mandiri</span>
                    <span class="pay-badge pay-gopay"><i class="fa fa-mobile"></i> GoPay</span>
                </div>
            </div>
        </div>
    </div>
</footer>
