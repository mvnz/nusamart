@extends('layouts.admin')

@section('title', 'Edit Warung - NusaMart Admin')

@section('content')
<style>
/* ===== WRAPPER ===== */
.kf-wrap { max-width: 1100px; margin: 0 auto; padding: 4px 0 52px; }
.kf-page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
.kf-page-title { font-size: 21px; font-weight: 800; color: #1e1f29; display: flex; align-items: center; gap: 10px; margin: 0; }
.kf-page-title i { color: #d97706; }
.kf-back-btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 16px; background: #f4f5f7; color: #555; border: none; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; text-decoration: none; transition: background .15s; font-family: inherit; }
.kf-back-btn:hover { background: #e5e7eb; color: #1e1f29; }

/* ===== LAYOUT ===== */
.kf-layout { display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: start; }
@media(max-width: 900px) { .kf-layout { grid-template-columns: 1fr; } }

/* ===== FORM CARD ===== */
.kf-card { background: #fff; border-radius: 18px; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 8px 24px rgba(0,0,0,.05); overflow: hidden; }
.kf-card-header {
    padding: 20px 28px; display: flex; align-items: center; gap: 14px;
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    border-bottom: 1px solid #fde68a;
}
.kf-card-header-thumb { width: 46px; height: 46px; border-radius: 12px; overflow: hidden; flex-shrink: 0; box-shadow: 0 3px 10px rgba(0,0,0,.15); background: linear-gradient(135deg, #fef3c7, #fde68a); display: flex; align-items: center; justify-content: center; }
.kf-card-header-thumb img { width: 100%; height: 100%; object-fit: cover; }
.kf-card-header-thumb i { font-size: 20px; color: #d97706; }
.kf-card-header h2 { font-size: 15px; font-weight: 800; color: #78350f; margin: 0; }
.kf-card-header p  { font-size: 12px; color: #92400e; margin: 2px 0 0; opacity: .8; }
.kf-card-body { padding: 28px; }

/* ===== SECTIONS ===== */
.kf-section { margin-bottom: 28px; }
.kf-section-title { font-size: 11px; font-weight: 800; color: #b45309; text-transform: uppercase; letter-spacing: .8px; margin-bottom: 16px; padding: 8px 14px; background: #fffbeb; border-radius: 8px; border-left: 3px solid #d97706; display: flex; align-items: center; gap: 7px; }
.kf-section-title i { font-size: 12px; }

/* ===== FORM ELEMENTS ===== */
.kf-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
@media(max-width: 600px) { .kf-grid { grid-template-columns: 1fr; } }
.kf-group { display: flex; flex-direction: column; gap: 5px; }
.kf-group.full { grid-column: 1 / -1; }
.kf-label { font-size: 12px; font-weight: 700; color: #374151; display: flex; align-items: center; gap: 4px; }
.kf-label .req { color: #e11d48; }
.kf-input, .kf-select, .kf-textarea { padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 13px; font-family: inherit; outline: none; transition: border .2s, box-shadow .2s; background: #f9fafb; color: #1e1f29; }
.kf-input:focus, .kf-select:focus, .kf-textarea:focus { border-color: #d97706; background: #fff; box-shadow: 0 0 0 3px rgba(217,119,6,.12); }
.kf-textarea { resize: vertical; min-height: 100px; line-height: 1.6; }
.kf-error { font-size: 11px; color: #e11d48; margin-top: 3px; display: flex; align-items: center; gap: 4px; }
.kf-hint  { font-size: 11px; color: #9ca3af; margin-top: 3px; }

/* ===== PHOTO ===== */
.kf-current-photo { border-radius: 14px; overflow: hidden; margin-bottom: 14px; position: relative; }
.kf-current-photo img { width: 100%; height: 200px; object-fit: cover; display: block; }
.kf-current-label { position: absolute; bottom: 0; inset-inline: 0; padding: 10px 14px; background: linear-gradient(to top, rgba(0,0,0,.7), transparent); color: #fff; font-size: 11px; font-weight: 700; display: flex; align-items: center; gap: 6px; }
.kf-no-photo { height: 120px; background: linear-gradient(135deg, #fef3c7, #fde68a); border-radius: 14px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; margin-bottom: 14px; }
.kf-no-photo i { font-size: 36px; color: rgba(217,119,6,.4); }
.kf-no-photo span { font-size: 12px; color: #9ca3af; }

.kf-upload { border: 2px dashed #e5e7eb; border-radius: 14px; overflow: hidden; background: #f9fafb; transition: all .2s; cursor: pointer; }
.kf-upload:hover { border-color: #d97706; background: #fffbf0; }
.kf-upload.filled { border-style: solid; border-color: #d97706; }
.kf-upload-placeholder { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 24px; gap: 8px; }
.kf-upload-icon { width: 46px; height: 46px; border-radius: 12px; background: linear-gradient(135deg, #fef3c7, #fde68a); display: flex; align-items: center; justify-content: center; }
.kf-upload-icon i { font-size: 18px; color: #d97706; }
.kf-upload-placeholder strong { font-size: 13px; color: #374151; font-weight: 700; }
.kf-upload-placeholder span { font-size: 11.5px; color: #9ca3af; }
.kf-preview-img { width: 100%; height: 200px; object-fit: cover; display: none; }

/* ===== TIME ===== */
.kf-time-row { display: flex; align-items: center; gap: 10px; }
.kf-time-sep { font-size: 18px; color: #d97706; font-weight: 800; }

/* ===== FOOTER ===== */
.kf-footer { padding: 20px 28px; border-top: 1.5px solid #fef3c7; background: #fffbeb; display: flex; align-items: center; justify-content: flex-end; gap: 12px; }
.kf-cancel { padding: 11px 20px; background: #fff; color: #555; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit; transition: all .15s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
.kf-cancel:hover { background: #f4f5f7; color: #1e1f29; border-color: #d1d5db; }
.kf-submit { padding: 11px 28px; background: linear-gradient(135deg, #d97706, #b45309); color: #fff; border: none; border-radius: 10px; font-size: 13px; font-weight: 800; cursor: pointer; font-family: inherit; transition: all .2s; display: inline-flex; align-items: center; gap: 7px; box-shadow: 0 4px 12px rgba(180,83,9,.35); }
.kf-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(180,83,9,.45); }

/* ===== SIDEBAR ===== */
.kf-sidebar { display: flex; flex-direction: column; gap: 18px; }
.kf-preview-card { background: #fff; border-radius: 18px; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 8px 24px rgba(0,0,0,.05); overflow: hidden; }
.kf-preview-card-header { padding: 14px 18px; background: linear-gradient(135deg, #1e1f29, #374151); display: flex; align-items: center; gap: 8px; }
.kf-preview-card-header i { color: #d97706; }
.kf-preview-card-header span { font-size: 12px; font-weight: 700; color: #fff; }
.kf-preview-photo { width: 100%; height: 180px; background: linear-gradient(135deg, #fef3c7, #fde68a); display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative; }
.kf-preview-photo img { width: 100%; height: 100%; object-fit: cover; }
.kf-preview-photo i.ph-icon { font-size: 48px; color: rgba(217,119,6,.3); }
.kf-preview-body { padding: 16px 18px; }
.kf-preview-kat { display: inline-flex; align-items: center; gap: 5px; font-size: 10.5px; font-weight: 700; padding: 3px 10px; border-radius: 6px; margin-bottom: 8px; background: #fef3c7; color: #92400e; }
.kf-preview-name { font-size: 15px; font-weight: 800; color: #1e1f29; margin: 0 0 8px; }
.kf-preview-meta { font-size: 11.5px; color: #9ca3af; display: flex; flex-direction: column; gap: 5px; }
.kf-preview-meta span { display: flex; align-items: center; gap: 6px; }
.kf-preview-meta i { color: #d97706; width: 13px; }

.kf-info-card { background: linear-gradient(135deg, #f0fdf4, #dcfce7); border-radius: 14px; border: 1px solid #bbf7d0; padding: 18px; }
.kf-info-title { font-size: 12px; font-weight: 800; color: #14532d; margin-bottom: 12px; display: flex; align-items: center; gap: 6px; }
.kf-info-title i { color: #22c55e; }
.kf-info-row { display: flex; align-items: center; gap: 8px; padding: 7px 0; border-bottom: 1px solid rgba(187,247,208,.6); font-size: 12px; color: #166534; }
.kf-info-row:last-child { border-bottom: none; }
.kf-info-row i { color: #22c55e; width: 14px; flex-shrink: 0; }
.kf-info-row strong { color: #14532d; }

.kf-danger-card { background: #fff1f2; border-radius: 14px; border: 1px solid #fecdd3; padding: 18px; }
.kf-danger-title { font-size: 12px; font-weight: 800; color: #9f1239; margin-bottom: 12px; display: flex; align-items: center; gap: 6px; }
.kf-danger-title i { color: #e11d48; }
.kf-delete-btn { width: 100%; padding: 10px 16px; background: linear-gradient(135deg, #f43f5e, #e11d48); color: #fff; border: none; border-radius: 9px; font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit; transition: all .2s; display: flex; align-items: center; justify-content: center; gap: 7px; box-shadow: 0 3px 10px rgba(225,29,72,.3); }
.kf-delete-btn:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(225,29,72,.4); }
</style>

<div class="kf-wrap">
    <div class="kf-page-header">
        <h1 class="kf-page-title"><i class="fa fa-pencil-square-o"></i> Edit Warung Kuliner</h1>
        <a href="{{ route('admin.kuliner.index') }}" class="kf-back-btn"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>

    @if($errors->any())
    <div style="background:#fff1f2; border:1.5px solid #fecdd3; border-radius:12px; padding:14px 18px; margin-bottom:20px; display:flex; align-items:flex-start; gap:10px; font-size:13px; color:#9f1239;">
        <i class="fa fa-exclamation-circle" style="margin-top:1px; flex-shrink:0; color:#e11d48"></i>
        <div><strong>Terdapat {{ $errors->count() }} kesalahan:</strong>
            <ul style="margin:6px 0 0; padding-left:18px; line-height:1.8">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.kuliner.update', $kuliner->id) }}" method="POST" enctype="multipart/form-data" id="klForm">
    @csrf @method('PUT')
    <div class="kf-layout">
        {{-- Main form --}}
        <div class="kf-card">
            <div class="kf-card-header">
                <div class="kf-card-header-thumb">
                    @if($kuliner->gambar && file_exists(public_path('uploads/'.$kuliner->gambar)))
                        <img src="{{ asset('uploads/'.$kuliner->gambar) }}" alt="{{ $kuliner->nama }}">
                    @else
                        <i class="fa fa-cutlery"></i>
                    @endif
                </div>
                <div>
                    <h2>{{ $kuliner->nama }}</h2>
                    <p>Diperbarui {{ $kuliner->updated_at->diffForHumans() }}</p>
                </div>
            </div>
            <div class="kf-card-body">

                {{-- Informasi Dasar --}}
                <div class="kf-section">
                    <div class="kf-section-title"><i class="fa fa-info-circle"></i> Informasi Dasar</div>
                    <div class="kf-grid">
                        <div class="kf-group full">
                            <label class="kf-label">Nama Warung <span class="req">*</span></label>
                            <input type="text" name="nama" id="prevNama" class="kf-input"
                                   value="{{ old('nama', $kuliner->nama) }}" oninput="updatePreview()">
                            @error('nama')<div class="kf-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                        </div>
                        <div class="kf-group">
                            <label class="kf-label">Kategori <span class="req">*</span></label>
                            <select name="kategori" id="prevKat" class="kf-select" onchange="updatePreview()">
                                @foreach(['Makanan Berat','Jajanan','Minuman','Seafood','Sarapan','Dessert','Lainnya'] as $kat)
                                    <option value="{{ $kat }}" {{ old('kategori', $kuliner->kategori) === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                @endforeach
                            </select>
                            @error('kategori')<div class="kf-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                        </div>
                        <div class="kf-group">
                            <label class="kf-label">Status <span class="req">*</span></label>
                            <select name="status" class="kf-select">
                                <option value="buka"  {{ old('status', $kuliner->status) === 'buka'  ? 'selected' : '' }}>🟢 Buka</option>
                                <option value="tutup" {{ old('status', $kuliner->status) === 'tutup' ? 'selected' : '' }}>🔴 Tutup</option>
                            </select>
                            @error('status')<div class="kf-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                        </div>
                        <div class="kf-group full">
                            <label class="kf-label">Deskripsi <span class="req">*</span></label>
                            <textarea name="deskripsi" class="kf-textarea">{{ old('deskripsi', $kuliner->deskripsi) }}</textarea>
                            @error('deskripsi')<div class="kf-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Foto --}}
                <div class="kf-section">
                    <div class="kf-section-title"><i class="fa fa-camera"></i> Foto Warung</div>
                    @if($kuliner->gambar && file_exists(public_path('uploads/'.$kuliner->gambar)))
                        <div class="kf-current-photo" id="kfCurrentPhoto">
                            <img src="{{ asset('uploads/'.$kuliner->gambar) }}" alt="{{ $kuliner->nama }}" id="currentPhotoEl">
                            <div class="kf-current-label"><i class="fa fa-image"></i> Foto saat ini</div>
                        </div>
                    @else
                        <div class="kf-no-photo" id="kfCurrentPhoto">
                            <i class="fa fa-image"></i>
                            <span>Belum ada foto</span>
                        </div>
                    @endif
                    <div class="kf-upload" id="kfUpload" onclick="document.getElementById('gambarInput').click()">
                        <img id="kfPreviewImg" class="kf-preview-img" src="" alt="">
                        <div class="kf-upload-placeholder" id="kfUploadPlaceholder">
                            <div class="kf-upload-icon"><i class="fa fa-cloud-upload"></i></div>
                            <strong>Ganti foto (opsional)</strong>
                            <span>Format JPG, JPEG, PNG — Maks. 2MB</span>
                        </div>
                    </div>
                    <input type="file" name="gambar" id="gambarInput" accept="image/jpg,image/jpeg,image/png" style="display:none" onchange="handlePhoto(this)">
                    @error('gambar')<div class="kf-error" style="margin-top:8px"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                </div>

                {{-- Lokasi & Kontak --}}
                <div class="kf-section">
                    <div class="kf-section-title"><i class="fa fa-map-marker"></i> Lokasi &amp; Kontak</div>
                    <div class="kf-grid">
                        <div class="kf-group full">
                            <label class="kf-label">Alamat Lengkap <span class="req">*</span></label>
                            <input type="text" name="alamat" id="prevAlamat" class="kf-input"
                                   value="{{ old('alamat', $kuliner->alamat) }}" oninput="updatePreview()">
                            @error('alamat')<div class="kf-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                        </div>
                        <div class="kf-group">
                            <label class="kf-label">Jam Operasional <span class="req">*</span></label>
                            <div class="kf-time-row">
                                <input type="time" name="jam_buka" id="prevJamBuka" class="kf-input" value="{{ old('jam_buka', $kuliner->jam_buka) }}" style="flex:1" oninput="updatePreview()">
                                <span class="kf-time-sep">–</span>
                                <input type="time" name="jam_tutup" id="prevJamTutup" class="kf-input" value="{{ old('jam_tutup', $kuliner->jam_tutup) }}" style="flex:1" oninput="updatePreview()">
                            </div>
                            @error('jam_buka')<div class="kf-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                            @error('jam_tutup')<div class="kf-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                        </div>
                        <div class="kf-group">
                            <label class="kf-label">Nomor WhatsApp <span class="req">*</span></label>
                            <input type="text" name="kontak_wa" id="prevWa" class="kf-input"
                                   value="{{ old('kontak_wa', $kuliner->kontak_wa) }}" oninput="updatePreview()">
                            <div class="kf-hint">Format: 62xxx (tanpa + atau 0 di depan)</div>
                            @error('kontak_wa')<div class="kf-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                        </div>
                        <div class="kf-group full">
                            <label class="kf-label">Link Google Maps</label>
                            <input type="url" name="link_maps" class="kf-input" value="{{ old('link_maps', $kuliner->link_maps) }}" placeholder="https://maps.google.com/...">
                            <div class="kf-hint">Opsional — salin link dari Google Maps</div>
                            @error('link_maps')<div class="kf-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

            </div>
            <div class="kf-footer">
                <a href="{{ route('admin.kuliner.index') }}" class="kf-cancel"><i class="fa fa-times"></i> Batal</a>
                <button type="submit" class="kf-submit"><i class="fa fa-save"></i> Simpan Perubahan</button>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="kf-sidebar">
            {{-- Live Preview --}}
            <div class="kf-preview-card">
                <div class="kf-preview-card-header">
                    <i class="fa fa-eye"></i>
                    <span>Pratinjau Tampilan</span>
                </div>
                <div class="kf-preview-photo" id="prevPhotoBox">
                    @if($kuliner->gambar && file_exists(public_path('uploads/'.$kuliner->gambar)))
                        <img id="prevPhotoImg" src="{{ asset('uploads/'.$kuliner->gambar) }}" alt="">
                    @else
                        <img id="prevPhotoImg" src="" alt="" style="display:none">
                        <i class="fa fa-cutlery ph-icon" id="prevPhotoIcon"></i>
                    @endif
                </div>
                <div class="kf-preview-body">
                    <div class="kf-preview-kat" id="prevKatBadge"><i class="fa fa-tag"></i> <span id="prevKatText">{{ $kuliner->kategori }}</span></div>
                    <div class="kf-preview-name" id="prevNameText">{{ $kuliner->nama }}</div>
                    <div class="kf-preview-meta">
                        <span><i class="fa fa-map-marker"></i> <span id="prevAlamatText">{{ Str::limit($kuliner->alamat, 42) }}</span></span>
                        <span><i class="fa fa-clock-o"></i> <span id="prevJamText">{{ $kuliner->jam_buka }} – {{ $kuliner->jam_tutup }}</span></span>
                        <span><i class="fa fa-whatsapp"></i> <span id="prevWaText">+{{ $kuliner->kontak_wa }}</span></span>
                    </div>
                </div>
            </div>

            {{-- Info warung --}}
            <div class="kf-info-card">
                <div class="kf-info-title"><i class="fa fa-info-circle"></i> Info Warung</div>
                <div class="kf-info-row"><i class="fa fa-calendar"></i> Dibuat: <strong>{{ $kuliner->created_at->format('d M Y') }}</strong></div>
                <div class="kf-info-row"><i class="fa fa-edit"></i> Diperbarui: <strong>{{ $kuliner->updated_at->diffForHumans() }}</strong></div>
                <div class="kf-info-row"><i class="fa fa-hashtag"></i> ID Warung: <strong>#{{ $kuliner->id }}</strong></div>
                <div class="kf-info-row">
                    <i class="fa fa-circle" style="color: {{ $kuliner->status === 'buka' ? '#22c55e' : '#ef4444' }}; font-size:8px"></i>
                    Status: <strong>{{ ucfirst($kuliner->status) }}</strong>
                </div>
            </div>

            {{-- Hapus --}}
            <div class="kf-danger-card">
                <div class="kf-danger-title"><i class="fa fa-exclamation-triangle"></i> Zona Berbahaya</div>
                <form action="{{ route('admin.kuliner.destroy', $kuliner->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus warung {{ addslashes($kuliner->nama) }}? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="kf-delete-btn">
                        <i class="fa fa-trash"></i> Hapus Warung Ini
                    </button>
                </form>
            </div>
        </div>
    </div>
    </form>
</div>

<script>
@if($kuliner->gambar && file_exists(public_path('uploads/'.$kuliner->gambar)))
var hasCurrentPhoto = true;
@else
var hasCurrentPhoto = false;
@endif

function handlePhoto(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('kfPreviewImg').src = e.target.result;
            document.getElementById('kfPreviewImg').style.display = 'block';
            document.getElementById('kfUploadPlaceholder').style.display = 'none';
            document.getElementById('kfUpload').classList.add('filled');
            // Sidebar preview
            var img = document.getElementById('prevPhotoImg');
            img.src = e.target.result;
            img.style.display = 'block';
            var icon = document.getElementById('prevPhotoIcon');
            if (icon) icon.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function updatePreview() {
    var nama = document.getElementById('prevNama').value;
    var kat  = document.getElementById('prevKat').value;
    var al   = document.getElementById('prevAlamat').value;
    var jb   = document.getElementById('prevJamBuka').value;
    var jt   = document.getElementById('prevJamTutup').value;
    var wa   = document.getElementById('prevWa').value;

    var nameEl = document.getElementById('prevNameText');
    nameEl.textContent = nama || '—';
    nameEl.style.color = nama ? '#1e1f29' : '#9ca3af';

    document.getElementById('prevKatText').textContent = kat || 'Kategori';

    var alEl = document.getElementById('prevAlamatText');
    alEl.textContent = al ? (al.length > 42 ? al.substring(0,42)+'...' : al) : '—';
    alEl.style.color = al ? '#6b7280' : '#d1d5db';

    var jamEl = document.getElementById('prevJamText');
    jamEl.textContent = (jb && jt) ? jb + ' – ' + jt : '—';
    jamEl.style.color = (jb && jt) ? '#6b7280' : '#d1d5db';

    var waEl = document.getElementById('prevWaText');
    waEl.textContent = wa ? '+' + wa : '—';
    waEl.style.color = wa ? '#6b7280' : '#d1d5db';
}
</script>
@endsection
