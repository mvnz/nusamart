@extends('layouts.app')

@section('title', 'Akun Saya - NusaMart')

@push('styles')
<style>
.profile-form{padding:24px 20px}
.profile-form>.form-group{margin-bottom:20px}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:30px;margin-bottom:20px}
.form-group select{width:100%;padding:12px 16px;border:2px solid #e8e8e8;border-radius:10px;font-size:14px;font-family:'Montserrat',sans-serif;color:#333;transition:all 0.3s ease;outline:none;background:#f8f9fa;appearance:auto}
.form-group select:focus{border-color:#D10024;background:#fff;box-shadow:0 0 0 3px rgba(209,0,36,0.1)}
.form-group select:disabled{background:#f0f0f0;color:#aaa;cursor:not-allowed;opacity:0.7}
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
                            <img src="{{ asset('uploads/' . auth()->user()->photo) }}" alt="Foto Profil" class="profile-avatar-img">
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
                                    <input type="text" id="username" name="username" value="{{ old('username', auth()->user()->username) }}" required>
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
                                    <input type="text" id="kodepos" name="kodepos" value="{{ old('kodepos', auth()->user()->kodepos) }}" placeholder="12345" maxlength="10" pattern="[0-9]*" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
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
    const urls = {
        provinces: '{{ route('wilayah.provinces') }}',
        regencies: (code) => '{{ url('api/wilayah/regencies') }}/' + code,
        districts: (code) => '{{ url('api/wilayah/districts') }}/' + code,
        villages: (code) => '{{ url('api/wilayah/villages') }}/' + code,
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
        // Sync hidden name field after populating
        if (sel.value && sel.selectedIndex > 0) {
            const name = sel.options[sel.selectedIndex].textContent;
            if (sel === selProvince) hidPropinsi.value = name;
            if (sel === selRegency)  hidKota.value = name;
            if (sel === selDistrict) hidKecamatan.value = name;
            if (sel === selVillage)  hidKelurahan.value = name;
        }
    }

    function resetSelect(sel, placeholder) {
        sel.innerHTML = '<option value="">' + placeholder + '</option>';
        sel.disabled = true;
    }

    // Load provinces on page load, then cascade through saved values
    fetch(urls.provinces)
        .then(r => r.json())
        .then(function (data) {
            populateSelect(selProvince, data, '-- Pilih Provinsi --', initial.province_code);
            if (initial.province_code) {
                fetch(urls.regencies(initial.province_code))
                    .then(r => r.json())
                    .then(function (d) {
                        populateSelect(selRegency, d, '-- Pilih Kota/Kab --', initial.regency_code);
                        if (initial.regency_code) {
                            fetch(urls.districts(initial.regency_code))
                                .then(r => r.json())
                                .then(function (d2) {
                                    populateSelect(selDistrict, d2, '-- Pilih Kecamatan --', initial.district_code);
                                    if (initial.district_code) {
                                        fetch(urls.villages(initial.district_code))
                                            .then(r => r.json())
                                            .then(function (d3) {
                                                populateSelect(selVillage, d3, '-- Pilih Kelurahan/Desa --', initial.village_code);
                                            });
                                    }
                                });
                        }
                    });
            }
        });

    selProvince.addEventListener('change', function () {
        hidPropinsi.value = this.options[this.selectedIndex].textContent;
        resetSelect(selRegency, '-- Pilih Kota/Kab --');
        resetSelect(selDistrict, '-- Pilih Kecamatan --');
        resetSelect(selVillage, '-- Pilih Kelurahan/Desa --');
        hidKota.value = ''; hidKecamatan.value = ''; hidKelurahan.value = '';
        if (this.value) {
            fetch(urls.regencies(this.value)).then(r => r.json()).then(function (d) {
                populateSelect(selRegency, d, '-- Pilih Kota/Kab --', null);
            });
        }
    });

    selRegency.addEventListener('change', function () {
        hidKota.value = this.options[this.selectedIndex].textContent;
        resetSelect(selDistrict, '-- Pilih Kecamatan --');
        resetSelect(selVillage, '-- Pilih Kelurahan/Desa --');
        hidKecamatan.value = ''; hidKelurahan.value = '';
        if (this.value) {
            fetch(urls.districts(this.value)).then(r => r.json()).then(function (d) {
                populateSelect(selDistrict, d, '-- Pilih Kecamatan --', null);
            });
        }
    });

    selDistrict.addEventListener('change', function () {
        hidKecamatan.value = this.options[this.selectedIndex].textContent;
        resetSelect(selVillage, '-- Pilih Kelurahan/Desa --');
        hidKelurahan.value = '';
        if (this.value) {
            fetch(urls.villages(this.value)).then(r => r.json()).then(function (d) {
                populateSelect(selVillage, d, '-- Pilih Kelurahan/Desa --', null);
            });
        }
    });

    selVillage.addEventListener('change', function () {
        hidKelurahan.value = this.options[this.selectedIndex].textContent;
    });
})();
</script>
@endpush
