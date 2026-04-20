@extends('layouts.admin')

@section('title', 'Tambah Warung - Admin Panel')

@section('content')
<style>
.kf-wrap { max-width: 820px; margin: 0 auto; padding: 4px 0 52px; }

/* Hero Banner */
.admin-hero { background:linear-gradient(135deg,#1a0a0e 0%,#2d0a15 55%,#3d0018 100%); border-radius:18px; padding:24px 28px; margin-bottom:24px; display:flex; align-items:center; justify-content:space-between; gap:20px; flex-wrap:wrap; color:#fff; position:relative; overflow:hidden; }
.admin-hero::before { content:''; position:absolute; top:-80px; right:-80px; width:260px; height:260px; background:radial-gradient(circle,rgba(209,0,36,.3) 0%,transparent 65%); pointer-events:none; }
.admin-hero-left { display:flex; align-items:center; gap:16px; position:relative; z-index:1; }
.admin-hero-icon { width:50px; height:50px; background:rgba(255,255,255,.12); border-radius:13px; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; border:1px solid rgba(255,255,255,.2); }
.admin-hero-title { font-size:20px; font-weight:800; margin:0 0 3px; letter-spacing:-.4px; }
.admin-hero-sub { font-size:12.5px; margin:0; opacity:.7; }
.admin-hero-back { display:inline-flex; align-items:center; gap:7px; padding:9px 16px; background:rgba(255,255,255,.12); color:#fff; border:1px solid rgba(255,255,255,.2); border-radius:9px; font-size:13px; font-weight:700; text-decoration:none; transition:background .15s; position:relative; z-index:1; }
.admin-hero-back:hover { background:rgba(255,255,255,.2); color:#fff; }

/* ===== STEP BAR ===== */
.step-bar {
    display:flex; align-items:center; margin-bottom:24px;
    background:linear-gradient(135deg,#1a0a0e 0%,#2d0a15 50%,#3d0018 100%);
    border-radius:16px; padding:22px 32px;
    box-shadow:0 6px 24px rgba(209,0,36,.18);
    position:relative; overflow:hidden;
}
.step-bar::before { content:''; position:absolute; top:-40px; right:-40px; width:180px; height:180px; border-radius:50%; background:rgba(255,255,255,.04); pointer-events:none; }
.step-item { display:flex; align-items:center; flex:1; position:relative; }
.step-item:not(:last-child)::after { content:''; flex:1; height:2px; background:rgba(255,255,255,.15); margin:0 10px; transition:background .4s; }
.step-item.done:not(:last-child)::after { background:rgba(255,255,255,.7); }
.step-circle { width:40px; height:40px; border-radius:50%; border:2px solid rgba(255,255,255,.25); display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:800; background:rgba(255,255,255,.08); color:rgba(255,255,255,.4); flex-shrink:0; transition:all .3s; position:relative; z-index:1; }
.step-item.active .step-circle { border-color:#fff; background:#D10024; color:#fff; box-shadow:0 0 0 4px rgba(255,255,255,.15); }
.step-item.done .step-circle { border-color:#fff; background:rgba(255,255,255,.9); color:#D10024; }
.step-item.done .step-circle::after { content:'\f00c'; font-family:FontAwesome; }
.step-label { margin-left:12px; }
.step-label-title { font-size:13px; font-weight:700; color:rgba(255,255,255,.4); transition:color .3s; }
.step-item.active .step-label-title { color:#fff; }
.step-item.done  .step-label-title { color:rgba(255,255,255,.8); }
.step-label-sub { font-size:11px; color:rgba(255,255,255,.3); margin-top:2px; }
.step-item.active .step-label-sub { color:rgba(255,255,255,.55); }

/* ===== WIZARD CARD ===== */
.wizard-card { background:#fff; border-radius:16px; padding:32px; box-shadow:0 4px 20px rgba(0,0,0,.08); margin-bottom:16px; }
.wizard-card-title { font-size:18px; font-weight:800; color:#1e1f29; margin-bottom:5px; display:flex; align-items:center; gap:10px; }
.wizard-card-title-icon { width:34px; height:34px; border-radius:10px; background:linear-gradient(135deg,#fee2e2,#fecaca); display:flex; align-items:center; justify-content:center; color:#D10024; font-size:14px; flex-shrink:0; }
.wizard-card-subtitle { font-size:13px; color:#9ca3af; margin-bottom:26px; margin-left:44px; }

/* ===== FORM ELEMENTS ===== */
.form-group { margin-bottom:22px; }
.form-group:last-child { margin-bottom:0; }
.form-label { display:block; margin-bottom:8px; font-weight:700; color:#374151; font-size:13px; }
.form-label .req { color:#D10024; }
.form-control { width:100%; padding:12px 16px; border:1.5px solid #e5e7eb; border-radius:10px; font-size:13px; font-family:inherit; box-sizing:border-box; transition:all .2s; background:#fafafa; color:#1e1f29; }
.form-control:focus { outline:none; border-color:#D10024; box-shadow:0 0 0 3px rgba(209,0,36,.1); background:#fff; }
.form-hint { font-size:11px; color:#9ca3af; margin-top:6px; display:block; }
.form-error { font-size:11px; color:#D10024; margin-top:5px; display:flex; align-items:center; gap:4px; }

.form-grid2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
@media(max-width:580px){ .form-grid2{ grid-template-columns:1fr; } }
.form-group.full { grid-column:1/-1; }

.time-row { display:flex; align-items:center; gap:8px; }
.time-sep { font-size:16px; font-weight:800; color:#D10024; }

/* ===== UPLOAD ===== */
.kf-upload-area { border:2px dashed #e5e7eb; border-radius:12px; background:#f9fafb; cursor:pointer; overflow:hidden; transition:all .2s; }
.kf-upload-area:hover { border-color:#D10024; background:#fff0f2; }
.kf-upload-placeholder { display:flex; flex-direction:column; align-items:center; justify-content:center; padding:36px; gap:8px; }
.kf-upload-placeholder i { font-size:30px; color:#D10024; opacity:.45; }
.kf-upload-placeholder strong { font-size:13px; color:#374151; font-weight:700; }
.kf-upload-placeholder span { font-size:11.5px; color:#9ca3af; }
.kf-preview-img { width:100%; max-height:240px; object-fit:cover; display:none; }

/* ===== CONFIRM CARD ===== */
.confirm-card { background:#f8f9fb; border-radius:14px; overflow:hidden; margin-bottom:20px; border:1px solid #f0f0f0; }
.confirm-header { display:flex; align-items:center; gap:16px; padding:18px 22px; background:#fff; border-bottom:1px solid #f0f0f0; }
.confirm-header-img { width:80px; height:80px; object-fit:cover; border-radius:12px; background:linear-gradient(135deg,#fee2e2,#fecaca); display:flex; align-items:center; justify-content:center; flex-shrink:0; overflow:hidden; }
.confirm-header-img img { width:100%; height:100%; object-fit:cover; display:none; }
.confirm-header-img i { font-size:26px; color:rgba(209,0,36,.35); }
.confirm-header-name { font-size:16px; font-weight:800; color:#1e1f29; margin-bottom:4px; }
.confirm-header-sub { font-size:12px; color:#9ca3af; }
.confirm-rows { padding:4px 0; }
.confirm-row { display:flex; justify-content:space-between; align-items:flex-start; padding:12px 22px; font-size:13px; border-bottom:1px solid #f3f4f6; gap:16px; }
.confirm-row:last-child { border-bottom:none; }
.confirm-row-label { color:#9ca3af; display:flex; align-items:center; gap:9px; flex-shrink:0; min-width:130px; }
.confirm-row-label i { width:16px; text-align:center; }
.confirm-row-value { font-weight:700; color:#1e1f29; text-align:right; word-break:break-word; }
.confirm-badge { display:inline-block; padding:3px 11px; border-radius:20px; font-size:11px; font-weight:700; }
.confirm-badge.buka  { background:#d1fae5; color:#065f46; }
.confirm-badge.tutup { background:#fee2e2; color:#991b1b; }
.confirm-notice { background:#fffbeb; border:1.5px solid #fde68a; border-radius:12px; padding:14px 18px; font-size:12px; color:#b45309; display:flex; gap:10px; align-items:flex-start; }

/* ===== NAV BUTTONS ===== */
.wizard-nav { display:flex; gap:12px; justify-content:space-between; align-items:center; background:#fff; border-radius:16px; padding:20px 28px; box-shadow:0 4px 20px rgba(0,0,0,.08); }
.wbtn { padding:12px 26px; border:none; border-radius:10px; font-size:13px; font-weight:800; cursor:pointer; transition:all .22s; display:inline-flex; align-items:center; gap:8px; text-decoration:none; font-family:inherit; }
.wbtn-primary { background:linear-gradient(135deg,#D10024,#ff4d6d); color:#fff; box-shadow:0 4px 14px rgba(209,0,36,.3); }
.wbtn-primary:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(209,0,36,.4); }
.wbtn-secondary { background:#f9fafb; color:#555; border:1.5px solid #e5e7eb; }
.wbtn-secondary:hover { background:#f3f4f6; border-color:#d1d5db; }
.wbtn-success { background:linear-gradient(135deg,#D10024,#ff4d6d); color:#fff; box-shadow:0 4px 14px rgba(209,0,36,.3); }
.wbtn-success:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(209,0,36,.4); }

.alert-err { padding:14px 18px; border-radius:10px; margin-bottom:20px; display:flex; gap:10px; background:#fef2f2; color:#b91c1c; border-left:4px solid #ef4444; }
</style>

<div class="kf-wrap">

    {{-- Hero --}}
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
    <div class="alert-err" style="margin-bottom:20px;">
        <i class="fa fa-exclamation-circle" style="flex-shrink:0;margin-top:2px;"></i>
        <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    </div>
    @endif

    {{-- Step Bar --}}
    <div class="step-bar">
        <div class="step-item active" id="stepItem1">
            <div class="step-circle" id="stepCircle1">1</div>
            <div class="step-label">
                <div class="step-label-title">Informasi Dasar</div>
                <div class="step-label-sub">Nama, kategori, deskripsi</div>
            </div>
        </div>
        <div class="step-item" id="stepItem2">
            <div class="step-circle" id="stepCircle2">2</div>
            <div class="step-label">
                <div class="step-label-title">Foto &amp; Lokasi</div>
                <div class="step-label-sub">Foto, alamat, jam, kontak</div>
            </div>
        </div>
        <div class="step-item" id="stepItem3">
            <div class="step-circle" id="stepCircle3">3</div>
            <div class="step-label">
                <div class="step-label-title">Konfirmasi</div>
                <div class="step-label-sub">Periksa &amp; simpan</div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.kuliner.store') }}" enctype="multipart/form-data" id="klForm">
    @csrf

    {{-- ===== STEP 1 ===== --}}
    <div id="klStep1" class="wizard-step">
        <div class="wizard-card">
            <div class="wizard-card-title">
                <div class="wizard-card-title-icon"><i class="fa fa-info-circle"></i></div>
                Informasi Dasar
            </div>
            <div class="wizard-card-subtitle">Nama warung, kategori, status operasional, dan deskripsi singkat</div>

            <div class="form-grid2">
                <div class="form-group full">
                    <label class="form-label">Nama Warung <span class="req">*</span></label>
                    <input type="text" name="nama" id="klNama" class="form-control"
                           value="{{ old('nama') }}" placeholder="cth: Warung Nasi Ibu Sari">
                    <div class="form-error" id="errNama" style="display:none"><i class="fa fa-times-circle"></i> Nama warung wajib diisi</div>
                    @error('nama')<div class="form-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori <span class="req">*</span></label>
                    <select name="kategori" id="klKategori" class="form-control">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach(['Makanan Berat','Jajanan','Minuman','Seafood','Sarapan','Dessert','Lainnya'] as $kat)
                            <option value="{{ $kat }}" {{ old('kategori') === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                    <div class="form-error" id="errKategori" style="display:none"><i class="fa fa-times-circle"></i> Pilih kategori</div>
                    @error('kategori')<div class="form-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Status <span class="req">*</span></label>
                    <select name="status" id="klStatus" class="form-control">
                        <option value="buka"  {{ old('status','buka') === 'buka'  ? 'selected' : '' }}>Buka</option>
                        <option value="tutup" {{ old('status') === 'tutup' ? 'selected' : '' }}>Tutup</option>
                    </select>
                    @error('status')<div class="form-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                </div>
                <div class="form-group full">
                    <label class="form-label">Deskripsi <span class="req">*</span></label>
                    <textarea name="deskripsi" id="klDeskripsi" class="form-control" rows="4"
                              placeholder="Ceritakan menu andalan, suasana, dll...">{{ old('deskripsi') }}</textarea>
                    <div class="form-error" id="errDeskripsi" style="display:none"><i class="fa fa-times-circle"></i> Deskripsi wajib diisi</div>
                    @error('deskripsi')<div class="form-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ===== STEP 2 ===== --}}
    <div id="klStep2" class="wizard-step" style="display:none">
        <div class="wizard-card">
            <div class="wizard-card-title">
                <div class="wizard-card-title-icon"><i class="fa fa-camera"></i></div>
                Foto Warung
            </div>
            <div class="wizard-card-subtitle">Upload foto warung yang menarik untuk ditampilkan ke pengunjung</div>

            <div class="form-group">
                <div class="kf-upload-area" id="kfUpload" onclick="document.getElementById('gambarInput').click()">
                    <img id="kfPreviewImg" class="kf-preview-img" src="" alt="">
                    <div id="kfPlaceholder" class="kf-upload-placeholder">
                        <i class="fa fa-cloud-upload"></i>
                        <strong>Klik untuk upload foto</strong>
                        <span>Format JPG, JPEG, PNG — Maks. 2MB</span>
                    </div>
                </div>
                <input type="file" name="gambar" id="gambarInput" accept="image/jpg,image/jpeg,image/png" style="display:none" onchange="handlePhoto(this)">
                <span class="form-hint">Foto opsional — jika tidak diupload, ikon default akan ditampilkan</span>
                @error('gambar')<div class="form-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="wizard-card">
            <div class="wizard-card-title">
                <div class="wizard-card-title-icon"><i class="fa fa-map-marker"></i></div>
                Lokasi &amp; Kontak
            </div>
            <div class="wizard-card-subtitle">Alamat, jam operasional, dan nomor WhatsApp warung</div>

            <div class="form-grid2">
                <div class="form-group full">
                    <label class="form-label">Alamat Lengkap <span class="req">*</span></label>
                    <input type="text" name="alamat" id="klAlamat" class="form-control"
                           value="{{ old('alamat') }}" placeholder="cth: Jl. Raya Manud Jaya No. 12">
                    <div class="form-error" id="errAlamat" style="display:none"><i class="fa fa-times-circle"></i> Alamat wajib diisi</div>
                    @error('alamat')<div class="form-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Jam Operasional <span class="req">*</span></label>
                    <div class="time-row">
                        <input type="time" name="jam_buka"  id="klJamBuka"  class="form-control" value="{{ old('jam_buka') }}"  style="flex:1">
                        <span class="time-sep">–</span>
                        <input type="time" name="jam_tutup" id="klJamTutup" class="form-control" value="{{ old('jam_tutup') }}" style="flex:1">
                    </div>
                    <div class="form-error" id="errJam" style="display:none"><i class="fa fa-times-circle"></i> Jam buka dan tutup wajib diisi</div>
                    @error('jam_buka') <div class="form-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                    @error('jam_tutup')<div class="form-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor WhatsApp <span class="req">*</span></label>
                    <input type="text" name="kontak_wa" id="klWa" class="form-control"
                           value="{{ old('kontak_wa') }}" placeholder="cth: 6281234567890">
                    <span class="form-hint">Format: 62xxx (tanpa + atau 0 di depan)</span>
                    <div class="form-error" id="errWa" style="display:none"><i class="fa fa-times-circle"></i> Nomor WhatsApp wajib diisi</div>
                    @error('kontak_wa')<div class="form-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                </div>
                <div class="form-group full">
                    <label class="form-label">Link Google Maps <span style="font-weight:400;color:#9ca3af">(opsional)</span></label>
                    <input type="url" name="link_maps" id="klMaps" class="form-control"
                           value="{{ old('link_maps') }}" placeholder="https://maps.google.com/...">
                    @error('link_maps')<div class="form-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ===== STEP 3 ===== --}}
    <div id="klStep3" class="wizard-step" style="display:none">
        <div class="wizard-card">
            <div class="wizard-card-title">
                <div class="wizard-card-title-icon"><i class="fa fa-check"></i></div>
                Konfirmasi Data Warung
            </div>
            <div class="wizard-card-subtitle">Periksa kembali semua informasi sebelum disimpan</div>

            <div class="confirm-card">
                <div class="confirm-header">
                    <div class="confirm-header-img" id="confImgWrap">
                        <img id="confImg" src="" alt="">
                        <i class="fa fa-cutlery" id="confImgIcon"></i>
                    </div>
                    <div>
                        <div class="confirm-header-name" id="confNama">—</div>
                        <div class="confirm-header-sub" id="confKategori">—</div>
                    </div>
                </div>
                <div class="confirm-rows">
                    <div class="confirm-row">
                        <span class="confirm-row-label"><i class="fa fa-toggle-on"></i> Status</span>
                        <span class="confirm-row-value" id="confStatus">—</span>
                    </div>
                    <div class="confirm-row">
                        <span class="confirm-row-label"><i class="fa fa-align-left"></i> Deskripsi</span>
                        <span class="confirm-row-value" id="confDeskripsi" style="max-width:320px;font-weight:400;color:#555;">—</span>
                    </div>
                    <div class="confirm-row">
                        <span class="confirm-row-label"><i class="fa fa-map-marker"></i> Alamat</span>
                        <span class="confirm-row-value" id="confAlamat">—</span>
                    </div>
                    <div class="confirm-row">
                        <span class="confirm-row-label"><i class="fa fa-clock-o"></i> Jam Operasional</span>
                        <span class="confirm-row-value" id="confJam">—</span>
                    </div>
                    <div class="confirm-row">
                        <span class="confirm-row-label"><i class="fa fa-whatsapp"></i> WhatsApp</span>
                        <span class="confirm-row-value" id="confWa">—</span>
                    </div>
                    <div class="confirm-row">
                        <span class="confirm-row-label"><i class="fa fa-map"></i> Google Maps</span>
                        <span class="confirm-row-value" id="confMaps">—</span>
                    </div>
                </div>
            </div>

            <div class="confirm-notice">
                <i class="fa fa-info-circle" style="margin-top:1px;flex-shrink:0;"></i>
                <div>Pastikan semua informasi sudah benar. Data warung akan langsung tampil di halaman Kuliner NusaMart setelah disimpan.</div>
            </div>
        </div>
    </div>

    {{-- Nav Buttons --}}
    <div class="wizard-nav">
        <div>
            <button type="button" id="btnBack" class="wbtn wbtn-secondary" style="display:none" onclick="klGoStep(currentStep - 1)">
                <i class="fa fa-arrow-left"></i> Sebelumnya
            </button>
        </div>
        <div style="display:flex;align-items:center;gap:12px;">
            <a href="{{ route('admin.kuliner.index') }}" class="wbtn wbtn-secondary" id="btnCancel">
                <i class="fa fa-times"></i> Batal
            </a>
            <button type="button" id="btnNext" class="wbtn wbtn-primary" onclick="klGoStep(currentStep + 1)">
                Selanjutnya <i class="fa fa-arrow-right"></i>
            </button>
            <button type="submit" id="btnSubmit" class="wbtn wbtn-success" style="display:none">
                <i class="fa fa-save"></i> Simpan Warung
            </button>
        </div>
    </div>

    </form>
</div>

<script>
var currentStep = 1;
var totalSteps  = 3;
var photoDataUrl = null;

function klGoStep(n) {
    if (n > currentStep && !klValidateStep(currentStep)) return;
    if (n < 1 || n > totalSteps) return;

    // hide old step
    document.getElementById('klStep' + currentStep).style.display = 'none';
    // update step bar (done)
    var oldItem   = document.getElementById('stepItem'   + currentStep);
    var oldCircle = document.getElementById('stepCircle' + currentStep);
    if (n > currentStep) {
        oldItem.classList.remove('active');
        oldItem.classList.add('done');
        oldCircle.textContent = '';
    } else {
        // going back: un-done current
        oldItem.classList.remove('active','done');
        oldCircle.textContent = currentStep;
    }

    currentStep = n;

    // show new step
    document.getElementById('klStep' + currentStep).style.display = '';
    // update step bar (active)
    var newItem   = document.getElementById('stepItem'   + currentStep);
    var newCircle = document.getElementById('stepCircle' + currentStep);
    newItem.classList.remove('done');
    newItem.classList.add('active');
    // restore number if not done
    if (!newItem.classList.contains('done')) newCircle.textContent = currentStep;

    // buttons
    document.getElementById('btnBack').style.display   = currentStep > 1 ? '' : 'none';
    document.getElementById('btnNext').style.display   = currentStep < totalSteps ? '' : 'none';
    document.getElementById('btnSubmit').style.display = currentStep === totalSteps ? '' : 'none';
    document.getElementById('btnCancel').style.display = currentStep === 1 ? '' : 'none';

    if (currentStep === totalSteps) klPopulateConfirm();

    window.scrollTo({top: 0, behavior: 'smooth'});
}

function klValidateStep(step) {
    if (step === 1) {
        var ok = true;
        var nama = document.getElementById('klNama').value.trim();
        var kat  = document.getElementById('klKategori').value;
        var desk = document.getElementById('klDeskripsi').value.trim();
        document.getElementById('errNama').style.display     = !nama ? '' : 'none';
        document.getElementById('errKategori').style.display = !kat  ? '' : 'none';
        document.getElementById('errDeskripsi').style.display= !desk ? '' : 'none';
        if (!nama || !kat || !desk) ok = false;
        return ok;
    }
    if (step === 2) {
        var ok = true;
        var al  = document.getElementById('klAlamat').value.trim();
        var jb  = document.getElementById('klJamBuka').value;
        var jt  = document.getElementById('klJamTutup').value;
        var wa  = document.getElementById('klWa').value.trim();
        document.getElementById('errAlamat').style.display = !al ? '' : 'none';
        document.getElementById('errJam').style.display    = (!jb || !jt) ? '' : 'none';
        document.getElementById('errWa').style.display     = !wa ? '' : 'none';
        if (!al || !jb || !jt || !wa) ok = false;
        return ok;
    }
    return true;
}

function klPopulateConfirm() {
    var nama    = document.getElementById('klNama').value.trim();
    var kat     = document.getElementById('klKategori').value;
    var status  = document.getElementById('klStatus').value;
    var desk    = document.getElementById('klDeskripsi').value.trim();
    var alamat  = document.getElementById('klAlamat').value.trim();
    var jb      = document.getElementById('klJamBuka').value;
    var jt      = document.getElementById('klJamTutup').value;
    var wa      = document.getElementById('klWa').value.trim();
    var maps    = document.getElementById('klMaps').value.trim();

    document.getElementById('confNama').textContent     = nama || '—';
    document.getElementById('confKategori').textContent = kat  || '—';
    document.getElementById('confAlamat').textContent   = alamat || '—';
    document.getElementById('confJam').textContent      = (jb && jt) ? jb + ' – ' + jt : '—';
    document.getElementById('confWa').textContent       = wa ? '+' + wa : '—';
    document.getElementById('confMaps').textContent     = maps || '(tidak diisi)';
    document.getElementById('confDeskripsi').textContent= desk || '—';

    var statusEl = document.getElementById('confStatus');
    statusEl.innerHTML = status === 'buka'
        ? '<span class="confirm-badge buka"><i class="fa fa-circle" style="font-size:8px"></i> Buka</span>'
        : '<span class="confirm-badge tutup"><i class="fa fa-circle" style="font-size:8px"></i> Tutup</span>';

    // photo
    if (photoDataUrl) {
        var img = document.getElementById('confImg');
        img.src = photoDataUrl;
        img.style.display = 'block';
        document.getElementById('confImgIcon').style.display = 'none';
    } else {
        document.getElementById('confImg').style.display = 'none';
        document.getElementById('confImgIcon').style.display = '';
    }
}

function handlePhoto(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            photoDataUrl = e.target.result;
            var img = document.getElementById('kfPreviewImg');
            img.src = e.target.result;
            img.style.display = 'block';
            document.getElementById('kfPlaceholder').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// init
document.getElementById('btnBack').style.display   = 'none';
document.getElementById('btnSubmit').style.display = 'none';
document.getElementById('btnCancel').style.display = '';

// Restore step if validation errors from server
@if($errors->any())
    // server-side errors: jump directly to step 2 if needed, otherwise step 1
    @if($errors->has('alamat') || $errors->has('jam_buka') || $errors->has('jam_tutup') || $errors->has('kontak_wa') || $errors->has('gambar'))
        klGoStep(2);
    @endif
@endif
</script>
@endsection
