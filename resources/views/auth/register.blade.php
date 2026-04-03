<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran - NusaMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ filemtime(public_path('css/auth.css')) }}">
    <style>
        /* Custom Searchable Select */
        .ss { position: relative; width: 100%; }
        .ss-trigger {
            display: flex; align-items: center; justify-content: space-between;
            padding: 11px 14px; border: 2px solid #e8e8e8; border-radius: 10px;
            background: #f8f9fa; cursor: pointer; font-size: 14px; color: #333;
            user-select: none; min-height: 46px; transition: border-color .2s;
        }
        .ss:not(.ss-disabled) .ss-trigger:hover { border-color: #D10024; }
        .ss.ss-open .ss-trigger { border-color: #D10024; background: #fff; }
        .ss-trigger-text.ss-empty { color: #b0b0b0; }
        .ss-caret { width: 0; height: 0; border: 5px solid transparent; border-top: 6px solid #888; margin-top: 3px; flex-shrink: 0; transition: transform .2s; }
        .ss.ss-open .ss-caret { transform: rotate(180deg); margin-top: -3px; }
        .ss-panel {
            display: none; position: fixed;
            background: #fff; border: 1px solid #ddd; border-radius: 8px;
            box-shadow: 0 6px 20px rgba(0,0,0,.12); z-index: 9999;
        }
        .ss-panel.ss-panel-open { display: block; }
        .ss-search { padding: 8px 10px; border-bottom: 1px solid #f0f0f0; }
        .ss-search input {
            width: 100%; border: 1px solid #e0e0e0; border-radius: 6px;
            padding: 7px 10px; font-size: 13px; font-family: 'Montserrat', sans-serif;
            outline: none; color: #333; background: #fafafa;
        }
        .ss-search input:focus { border-color: #D10024; background: #fff; }
        .ss-list { max-height: 210px; overflow-y: auto; padding: 4px 0; }
        .ss-item { padding: 9px 14px; cursor: pointer; font-size: 13px; color: #444; transition: background .15s; }
        .ss-item:hover, .ss-item.ss-focused { background: #fff5f5; color: #D10024; }
        .ss-item.ss-selected { background: #fff5f5; color: #D10024; font-weight: 600; }
        .ss-item.ss-hidden { display: none; }
        .ss-empty-msg { padding: 9px 14px; color: #999; font-size: 13px; text-align: center; }
        .ss.ss-disabled .ss-trigger { background: #f0f0f0; color: #aaa; cursor: not-allowed; border-color: #e8e8e8; pointer-events: none; }
        select.ss-native { display: none !important; }
    </style>
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

                <div class="form-row">
                    <div class="form-group">
                        <label for="tanggal_lahir"><i class="fa fa-calendar"></i> Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" max="{{ date('Y-m-d', strtotime('-1 day')) }}" required>
                        @error('tanggal_lahir')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label><i class="fa fa-venus-mars"></i> Jenis Kelamin</label>
                        <div style="display:flex;gap:20px;align-items:center;padding-top:8px">
                            <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-weight:normal;white-space:nowrap">
                                <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }} required> Laki-laki
                            </label>
                            <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-weight:normal;white-space:nowrap">
                                <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }}> Perempuan
                            </label>
                        </div>
                        @error('jenis_kelamin')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
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
                        <input type="text" id="kodepos" name="kodepos" value="{{ old('kodepos') }}" placeholder="12345" maxlength="5" minlength="5" pattern="[0-9]{5}" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,5)" required>
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
                    <label><i class="fa fa-user-plus"></i> Daftar sebagai </label>
                    <div class="role-selector">
                        <div class="role-option">
                            <input type="radio" id="pembeli" name="role" value="pembeli" {{ old('role') == 'pembeli' ? 'checked' : '' }}>
                            <label for="pembeli" class="role-label"><i class="fa fa-shopping-bag"></i> Pembeli</label>
                        </div>
                        <div class="role-option">
                            <input type="radio" id="penjual" name="role" value="penjual" {{ old('role') == 'penjual' ? 'checked' : '' }}>
                            <label for="penjual" class="role-label"><i class="fa fa-building-o"></i> Penjual</label>
                        </div>
                    </div>
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
    // ── Custom Searchable Select ────────────────────────────────
    function makeSearchableSelect(selectId, placeholder) {
        const select = document.getElementById(selectId);
        if (!select) return null;
        select.classList.add('ss-native');

        const wrapper = document.createElement('div');
        wrapper.className = 'ss' + (select.disabled ? ' ss-disabled' : '');
        select.parentNode.insertBefore(wrapper, select);
        wrapper.appendChild(select);

        wrapper.insertAdjacentHTML('beforeend',
            '<div class="ss-trigger">' +
                '<span class="ss-trigger-text ss-empty">' + placeholder + '</span>' +
                '<span class="ss-caret"></span>' +
            '</div>');

        const panel = document.createElement('div');
        panel.className = 'ss-panel';
        panel.innerHTML =
            '<div class="ss-search"><input type="text" placeholder="Search..."></div>' +
            '<div class="ss-list"></div>';
        document.body.appendChild(panel);

        const trigger   = wrapper.querySelector('.ss-trigger');
        const trigText  = wrapper.querySelector('.ss-trigger-text');
        const searchEl  = panel.querySelector('.ss-search input');
        const listEl    = panel.querySelector('.ss-list');
        let   items     = [];

        function positionPanel() {
            const rect = trigger.getBoundingClientRect();
            panel.style.top   = (rect.bottom + 3) + 'px';
            panel.style.left  = rect.left + 'px';
            panel.style.width = rect.width + 'px';
        }

        function renderList(q) {
            listEl.innerHTML = '';
            const filtered = q ? items.filter(i => i.label.toLowerCase().includes(q.toLowerCase())) : items;
            if (!filtered.length) {
                listEl.innerHTML = '<div class="ss-empty-msg">Tidak ditemukan</div>';
                return;
            }
            filtered.forEach(function(item) {
                const d = document.createElement('div');
                d.className = 'ss-item' + (select.value === item.value ? ' ss-selected' : '');
                d.textContent = item.label;
                d.addEventListener('click', function() {
                    select.value = item.value;
                    trigText.textContent = item.label;
                    trigText.classList.remove('ss-empty');
                    close();
                    select.dispatchEvent(new Event('change'));
                });
                listEl.appendChild(d);
            });
        }

        function open() {
            if (wrapper.classList.contains('ss-disabled')) return;
            document.querySelectorAll('.ss.ss-open').forEach(function(el) {
                if (el !== wrapper) el.classList.remove('ss-open');
            });
            document.querySelectorAll('.ss-panel.ss-panel-open').forEach(function(el) {
                if (el !== panel) el.classList.remove('ss-panel-open');
            });
            items = Array.from(select.options)
                .filter(o => o.value)
                .map(o => ({ value: o.value, label: o.textContent }));
            searchEl.value = '';
            renderList('');
            positionPanel();
            wrapper.classList.add('ss-open');
            panel.classList.add('ss-panel-open');
            searchEl.focus();
        }

        function close() {
            wrapper.classList.remove('ss-open');
            panel.classList.remove('ss-panel-open');
        }

        trigger.addEventListener('click', function() {
            wrapper.classList.contains('ss-open') ? close() : open();
        });
        searchEl.addEventListener('input', function() { renderList(this.value); });
        document.addEventListener('click', function(e) {
            if (!wrapper.contains(e.target) && !panel.contains(e.target)) close();
        });
        window.addEventListener('scroll', function() { if (panel.classList.contains('ss-panel-open')) positionPanel(); }, true);
        window.addEventListener('resize', function() { if (panel.classList.contains('ss-panel-open')) close(); });

        return {
            disable:  function() { wrapper.classList.add('ss-disabled'); },
            enable:   function() { wrapper.classList.remove('ss-disabled'); },
            clear:    function() {
                select.value = '';
                trigText.textContent = placeholder;
                trigText.classList.add('ss-empty');
            },
            populate: function(data, selectedCode) {
                while (select.options.length > 1) select.remove(1);
                data.forEach(function(item) {
                    const opt = document.createElement('option');
                    opt.value = item.code;
                    opt.textContent = item.name;
                    select.appendChild(opt);
                });
                select.disabled = false;
                wrapper.classList.remove('ss-disabled');
                if (selectedCode) {
                    const opt = Array.from(select.options).find(o => o.value === selectedCode);
                    if (opt) {
                        select.value = selectedCode;
                        trigText.textContent = opt.textContent;
                        trigText.classList.remove('ss-empty');
                    }
                }
            },
            reset: function(ph) {
                close();
                while (select.options.length > 1) select.remove(1);
                select.value = '';
                select.disabled = true;
                wrapper.classList.add('ss-disabled');
                trigText.textContent = ph || placeholder;
                trigText.classList.add('ss-empty');
            }
        };
    }

    // ── Setup ───────────────────────────────────────────────────
    const urls = {
        provinces: '{{ route('wilayah.provinces') }}',
        regencies: (code) => '{{ url('api/wilayah/regencies') }}/' + code,
        districts: (code) => '{{ url('api/wilayah/districts') }}/' + code,
        villages:  (code) => '{{ url('api/wilayah/villages') }}/' + code,
    };
    const old = {
        province_code: '{{ old('province_code') }}',
        regency_code:  '{{ old('regency_code') }}',
        district_code: '{{ old('district_code') }}',
        village_code:  '{{ old('village_code') }}',
    };

    const hidPropinsi  = document.getElementById('propinsi');
    const hidKota      = document.getElementById('kota');
    const hidKecamatan = document.getElementById('kecamatan');
    const hidKelurahan = document.getElementById('kelurahan');

    const ssProvince = makeSearchableSelect('province_code', '-- Pilih Provinsi --');
    const ssRegency  = makeSearchableSelect('regency_code',  '-- Pilih Kota/Kab --');
    const ssDistrict = makeSearchableSelect('district_code', '-- Pilih Kecamatan --');
    const ssVillage  = makeSearchableSelect('village_code',  '-- Pilih Kelurahan/Desa --');

    // Load provinces
    fetch(urls.provinces)
        .then(r => r.json())
        .then(function(data) {
            ssProvince.populate(data, old.province_code);
            if (old.province_code) loadRegencies(old.province_code, true);
        });

    function loadRegencies(code, isOld) {
        fetch(urls.regencies(code))
            .then(r => r.json())
            .then(function(data) {
                ssRegency.populate(data, isOld ? old.regency_code : null);
                if (isOld && old.regency_code) loadDistricts(old.regency_code, true);
            });
    }
    function loadDistricts(code, isOld) {
        fetch(urls.districts(code))
            .then(r => r.json())
            .then(function(data) {
                ssDistrict.populate(data, isOld ? old.district_code : null);
                if (isOld && old.district_code) loadVillages(old.district_code, true);
            });
    }
    function loadVillages(code, isOld) {
        fetch(urls.villages(code))
            .then(r => r.json())
            .then(function(data) {
                ssVillage.populate(data, isOld ? old.village_code : null);
            });
    }

    document.getElementById('province_code').addEventListener('change', function() {
        hidPropinsi.value = this.options[this.selectedIndex] ? this.options[this.selectedIndex].textContent : '';
        ssRegency.reset('-- Pilih Kota/Kab --');
        ssDistrict.reset('-- Pilih Kecamatan --');
        ssVillage.reset('-- Pilih Kelurahan/Desa --');
        hidKota.value = ''; hidKecamatan.value = ''; hidKelurahan.value = '';
        if (this.value) loadRegencies(this.value, false);
    });
    document.getElementById('regency_code').addEventListener('change', function() {
        hidKota.value = this.options[this.selectedIndex] ? this.options[this.selectedIndex].textContent : '';
        ssDistrict.reset('-- Pilih Kecamatan --');
        ssVillage.reset('-- Pilih Kelurahan/Desa --');
        hidKecamatan.value = ''; hidKelurahan.value = '';
        if (this.value) loadDistricts(this.value, false);
    });
    document.getElementById('district_code').addEventListener('change', function() {
        hidKecamatan.value = this.options[this.selectedIndex] ? this.options[this.selectedIndex].textContent : '';
        ssVillage.reset('-- Pilih Kelurahan/Desa --');
        hidKelurahan.value = '';
        if (this.value) loadVillages(this.value, false);
    });
    document.getElementById('village_code').addEventListener('change', function() {
        hidKelurahan.value = this.options[this.selectedIndex] ? this.options[this.selectedIndex].textContent : '';
    });
})();
</script>
</html>
