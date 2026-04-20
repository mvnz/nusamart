@extends('layouts.admin')

@section('title', 'Tambah Warung - Admin Panel')

@section('content')
<style>
.kf-wrap { max-width:760px; margin:0 auto; padding:4px 0 52px; }

.kf-page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
.kf-page-title  { font-size:21px; font-weight:800; color:#1e1f29; display:flex; align-items:center; gap:10px; margin:0; }
.kf-page-title i { color:#d97706; font-size:20px; }
.kf-back-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 16px; background:#f4f5f7; color:#555; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; text-decoration:none; transition:background .15s; font-family:inherit; }
.kf-back-btn:hover { background:#e5e7eb; color:#1e1f29; }

/* Hero Banner */
.admin-hero { background:linear-gradient(135deg,#0f0519 0%,#1a0a2e 55%,#2d1500 100%); border-radius:18px; padding:24px 28px; margin-bottom:24px; display:flex; align-items:center; justify-content:space-between; gap:20px; flex-wrap:wrap; color:#fff; position:relative; overflow:hidden; }
.admin-hero::before { content:''; position:absolute; top:-80px; right:-80px; width:260px; height:260px; background:radial-gradient(circle,rgba(217,119,6,.35) 0%,transparent 65%); pointer-events:none; }
.admin-hero-left { display:flex; align-items:center; gap:16px; position:relative; z-index:1; }
.admin-hero-icon { width:50px; height:50px; background:rgba(255,255,255,.12); border-radius:13px; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; border:1px solid rgba(255,255,255,.2); }
.admin-hero-title { font-size:20px; font-weight:800; margin:0 0 3px; letter-spacing:-.4px; }
.admin-hero-sub { font-size:12.5px; margin:0; opacity:.7; }
.admin-hero-back { display:inline-flex; align-items:center; gap:7px; padding:9px 16px; background:rgba(255,255,255,.12); color:#fff; border:1px solid rgba(255,255,255,.2); border-radius:9px; font-size:13px; font-weight:700; text-decoration:none; transition:background .15s; position:relative; z-index:1; }
.admin-hero-back:hover { background:rgba(255,255,255,.2); color:#fff; }

.kf-card { background:#fff; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.07); overflow:hidden; }

.kf-section-divider { padding:14px 24px 10px; background:#f8f9fb; border-bottom:1px solid #f0f0f0; display:flex; align-items:center; gap:8px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#8d8d8d; }
.kf-section-divider i { color:#d97706; }

.kf-body { padding:24px; display:flex; flex-direction:column; gap:18px; }

.kf-grid2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
@media(max-width:580px){ .kf-grid2{ grid-template-columns:1fr; } }
.kf-group { display:flex; flex-direction:column; gap:5px; }
.kf-group.full { grid-column:1/-1; }
.kf-label { font-size:12px; font-weight:700; color:#374151; }
.kf-label .req { color:#D10024; }
.kf-input, .kf-select, .kf-textarea {
    padding:10px 13px; border:1.5px solid #e5e7eb; border-radius:9px;
    font-size:13px; font-family:inherit; outline:none;
    transition:border .2s,box-shadow .2s; background:#f9fafb; color:#1e1f29;
}
.kf-input:focus, .kf-select:focus, .kf-textarea:focus {
    border-color:#d97706; background:#fff; box-shadow:0 0 0 3px rgba(217,119,6,.1);
}
.kf-textarea { resize:vertical; min-height:96px; line-height:1.6; }
.kf-hint  { font-size:11px; color:#9ca3af; }
.kf-error { font-size:11px; color:#D10024; display:flex; align-items:center; gap:4px; }

.kf-time-row { display:flex; align-items:center; gap:8px; }
.kf-time-sep { font-size:16px; font-weight:800; color:#d97706; }

.kf-upload-area {
    border:2px dashed #e5e7eb; border-radius:12px; background:#f9fafb;
    cursor:pointer; overflow:hidden; transition:all .2s;
}
.kf-upload-area:hover { border-color:#d97706; background:#fffbf0; }
.kf-upload-placeholder { display:flex; flex-direction:column; align-items:center; justify-content:center; padding:32px; gap:8px; }
.kf-upload-placeholder i { font-size:28px; color:#d97706; opacity:.5; }
.kf-upload-placeholder strong { font-size:13px; color:#374151; font-weight:700; }
.kf-upload-placeholder span { font-size:11.5px; color:#9ca3af; }
.kf-preview-img { width:100%; max-height:220px; object-fit:cover; display:none; }

.kf-footer { display:flex; align-items:center; justify-content:flex-end; gap:10px; padding:18px 24px; border-top:1px solid #f2f2f5; background:#f8f9fb; }
.kf-cancel { padding:10px 18px; background:#fff; color:#555; border:1.5px solid #e5e7eb; border-radius:9px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; transition:all .15s; text-decoration:none; display:inline-flex; align-items:center; gap:6px; }
.kf-cancel:hover { background:#f4f5f7; color:#1e1f29; }
.kf-submit { padding:10px 24px; background:#D10024; color:#fff; border:none; border-radius:9px; font-size:13px; font-weight:800; cursor:pointer; font-family:inherit; transition:background .15s,transform .1s; display:inline-flex; align-items:center; gap:7px; box-shadow:0 4px 12px rgba(209,0,36,.25); }
.kf-submit:hover { background:#a8001e; }
.kf-submit:active { transform:scale(.97); }
</style>

<div class="kf-wrap">
    <div class="admin-hero">
        <div class="admin-hero-left">
            <div class="admin-hero-icon"><i class="fa fa-plus"></i></div>
            <div>
                <h1 class="admin-hero-title">Tambah Warung Kuliner</h1>
                <p class="admin-hero-sub">Isi informasi warung yang akan ditampilkan di NusaMart</p>
            </div>
        </div>
        <a href="{{ route('admin.kuliner.index') }}" class="admin-hero-back"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>

    @if($errors->any())
    <div style="background:#fff0f2;border:1.5px solid #fecdd3;border-radius:10px;padding:13px 18px;margin-bottom:18px;display:flex;align-items:flex-start;gap:9px;font-size:13px;color:#9f1239;">
        <i class="fa fa-exclamation-circle" style="margin-top:1px;flex-shrink:0;color:#D10024"></i>
        <div><strong>Terdapat {{ $errors->count() }} kesalahan:</strong>
            <ul style="margin:5px 0 0;padding-left:16px;line-height:1.9">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.kuliner.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="kf-card">
        <div class="kf-section-divider"><i class="fa fa-info-circle"></i> Informasi Dasar</div>
        <div class="kf-body">
            <div class="kf-grid2">
                <div class="kf-group full">
                    <label class="kf-label">Nama Warung <span class="req">*</span></label>
                    <input type="text" name="nama" class="kf-input" value="{{ old('nama') }}" placeholder="cth: Warung Nasi Ibu Sari">
                    @error('nama')<div class="kf-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                </div>
                <div class="kf-group">
                    <label class="kf-label">Kategori <span class="req">*</span></label>
                    <select name="kategori" class="kf-select">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach(['Makanan Berat','Jajanan','Minuman','Seafood','Sarapan','Dessert','Lainnya'] as $kat)
                            <option value="{{ $kat }}" {{ old('kategori') === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                    @error('kategori')<div class="kf-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                </div>
                <div class="kf-group">
                    <label class="kf-label">Status <span class="req">*</span></label>
                    <select name="status" class="kf-select">
                        <option value="buka"  {{ old('status','buka') === 'buka'  ? 'selected' : '' }}>Buka</option>
                        <option value="tutup" {{ old('status') === 'tutup' ? 'selected' : '' }}>Tutup</option>
                    </select>
                    @error('status')<div class="kf-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                </div>
                <div class="kf-group full">
                    <label class="kf-label">Deskripsi <span class="req">*</span></label>
                    <textarea name="deskripsi" class="kf-textarea" placeholder="Ceritakan menu andalan, suasana, dll...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')<div class="kf-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="kf-section-divider"><i class="fa fa-camera"></i> Foto Warung</div>
        <div class="kf-body">
            <div class="kf-upload-area" id="kfUpload" onclick="document.getElementById('gambarInput').click()">
                <img id="kfPreviewImg" class="kf-preview-img" src="" alt="">
                <div id="kfPlaceholder" class="kf-upload-placeholder">
                    <i class="fa fa-cloud-upload"></i>
                    <strong>Klik untuk upload foto</strong>
                    <span>Format JPG, JPEG, PNG — Maks. 2MB</span>
                </div>
            </div>
            <input type="file" name="gambar" id="gambarInput" accept="image/jpg,image/jpeg,image/png" style="display:none" onchange="handlePhoto(this)">
            @error('gambar')<div class="kf-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
        </div>

        <div class="kf-section-divider"><i class="fa fa-map-marker"></i> Lokasi &amp; Kontak</div>
        <div class="kf-body">
            <div class="kf-grid2">
                <div class="kf-group full">
                    <label class="kf-label">Alamat Lengkap <span class="req">*</span></label>
                    <input type="text" name="alamat" class="kf-input" value="{{ old('alamat') }}" placeholder="cth: Jl. Raya Manud Jaya No. 12">
                    @error('alamat')<div class="kf-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                </div>
                <div class="kf-group">
                    <label class="kf-label">Jam Operasional <span class="req">*</span></label>
                    <div class="kf-time-row">
                        <input type="time" name="jam_buka"  class="kf-input" value="{{ old('jam_buka') }}"  style="flex:1">
                        <span class="kf-time-sep">–</span>
                        <input type="time" name="jam_tutup" class="kf-input" value="{{ old('jam_tutup') }}" style="flex:1">
                    </div>
                    @error('jam_buka') <div class="kf-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                    @error('jam_tutup')<div class="kf-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                </div>
                <div class="kf-group">
                    <label class="kf-label">Nomor WhatsApp <span class="req">*</span></label>
                    <input type="text" name="kontak_wa" class="kf-input" value="{{ old('kontak_wa') }}" placeholder="cth: 6281234567890">
                    <div class="kf-hint">Format: 62xxx (tanpa + atau 0 di depan)</div>
                    @error('kontak_wa')<div class="kf-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                </div>
                <div class="kf-group full">
                    <label class="kf-label">Link Google Maps <span style="font-weight:400;color:#9ca3af">(opsional)</span></label>
                    <input type="url" name="link_maps" class="kf-input" value="{{ old('link_maps') }}" placeholder="https://maps.google.com/...">
                    @error('link_maps')<div class="kf-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="kf-footer">
            <a href="{{ route('admin.kuliner.index') }}" class="kf-cancel"><i class="fa fa-times"></i> Batal</a>
            <button type="submit" class="kf-submit"><i class="fa fa-save"></i> Simpan Warung</button>
        </div>
    </div>
    </form>
</div>

<script>
function handlePhoto(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.getElementById('kfPreviewImg');
            img.src = e.target.result;
            img.style.display = 'block';
            document.getElementById('kfPlaceholder').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
