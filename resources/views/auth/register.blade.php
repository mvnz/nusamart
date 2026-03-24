<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran - NusaMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ filemtime(public_path('css/auth.css')) }}">
</head>
<body>
    <div class="register-wrapper">
        <div class="register-brand">
            <div class="logo">
                <div class="logo-icon">N</div>
                <div class="logo-text">Nusa<span>Mart</span></div>
            </div>
            <div class="brand-icon">
                <i class="fa fa-shopping-bag"></i>
            </div>
            <p>Bergabunglah dengan marketplace produk lokal UMKM Desa Manud Jaya. Jual atau beli produk unggulan desa.</p>
            <ul class="brand-features">
                <li><i class="fa fa-check-circle"></i> Produk asli UMKM Desa Manud Jaya</li>
                <li><i class="fa fa-check-circle"></i> Pembayaran aman & terpercaya</li>
                <li><i class="fa fa-check-circle"></i> Pengiriman ke seluruh Indonesia</li>
                <li><i class="fa fa-check-circle"></i> Gratis biaya pendaftaran</li>
                <li><i class="fa fa-check-circle"></i> Dukungan pelanggan 24/7</li>
            </ul>
        </div>

        <div class="register-form-section">
            <div class="header-register">
                <h1>Daftar Sekarang</h1>
                <p>Cari produk sesukamu, di NusaMart</p>
            </div>

            @if ($errors->any())
                <div class="error-box">
                    <strong><i class="fa fa-exclamation-circle"></i> Terjadi Kesalahan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}">
                @csrf

                <div class="form-group">
                    <label for="nama_lengkap"><i class="fa fa-id-card-o"></i> Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap" required>
                    @error('nama_lengkap')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="username"><i class="fa fa-at"></i> Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="username" required>
                        @error('username')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone"><i class="fa fa-phone"></i> Nomor HP/WhatsApp</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="081234567890" pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                        @error('phone')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="email"><i class="fa fa-envelope-o"></i> Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="alamat"><i class="fa fa-home"></i> Alamat (Nama Jalan/Gang/No. Rumah)</label>
                    <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}" placeholder="Jl. Contoh No. 123" required>
                    @error('alamat')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Hidden name fields populated by JS --}}
                <input type="hidden" id="propinsi" name="propinsi" value="{{ old('propinsi') }}">
                <input type="hidden" id="kota" name="kota" value="{{ old('kota') }}">
                <input type="hidden" id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}">
                <input type="hidden" id="kelurahan" name="kelurahan" value="{{ old('kelurahan') }}">

                <div class="form-row">
                    <div class="form-group">
                        <label for="province_code"><i class="fa fa-map-marker"></i> Provinsi</label>
                        <select id="province_code" name="province_code" required>
                            <option value="">-- Pilih Provinsi --</option>
                        </select>
                        @error('province_code')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        @error('propinsi')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="regency_code"><i class="fa fa-building-o"></i> Kota / Kabupaten</label>
                        <select id="regency_code" name="regency_code" disabled required>
                            <option value="">-- Pilih Provinsi dulu --</option>
                        </select>
                        @error('regency_code')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        @error('kota')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="district_code"><i class="fa fa-map-o"></i> Kecamatan</label>
                        <select id="district_code" name="district_code" disabled required>
                            <option value="">-- Pilih Kota/Kab dulu --</option>
                        </select>
                        @error('district_code')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        @error('kecamatan')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="village_code"><i class="fa fa-home"></i> Kelurahan / Desa</label>
                        <select id="village_code" name="village_code" disabled required>
                            <option value="">-- Pilih Kecamatan dulu --</option>
                        </select>
                        @error('village_code')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        @error('kelurahan')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row" style="grid-template-columns:1fr 1fr 1fr">
                    <div class="form-group">
                        <label for="rt"><i class="fa fa-hashtag"></i> RT</label>
                        <input type="text" id="rt" name="rt" value="{{ old('rt') }}" placeholder="001" maxlength="5" pattern="[0-9]*" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                        @error('rt')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rw"><i class="fa fa-hashtag"></i> RW</label>
                        <input type="text" id="rw" name="rw" value="{{ old('rw') }}" placeholder="001" maxlength="5" pattern="[0-9]*" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                        @error('rw')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kodepos"><i class="fa fa-envelope-o"></i> Kode Pos</label>
                        <input type="text" id="kodepos" name="kodepos" value="{{ old('kodepos') }}" placeholder="12345" maxlength="10" pattern="[0-9]*" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                        @error('kodepos')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password"><i class="fa fa-lock"></i> Password</label>
                        <input type="password" id="password" name="password" placeholder="Min 8 karakter, huruf besar & kecil, spesial" required>
                        <div class="password-requirements">Minimal 8 karakter, kombinasi huruf besar & kecil, dan karakter spesial</div>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation"><i class="fa fa-lock"></i> Ulangi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fa fa-user-plus"></i> Daftar sebagai</label>
                    <div class="role-selector">
                        <div class="role-option">
                            <input type="radio" id="pembeli" name="role" value="pembeli" {{ old('role') == 'pembeli' ? 'checked' : '' }} required>
                            <label for="pembeli" class="role-label"><i class="fa fa-shopping-bag"></i> Pembeli</label>
                        </div>
                        <div class="role-option">
                            <input type="radio" id="penjual" name="role" value="penjual" {{ old('role') == 'penjual' ? 'checked' : '' }}>
                            <label for="penjual" class="role-label"><i class="fa fa-building-o"></i> Penjual</label>
                        </div>
                    </div>
                    @error('role')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-register"><i class="fa fa-user-plus"></i> Daftar Akun</button>
            </form>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>
    </div>
</body>
<script>
(function () {
    const urls = {
        provinces: '{{ route('wilayah.provinces') }}',
        regencies: (code) => '{{ url('api/wilayah/regencies') }}/' + code,
        districts: (code) => '{{ url('api/wilayah/districts') }}/' + code,
        villages: (code) => '{{ url('api/wilayah/villages') }}/' + code,
    };

    const old = {
        province_code: '{{ old('province_code') }}',
        regency_code:  '{{ old('regency_code') }}',
        district_code: '{{ old('district_code') }}',
        village_code:  '{{ old('village_code') }}',
    };

    const selProvince = document.getElementById('province_code');
    const selRegency  = document.getElementById('regency_code');
    const selDistrict = document.getElementById('district_code');
    const selVillage  = document.getElementById('village_code');

    const hidPropinsi  = document.getElementById('propinsi');
    const hidKota      = document.getElementById('kota');
    const hidKecamatan = document.getElementById('kecamatan');
    const hidKelurahan = document.getElementById('kelurahan');

    function populateSelect(sel, data, placeholder, selectedCode) {
        sel.innerHTML = '<option value="">' + placeholder + '</option>';
        data.forEach(function (item) {
            const opt = document.createElement('option');
            opt.value = item.code;
            opt.textContent = item.name;
            if (selectedCode && item.code === selectedCode) opt.selected = true;
            sel.appendChild(opt);
        });
        sel.disabled = false;
    }

    function resetSelect(sel, placeholder) {
        sel.innerHTML = '<option value="">' + placeholder + '</option>';
        sel.disabled = true;
    }

    // Load provinces on page load
    fetch(urls.provinces)
        .then(r => r.json())
        .then(function (data) {
            populateSelect(selProvince, data, '-- Pilih Provinsi --', old.province_code);
            if (old.province_code) {
                loadRegencies(old.province_code, true);
            }
        });

    function loadRegencies(code, isOld) {
        fetch(urls.regencies(code))
            .then(r => r.json())
            .then(function (data) {
                populateSelect(selRegency, data, '-- Pilih Kota/Kab --', isOld ? old.regency_code : null);
                if (isOld && old.regency_code) {
                    loadDistricts(old.regency_code, true);
                }
            });
    }

    function loadDistricts(code, isOld) {
        fetch(urls.districts(code))
            .then(r => r.json())
            .then(function (data) {
                populateSelect(selDistrict, data, '-- Pilih Kecamatan --', isOld ? old.district_code : null);
                if (isOld && old.district_code) {
                    loadVillages(old.district_code, true);
                }
            });
    }

    function loadVillages(code, isOld) {
        fetch(urls.villages(code))
            .then(r => r.json())
            .then(function (data) {
                populateSelect(selVillage, data, '-- Pilih Kelurahan/Desa --', isOld ? old.village_code : null);
            });
    }

    selProvince.addEventListener('change', function () {
        hidPropinsi.value = this.options[this.selectedIndex].textContent;
        resetSelect(selRegency, '-- Pilih Kota/Kab --');
        resetSelect(selDistrict, '-- Pilih Kecamatan --');
        resetSelect(selVillage, '-- Pilih Kelurahan/Desa --');
        hidKota.value = '';
        hidKecamatan.value = '';
        hidKelurahan.value = '';
        if (this.value) loadRegencies(this.value, false);
    });

    selRegency.addEventListener('change', function () {
        hidKota.value = this.options[this.selectedIndex].textContent;
        resetSelect(selDistrict, '-- Pilih Kecamatan --');
        resetSelect(selVillage, '-- Pilih Kelurahan/Desa --');
        hidKecamatan.value = '';
        hidKelurahan.value = '';
        if (this.value) loadDistricts(this.value, false);
    });

    selDistrict.addEventListener('change', function () {
        hidKecamatan.value = this.options[this.selectedIndex].textContent;
        resetSelect(selVillage, '-- Pilih Kelurahan/Desa --');
        hidKelurahan.value = '';
        if (this.value) loadVillages(this.value, false);
    });

    selVillage.addEventListener('change', function () {
        hidKelurahan.value = this.options[this.selectedIndex].textContent;
    });
})();
</script>
</html>
