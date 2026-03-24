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
.payment-icons { display: flex; gap: 8px; }
.payment-icons span { background: rgba(255,255,255,.08); padding: 4px 10px; border-radius: 6px; font-size: 14px; color: #b9babc; font-weight: 600; transition: all 0.3s; }
.payment-icons span:hover { background: rgba(209,0,36,.15); color: #fff; }
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
            <div class="payment-icons">
                <span><i class="fa fa-cc-visa"></i></span>
                <span><i class="fa fa-cc-mastercard"></i></span>
                <span><i class="fa fa-credit-card"></i> BCA</span>
                <span><i class="fa fa-credit-card"></i> BNI</span>
                <span><i class="fa fa-credit-card"></i> Mandiri</span>
                <span><i class="fa fa-money"></i> GoPay</span>
            </div>
        </div>
    </div>
</footer>
