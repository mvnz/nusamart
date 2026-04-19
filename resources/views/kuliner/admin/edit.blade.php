@extends('layouts.app')

@section('title', 'Edit Warung - NusaMart Admin')

@section('content')
<style>
.kl-form-wrap { max-width: 760px; margin: 0 auto; padding: 28px 16px 48px; }
.kl-page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 26px; flex-wrap: wrap; gap: 12px; }
.kl-page-title { font-size: 21px; font-weight: 800; color: #1e1f29; display: flex; align-items: center; gap: 10px; margin: 0; }
.kl-page-title i { color: #d97706; }
.kl-back-btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 16px; background: #f4f5f7; color: #555; border: none; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; text-decoration: none; transition: background .15s; font-family: inherit; }
.kl-back-btn:hover { background: #e5e7eb; color: #1e1f29; }

.kl-form-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,.07); padding: 28px; }
.kl-form-section { margin-bottom: 24px; }
.kl-form-section-title { font-size: 13px; font-weight: 800; color: #8d8d8d; text-transform: uppercase; letter-spacing: .6px; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid #f0f0f0; }
.kl-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
@media(max-width: 600px) { .kl-form-grid { grid-template-columns: 1fr; } }
.kl-form-group { display: flex; flex-direction: column; gap: 5px; }
.kl-form-group.full { grid-column: 1 / -1; }
.kl-label { font-size: 12px; font-weight: 700; color: #555; }
.kl-label .req { color: #D10024; }
.kl-input, .kl-select, .kl-textarea {
    padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 10px;
    font-size: 13px; font-family: inherit; outline: none; transition: border .2s; background: #f9fafb; color: #1e1f29;
}
.kl-input:focus, .kl-select:focus, .kl-textarea:focus { border-color: #D10024; background: #fff; }
.kl-textarea { resize: vertical; min-height: 100px; }
.kl-error { font-size: 11px; color: #D10024; margin-top: 2px; }
.kl-hint  { font-size: 11px; color: #aaa; margin-top: 2px; }

.kl-img-current { width: 100%; height: 160px; border-radius: 10px; overflow: hidden; margin-bottom: 8px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; }
.kl-img-current img { width: 100%; height: 100%; object-fit: cover; }
.kl-img-current i { font-size: 42px; color: #ddd; }
.kl-img-preview { width: 100%; height: 160px; border-radius: 10px; background: #f5f5f5; border: 2px dashed #e5e7eb; display: flex; align-items: center; justify-content: center; overflow: hidden; cursor: pointer; transition: border-color .2s; }
.kl-img-preview:hover { border-color: #d97706; }
.kl-img-preview img { width: 100%; height: 100%; object-fit: cover; }
.kl-img-preview .placeholder { text-align: center; color: #ccc; }
.kl-img-preview .placeholder i { font-size: 36px; display: block; margin-bottom: 6px; }
.kl-img-preview .placeholder span { font-size: 12px; }

.kl-submit-btn { width: 100%; padding: 13px; background: #D10024; color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer; font-family: inherit; transition: background .2s; margin-top: 8px; }
.kl-submit-btn:hover { background: #a8001e; }
</style>

<div class="kl-form-wrap">
    <div class="kl-page-header">
        <h1 class="kl-page-title"><i class="fa fa-pencil"></i> Edit Warung Kuliner</h1>
        <a href="{{ route('admin.kuliner.index') }}" class="kl-back-btn"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="kl-form-card">
        <form action="{{ route('admin.kuliner.update', $kuliner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Informasi Dasar --}}
            <div class="kl-form-section">
                <div class="kl-form-section-title">Informasi Dasar</div>
                <div class="kl-form-grid">
                    <div class="kl-form-group full">
                        <label class="kl-label">Nama Warung <span class="req">*</span></label>
                        <input type="text" name="nama" class="kl-input" value="{{ old('nama', $kuliner->nama) }}" placeholder="cth: Warung Nasi Ibu Sari">
                        @error('nama')<div class="kl-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="kl-form-group">
                        <label class="kl-label">Kategori <span class="req">*</span></label>
                        <select name="kategori" class="kl-select">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach(['Makanan Berat','Jajanan','Minuman','Seafood','Sarapan','Dessert','Lainnya'] as $kat)
                                <option value="{{ $kat }}" {{ old('kategori', $kuliner->kategori) === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                        @error('kategori')<div class="kl-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="kl-form-group">
                        <label class="kl-label">Status <span class="req">*</span></label>
                        <select name="status" class="kl-select">
                            <option value="buka"  {{ old('status', $kuliner->status) === 'buka'  ? 'selected' : '' }}>Buka</option>
                            <option value="tutup" {{ old('status', $kuliner->status) === 'tutup' ? 'selected' : '' }}>Tutup</option>
                        </select>
                        @error('status')<div class="kl-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="kl-form-group full">
                        <label class="kl-label">Deskripsi <span class="req">*</span></label>
                        <textarea name="deskripsi" class="kl-textarea">{{ old('deskripsi', $kuliner->deskripsi) }}</textarea>
                        @error('deskripsi')<div class="kl-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Foto --}}
            <div class="kl-form-section">
                <div class="kl-form-section-title">Foto Warung</div>
                @if($kuliner->gambar && file_exists(public_path('uploads/' . $kuliner->gambar)))
                    <div class="kl-img-current">
                        <img src="{{ asset('uploads/' . $kuliner->gambar) }}" alt="{{ $kuliner->nama }}" id="currentImg">
                    </div>
                    <div class="kl-hint" style="margin-bottom:8px">Foto saat ini. Upload foto baru untuk mengganti.</div>
                @else
                    <div class="kl-img-current"><i class="fa fa-cutlery"></i></div>
                @endif
                <div class="kl-img-preview" onclick="document.getElementById('gambarInput').click()">
                    <img id="imgPreview" src="" style="display:none">
                    <div class="placeholder" id="imgPlaceholder">
                        <i class="fa fa-camera"></i>
                        <span>Klik untuk ganti foto</span>
                    </div>
                </div>
                <input type="file" name="gambar" id="gambarInput" accept="image/jpg,image/jpeg,image/png" style="display:none" onchange="previewGambar(this)">
                <div class="kl-hint">Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengganti.</div>
                @error('gambar')<div class="kl-error">{{ $message }}</div>@enderror
            </div>

            {{-- Lokasi & Kontak --}}
            <div class="kl-form-section">
                <div class="kl-form-section-title">Lokasi & Kontak</div>
                <div class="kl-form-grid">
                    <div class="kl-form-group full">
                        <label class="kl-label">Alamat Lengkap <span class="req">*</span></label>
                        <input type="text" name="alamat" class="kl-input" value="{{ old('alamat', $kuliner->alamat) }}" placeholder="cth: Jl. Raya Manud Jaya No. 12, RT 02/RW 01">
                        @error('alamat')<div class="kl-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="kl-form-group">
                        <label class="kl-label">Jam Buka <span class="req">*</span></label>
                        <input type="time" name="jam_buka" class="kl-input" value="{{ old('jam_buka', $kuliner->jam_buka) }}">
                        @error('jam_buka')<div class="kl-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="kl-form-group">
                        <label class="kl-label">Jam Tutup <span class="req">*</span></label>
                        <input type="time" name="jam_tutup" class="kl-input" value="{{ old('jam_tutup', $kuliner->jam_tutup) }}">
                        @error('jam_tutup')<div class="kl-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="kl-form-group">
                        <label class="kl-label">Nomor WhatsApp <span class="req">*</span></label>
                        <input type="text" name="kontak_wa" class="kl-input" value="{{ old('kontak_wa', $kuliner->kontak_wa) }}" placeholder="cth: 6281234567890">
                        <div class="kl-hint">Format: 62xxx (tanpa + atau 0 di depan)</div>
                        @error('kontak_wa')<div class="kl-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="kl-form-group">
                        <label class="kl-label">Link Google Maps</label>
                        <input type="url" name="link_maps" class="kl-input" value="{{ old('link_maps', $kuliner->link_maps) }}" placeholder="https://maps.google.com/...">
                        @error('link_maps')<div class="kl-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="kl-submit-btn"><i class="fa fa-save"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

<script>
function previewGambar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imgPreview').src = e.target.result;
            document.getElementById('imgPreview').style.display = 'block';
            document.getElementById('imgPlaceholder').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
