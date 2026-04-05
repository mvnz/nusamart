@extends('layouts.app')

@section('title', 'Akun Saya - NusaMart')

@push('styles')
<style>
.profile-form{padding:24px 20px}
.profile-form>.form-group{margin-bottom:20px}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:30px;margin-bottom:20px}
.ss{position:relative;width:100%}
.ss-trigger{display:flex;align-items:center;justify-content:space-between;padding:11px 14px;border:2px solid #e8e8e8;border-radius:10px;background:#f8f9fa;cursor:pointer;font-size:14px;color:#333;user-select:none;min-height:46px;transition:border-color .2s}
.ss:not(.ss-disabled) .ss-trigger:hover{border-color:#D10024}
.ss.ss-open .ss-trigger{border-color:#D10024;background:#fff}
.ss-trigger-text.ss-empty{color:#b0b0b0}
.ss-caret{width:0;height:0;border:5px solid transparent;border-top:6px solid #888;margin-top:3px;flex-shrink:0;transition:transform .2s}
.ss.ss-open .ss-caret{transform:rotate(180deg);margin-top:-3px}
.ss-panel{display:none;position:fixed;background:#fff;border:1px solid #ddd;border-radius:8px;box-shadow:0 6px 20px rgba(0,0,0,.12);z-index:9999}
.ss-panel.ss-panel-open{display:block}
.ss-search{padding:8px 10px;border-bottom:1px solid #f0f0f0}
.ss-search input{width:100%;border:1px solid #e0e0e0;border-radius:6px;padding:7px 10px;font-size:13px;font-family:'Montserrat',sans-serif;outline:none;color:#333;background:#fafafa}
.ss-search input:focus{border-color:#D10024;background:#fff}
.ss-list{max-height:210px;overflow-y:auto;padding:4px 0}
.ss-item{padding:9px 14px;cursor:pointer;font-size:13px;color:#444;transition:background .15s}
.ss-item:hover,.ss-item.ss-focused{background:#fff5f5;color:#D10024}
.ss-item.ss-selected{background:#fff5f5;color:#D10024;font-weight:600}
.ss-empty-msg{padding:9px 14px;color:#999;font-size:13px;text-align:center}
.ss.ss-disabled .ss-trigger{background:#f0f0f0;color:#aaa;cursor:not-allowed;border-color:#e8e8e8;pointer-events:none}
select.ss-native{display:none!important}
</style>
@endpush

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Beranda</a></li>
            <li class="active">Akun Saya</li>
        </ul>
    </div>
</div>

<section class="profile-page-section">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fa fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-circle"></i>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="profile-page-grid">
            <!-- Sidebar -->
            <div class="profile-sidebar">
                <div class="profile-avatar-card">
                    <div class="profile-avatar-wrapper">
                        @if(auth()->user()->photo)
                            <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto Profil" class="profile-avatar-img">
                        @else
                            <div class="profile-avatar">
                                <i class="fa fa-user"></i>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data" id="photoForm">
                            @csrf
                            <label class="photo-upload-btn" title="Ganti Foto">
                                <i class="fa fa-camera"></i>
                                <input type="file" name="photo" accept="image/jpeg,image/png,image/jpg,image/webp" hidden onchange="document.getElementById('photoForm').submit()">
                            </label>
                        </form>
                        @if(auth()->user()->photo)
                            <form method="POST" action="{{ route('profile.photo.delete') }}" class="photo-delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="photo-delete-btn" title="Hapus Foto"><i class="fa fa-times"></i></button>
                            </form>
                        @endif
                    </div>
                    <h3 class="profile-name">{{ auth()->user()->name }}</h3>
                    <span class="profile-role-badge">
                        <i class="fa {{ auth()->user()->role === 'admin' ? 'fa-shield' : (auth()->user()->role === 'penjual' ? 'fa-store' : 'fa-shopping-bag') }}"></i>
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                    <p class="profile-joined"><i class="fa fa-calendar"></i> Bergabung {{ auth()->user()->created_at->translatedFormat('d F Y') }}</p>
                </div>

                <nav class="profile-nav">
                    <a href="{{ route('profile') }}" class="active"><i class="fa fa-user"></i> Profil Saya</a>
                    <a href="{{ route('profile.password') }}"><i class="fa fa-lock"></i> Ubah Password</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="profile-main">
                <!-- Account Info Card -->
                <div class="profile-info-card">
                    <div class="card-header">
                        <h3><i class="fa fa-user"></i> Informasi Akun</h3>
                    </div>
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="profile-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name"><i class="fa fa-id-card-o"></i> Nama Lengkap</label>
                                    <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="username"><i class="fa fa-at"></i> Username</label>
                                    <input type="text" id="username" value="{{ auth()->user()->username }}" readonly style="background:#f0f0f0;cursor:not-allowed;">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="email"><i class="fa fa-envelope-o"></i> Email</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone"><i class="fa fa-phone"></i> No. Telepon</label>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alamat"><i class="fa fa-home"></i> Alamat (Nama Jalan/Gang/No. Rumah)</label>
                                <input type="text" id="alamat" name="alamat" value="{{ old('alamat', auth()->user()->alamat) }}" required>
                            </div>

                            {{-- Hidden name fields populated by JS --}}
                            <input type="hidden" id="propinsi" name="propinsi" value="{{ old('propinsi', auth()->user()->propinsi) }}">
                            <input type="hidden" id="kota" name="kota" value="{{ old('kota', auth()->user()->kota) }}">
                            <input type="hidden" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', auth()->user()->kecamatan) }}">
                            <input type="hidden" id="kelurahan" name="kelurahan" value="{{ old('kelurahan', auth()->user()->kelurahan) }}">

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="province_code"><i class="fa fa-map-marker"></i> Provinsi</label>
                                    <select id="province_code" name="province_code" required>
                                        <option value="">-- Memuat data... --</option>
                                    </select>
                                    @error('province_code')
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
                                </div>
                                <div class="form-group">
                                    <label for="village_code"><i class="fa fa-home"></i> Kelurahan / Desa</label>
                                    <select id="village_code" name="village_code" disabled required>
                                        <option value="">-- Pilih Kecamatan dulu --</option>
                                    </select>
                                    @error('village_code')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row" style="grid-template-columns:1fr 1fr 1fr">
                                <div class="form-group">
                                    <label for="rt"><i class="fa fa-hashtag"></i> RT</label>
                                    <input type="text" id="rt" name="rt" value="{{ old('rt', auth()->user()->rt) }}" placeholder="001" maxlength="5" pattern="[0-9]*" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                                    @error('rt')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="rw"><i class="fa fa-hashtag"></i> RW</label>
                                    <input type="text" id="rw" name="rw" value="{{ old('rw', auth()->user()->rw) }}" placeholder="001" maxlength="5" pattern="[0-9]*" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                                    @error('rw')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="kodepos"><i class="fa fa-envelope-o"></i> Kode Pos</label>
                                    <input type="text" id="kodepos" name="kodepos" value="{{ old('kodepos', auth()->user()->kodepos) }}" placeholder="12345" maxlength="5" minlength="5" pattern="[0-9]{5}" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,5)" required>
                                    @error('kodepos')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn-save"><i class="fa fa-save"></i> Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
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

        const trigger  = wrapper.querySelector('.ss-trigger');
        const trigText = wrapper.querySelector('.ss-trigger-text');
        const searchEl = panel.querySelector('.ss-search input');
        const listEl   = panel.querySelector('.ss-list');
        let   items    = [];

        function positionPanel() {
            const rect = trigger.getBoundingClientRect();
            panel.style.top   = (rect.bottom + 3) + 'px';
            panel.style.left  = rect.left + 'px';
            panel.style.width = rect.width + 'px';
        }

        function renderList(q) {
            listEl.innerHTML = '';
            const filtered = q ? items.filter(i => i.label.toLowerCase().includes(q.toLowerCase())) : items;
            if (!filtered.length) { listEl.innerHTML = '<div class="ss-empty-msg">Tidak ditemukan</div>'; return; }
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
            document.querySelectorAll('.ss.ss-open').forEach(function(el) { if (el !== wrapper) el.classList.remove('ss-open'); });
            document.querySelectorAll('.ss-panel.ss-panel-open').forEach(function(el) { if (el !== panel) el.classList.remove('ss-panel-open'); });
            items = Array.from(select.options).filter(o => o.value).map(o => ({ value: o.value, label: o.textContent }));
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

        trigger.addEventListener('click', function() { wrapper.classList.contains('ss-open') ? close() : open(); });
        searchEl.addEventListener('input', function() { renderList(this.value); });
        document.addEventListener('click', function(e) { if (!wrapper.contains(e.target) && !panel.contains(e.target)) close(); });
        window.addEventListener('scroll', function() { if (panel.classList.contains('ss-panel-open')) positionPanel(); }, true);
        window.addEventListener('resize', function() { if (panel.classList.contains('ss-panel-open')) close(); });

        return {
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
                    if (opt) { select.value = selectedCode; trigText.textContent = opt.textContent; trigText.classList.remove('ss-empty'); }
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

    const saved = {
        province_code: '{{ auth()->user()->province_code ?? '' }}',
        regency_code:  '{{ auth()->user()->regency_code ?? '' }}',
        district_code: '{{ auth()->user()->district_code ?? '' }}',
        village_code:  '{{ auth()->user()->village_code ?? '' }}',
    };

    const old = {
        province_code: '{{ old('province_code') }}',
        regency_code:  '{{ old('regency_code') }}',
        district_code: '{{ old('district_code') }}',
        village_code:  '{{ old('village_code') }}',
    };

    // On validation error old values take precedence; otherwise use saved values
    const initial = {
        province_code: old.province_code || saved.province_code,
        regency_code:  old.regency_code  || saved.regency_code,
        district_code: old.district_code || saved.district_code,
        village_code:  old.village_code  || saved.village_code,
    };

    const hidPropinsi  = document.getElementById('propinsi');
    const hidKota      = document.getElementById('kota');
    const hidKecamatan = document.getElementById('kecamatan');
    const hidKelurahan = document.getElementById('kelurahan');

    const ssProvince = makeSearchableSelect('province_code', '-- Pilih Provinsi --');
    const ssRegency  = makeSearchableSelect('regency_code',  '-- Pilih Kota/Kab --');
    const ssDistrict = makeSearchableSelect('district_code', '-- Pilih Kecamatan --');
    const ssVillage  = makeSearchableSelect('village_code',  '-- Pilih Kelurahan/Desa --');

    // Load provinces on page load, then cascade through saved/old values
    fetch(urls.provinces)
        .then(r => r.json())
        .then(function(data) {
            ssProvince.populate(data, initial.province_code);
            if (initial.province_code) {
                const pOpt = document.querySelector('#province_code option[value="' + initial.province_code + '"]');
                if (pOpt) hidPropinsi.value = pOpt.textContent;
                fetch(urls.regencies(initial.province_code))
                    .then(r => r.json())
                    .then(function(d) {
                        ssRegency.populate(d, initial.regency_code);
                        if (initial.regency_code) {
                            const rOpt = document.querySelector('#regency_code option[value="' + initial.regency_code + '"]');
                            if (rOpt) hidKota.value = rOpt.textContent;
                            fetch(urls.districts(initial.regency_code))
                                .then(r => r.json())
                                .then(function(d2) {
                                    ssDistrict.populate(d2, initial.district_code);
                                    if (initial.district_code) {
                                        const dOpt = document.querySelector('#district_code option[value="' + initial.district_code + '"]');
                                        if (dOpt) hidKecamatan.value = dOpt.textContent;
                                        fetch(urls.villages(initial.district_code))
                                            .then(r => r.json())
                                            .then(function(d3) {
                                                ssVillage.populate(d3, initial.village_code);
                                                if (initial.village_code) {
                                                    const vOpt = document.querySelector('#village_code option[value="' + initial.village_code + '"]');
                                                    if (vOpt) hidKelurahan.value = vOpt.textContent;
                                                }
                                            });
                                    }
                                });
                        }
                    });
            }
        });

    document.getElementById('province_code').addEventListener('change', function() {
        hidPropinsi.value = this.options[this.selectedIndex] ? this.options[this.selectedIndex].textContent : '';
        ssRegency.reset('-- Pilih Kota/Kab --');
        ssDistrict.reset('-- Pilih Kecamatan --');
        ssVillage.reset('-- Pilih Kelurahan/Desa --');
        hidKota.value = ''; hidKecamatan.value = ''; hidKelurahan.value = '';
        if (this.value) {
            fetch(urls.regencies(this.value)).then(r => r.json()).then(function(d) { ssRegency.populate(d, null); });
        }
    });

    document.getElementById('regency_code').addEventListener('change', function() {
        hidKota.value = this.options[this.selectedIndex] ? this.options[this.selectedIndex].textContent : '';
        ssDistrict.reset('-- Pilih Kecamatan --');
        ssVillage.reset('-- Pilih Kelurahan/Desa --');
        hidKecamatan.value = ''; hidKelurahan.value = '';
        if (this.value) {
            fetch(urls.districts(this.value)).then(r => r.json()).then(function(d) { ssDistrict.populate(d, null); });
        }
    });

    document.getElementById('district_code').addEventListener('change', function() {
        hidKecamatan.value = this.options[this.selectedIndex] ? this.options[this.selectedIndex].textContent : '';
        ssVillage.reset('-- Pilih Kelurahan/Desa --');
        hidKelurahan.value = '';
        if (this.value) {
            fetch(urls.villages(this.value)).then(r => r.json()).then(function(d) { ssVillage.populate(d, null); });
        }
    });

    document.getElementById('village_code').addEventListener('change', function() {
        hidKelurahan.value = this.options[this.selectedIndex] ? this.options[this.selectedIndex].textContent : '';
    });
})();
</script>
@endpush
