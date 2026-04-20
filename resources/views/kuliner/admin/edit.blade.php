@extends('layouts.admin')

@section('title', 'Edit Warung - NusaMart Admin')

@section('content')
<style>
.kl-form-wrap { max-width: 820px; margin: 0 auto; padding: 4px 0 48px; }
.kl-page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 26px; flex-wrap: wrap; gap: 12px; }
.kl-page-title { font-size: 21px; font-weight: 800; color: #1e1f29; display: flex; align-items: center; gap: 10px; margin: 0; }
.kl-page-title i { color: #d97706; }
.kl-back-btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 16px; background: #f4f5f7; color: #555; border: none; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; text-decoration: none; transition: background .15s; font-family: inherit; }
.kl-back-btn:hover { background: #e5e7eb; color: #1e1f29; }

.kl-form-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,.07); overflow: hidden; }
.kl-form-header { padding: 22px 28px; border-bottom: 1px solid #f2f2f5; display: flex; align-items: center; gap: 14px; }
.kl-form-header-img { width: 52px; height: 52px; border-radius: 12px; object-fit: cover; background: linear-gradient(135deg, #ffe4b2, #fff7e6); display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0; }
.kl-form-header-img img { width: 100%; height: 100%; object-fit: cover; }
.kl-form-header-img i { font-size: 20px; color: #d97706; }
.kl-form-header h2 { font-size: 15px; font-weight: 800; color: #1e1f29; margin: 0; }
.kl-form-header p  { font-size: 12px; color: #9ca3af; margin: 2px 0 0; }
.kl-form-body { padding: 28px; }

.kl-form-section { margin-bottom: 28px; }
.kl-section-title { font-size: 11px; font-weight: 800; color: #9ca3af; text-transform: uppercase; letter-spacing: .8px; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; gap: 7px; }
.kl-section-title i { font-size: 12px; color: #d97706; }

.kl-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
@media(max-width: 600px) { .kl-form-grid { grid-template-columns: 1fr; } }
.kl-form-group { display: flex; flex-direction: column; gap: 5px; }
.kl-form-group.full { grid-column: 1 / -1; }
.kl-label { font-size: 12px; font-weight: 700; color: #555; }
.kl-label .req { color: #D10024; }
.kl-input, .kl-select, .kl-textarea {
    padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 10px;
    font-size: 13px; font-family: inherit; outline: none; transition: border .2s, box-shadow .2s; background: #f9fafb; color: #1e1f29;
}
.kl-input:focus, .kl-select:focus, .kl-textarea:focus {
    border-color: #d97706; background: #fff; box-shadow: 0 0 0 3px rgba(217,119,6,.1);
}
.kl-textarea { resize: vertical; min-height: 100px; }
.kl-error { font-size: 11px; color: #D10024; margin-top: 2px; display: flex; align-items: center; gap: 4px; }
.kl-hint  { font-size: 11px; color: #aaa; margin-top: 2px; }

/* Photo */
.kl-current-photo { width: 100%; height: 200px; border-radius: 12px; overflow: hidden; margin-bottom: 12px; position: relative; }
.kl-current-photo img { width: 100%; height: 100%; object-fit: cover; }
.kl-current-photo-label { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,.6)); color: #fff; font-size: 12px; font-weight: 600; padding: 20px 14px 10px; }
.kl-no-photo { width: 100%; height: 140px; border-radius: 12px; background: linear-gradient(135deg, #f5f5f8, #ece9e3); display: flex; align-items: center; justify-content: center; margin-bottom: 12px; }
.kl-no-photo i { font-size: 42px; color: #e0dbd2; }

.kl-upload-area { border: 2px dashed #e5e7eb; border-radius: 12px; overflow: hidden; background: #fafafa; transition: border-color .2s; cursor: pointer; }
.kl-upload-area:hover { border-color: #d97706; background: #fffbf0; }
.kl-upload-area.has-image { border-style: solid; border-color: #d97706; }
.kl-upload-placeholder { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 24px; gap: 6px; }
.kl-upload-placeholder i { font-size: 28px; color: #d1d5db; }
.kl-upload-placeholder span { font-size: 13px; color: #9ca3af; font-weight: 600; }
.kl-upload-placeholder small { font-size: 11px; color: #c0c0c0; }
.kl-new-preview { width: 100%; height: 200px; object-fit: cover; display: none; }

/* Time group */
.kl-time-group { display: flex; align-items: center; gap: 10px; }
.kl-time-sep { font-size: 13px; color: #9ca3af; font-weight: 700; flex-shrink: 0; }

/* Footer */
.kl-form-footer { padding: 20px 28px; border-top: 1px solid #f3f4f6; display: flex; align-items: center; justify-content: flex-end; gap: 12px; }
.kl-cancel-btn { padding: 11px 20px; background: #f4f5f7; color: #555; border: none; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit; transition: background .15s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
.kl-cancel-btn:hover { background: #e5e7eb; color: #1e1f29; }
.kl-submit-btn { padding: 11px 28px; background: linear-gradient(135deg, #D10024, #a8001e); color: #fff; border: none; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit; transition: all .2s; display: inline-flex; align-items: center; gap: 7px; box-shadow: 0 3px 10px rgba(209,0,36,.25); }
.kl-submit-btn:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(209,0,36,.35); }
</style>

<div class="kl-form-wrap">
    <div class="kl-page-header">
        <h1 class="kl-page-title"><i class="fa fa-pencil"></i> Edit Warung Kuliner</h1>
        <a href="{{ route('admin.kuliner.index') }}" class="kl-back-btn"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>

    @if($errors->any())
    <div style="background:#fee2e2; border:1px solid #fca5a5; border-radius:12px; padding:14px 18px; margin-bottom:20px; display:flex; align-items:flex-start; gap:10px; font-size:13px; color:#991b1b;">
        <i class="fa fa-exclamation-circle" style="margin-top:1px; flex-shrink:0;"></i>
        <div>
            <strong>Terdapat kesalahan:</strong>
            <ul style="margin:5px 0 0; padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <div class="kl-form-card">
        <div class="kl-form-header">
            <div class="kl-form-header-img">
                @if($kuliner->gambar && file_exists(public_path('uploads/' . $kuliner->gambar)))
                    <img src="{{ asset('uploads/' . $kuliner->gambar) }}" alt="{{ $kuliner->nama }}">
                @else
                    <i class="fa fa-cutlery"></i>
                @endif
            </div>
            <div>
                <h2>{{ $kuliner->nama }}</h2>
                <p>{{ $kuliner->kategori }} &mdash; Terakhir diperbarui {{ $kuliner->updated_at->diffForHumans() }}</p>
            </div>
        </div>

        <form action="{{ route('admin.kuliner.update', $kuliner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="kl-form-body">

                {{-- Informasi Dasar --}}
                <div class="kl-form-section">
                    <div class="kl-section-title"><i class="fa fa-info-circle"></i> Informasi Dasar</div>
                    <div class="kl-form-grid">
                        <div class="kl-form-group full">
                            <label class="kl-label">Nama Warung <span class="req">*</span></label>
                            <input type="text" name="nama" class="kl-input" value="{{ old('nama', $kuliner->nama) }}" placeholder="cth: Warung Nasi Ibu Sari">
                            @error('nama')<div class="kl-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                        </div>
                        <div class="kl-form-group">
                            <label class="kl-label">Kategori <span class="req">*</span></label>
                            <select name="kategori" class="kl-select">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach(['Makanan Berat','Jajanan','Minuman','Seafood','Sarapan','Dessert','Lainnya'] as $kat)
                                    <option value="{{ $kat }}" {{ old('kategori', $kuliner->kategori) === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                @endforeach
                            </select>
                            @error('kategori')<div class="kl-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                        </div>
                        <div class="kl-form-group">
                            <label class="kl-label">Status <span class="req">*</span></label>
                            <select name="status" class="kl-select">
                                <option value="buka"  {{ old('status', $kuliner->status) === 'buka'  ? 'selected' : '' }}>🟢 Buka</option>
                                <option value="tutup" {{ old('status', $kuliner->status) === 'tutup' ? 'selected' : '' }}>🔴 Tutup</option>
                            </select>
                            @error('status')<div class="kl-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                        </div>
                        <div class="kl-form-group full">
                            <label class="kl-label">Deskripsi <span class="req">*</span></label>
                            <textarea name="deskripsi" class="kl-textarea">{{ old('deskripsi', $kuliner->deskripsi) }}</textarea>
                            @error('deskripsi')<div class="kl-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Foto --}}
                <div class="kl-form-section">
                    <div class="kl-section-title"><i class="fa fa-camera"></i> Foto Warung</div>
                    @if($kuliner->gambar && file_exists(public_path('uploads/' . $kuliner->gambar)))
                        <div class="kl-current-photo">
                            <img src="{{ asset('uploads/' . $kuliner->gambar) }}" alt="{{ $kuliner->nama }}" id="currentImg">
                            <div class="kl-current-photo-label"><i class="fa fa-image"></i> Foto saat ini</div>
                        </div>
                    @else
                        <div class="kl-no-photo"><i class="fa fa-cutlery"></i></div>
                    @endif
                    <div class="kl-upload-area" id="uploadArea" onclick="document.getElementById('gambarInput').click()">
                        <img id="imgPreview" class="kl-new-preview" src="" alt="Preview baru">
                        <div class="kl-upload-placeholder" id="imgPlaceholder">
                            <i class="fa fa-cloud-upload"></i>
                            <span>Klik untuk ganti foto</span>
                            <small>Format JPG, JPEG, PNG — Maks. 2MB. Kosongkan jika tidak ingin mengganti.</small>
                        </div>
                    </div>
                    <input type="file" name="gambar" id="gambarInput" accept="image/jpg,image/jpeg,image/png" style="display:none" onchange="previewGambar(this)">
                    @error('gambar')<div class="kl-error" style="margin-top:6px"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                </div>

                {{-- Lokasi & Kontak --}}
                <div class="kl-form-section">
                    <div class="kl-section-title"><i class="fa fa-map-marker"></i> Lokasi & Kontak</div>
                    <div class="kl-form-grid">
                        <div class="kl-form-group full">
                            <label class="kl-label">Alamat Lengkap <span class="req">*</span></label>
                            <input type="text" name="alamat" class="kl-input" value="{{ old('alamat', $kuliner->alamat) }}" placeholder="cth: Jl. Raya Manud Jaya No. 12, RT 02/RW 01">
                            @error('alamat')<div class="kl-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                        </div>
                        <div class="kl-form-group">
                            <label class="kl-label">Jam Operasional <span class="req">*</span></label>
                            <div class="kl-time-group">
                                <input type="time" name="jam_buka" class="kl-input" value="{{ old('jam_buka', $kuliner->jam_buka) }}" style="flex:1">
                                <span class="kl-time-sep">–</span>
                                <input type="time" name="jam_tutup" class="kl-input" value="{{ old('jam_tutup', $kuliner->jam_tutup) }}" style="flex:1">
                            </div>
                            @error('jam_buka')<div class="kl-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                            @error('jam_tutup')<div class="kl-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                        </div>
                        <div class="kl-form-group">
                            <label class="kl-label">Nomor WhatsApp <span class="req">*</span></label>
                            <input type="text" name="kontak_wa" class="kl-input" value="{{ old('kontak_wa', $kuliner->kontak_wa) }}" placeholder="cth: 6281234567890">
                            <div class="kl-hint">Format: 62xxx (tanpa + atau 0 di depan)</div>
                            @error('kontak_wa')<div class="kl-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                        </div>
                        <div class="kl-form-group full">
                            <label class="kl-label">Link Google Maps</label>
                            <input type="url" name="link_maps" class="kl-input" value="{{ old('link_maps', $kuliner->link_maps) }}" placeholder="https://maps.google.com/...">
                            <div class="kl-hint">Opsional — salin link dari Google Maps</div>
                            @error('link_maps')<div class="kl-error"><i class="fa fa-times-circle"></i>{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

            </div>
            <div class="kl-form-footer">
                <a href="{{ route('admin.kuliner.index') }}" class="kl-cancel-btn"><i class="fa fa-times"></i> Batal</a>
                <button type="submit" class="kl-submit-btn"><i class="fa fa-save"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
function previewGambar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.getElementById('imgPreview');
            img.src = e.target.result;
            img.style.display = 'block';
            document.getElementById('imgPlaceholder').style.display = 'none';
            document.getElementById('uploadArea').classList.add('has-image');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
