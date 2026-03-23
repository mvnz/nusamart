@extends('layouts.app')

@section('title', 'Akun Saya - NusaMart')

@push('styles')
<style>
.profile-form{padding:24px 20px}
.profile-form>.form-group{margin-bottom:20px}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:30px;margin-bottom:20px}
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
                                <label for="alamat"><i class="fa fa-home"></i> Alamat</label>
                                <input type="text" id="alamat" name="alamat" value="{{ old('alamat', auth()->user()->alamat) }}" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="kota"><i class="fa fa-building-o"></i> Kota</label>
                                    <input type="text" id="kota" name="kota" value="{{ old('kota', auth()->user()->kota) }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="propinsi"><i class="fa fa-map-marker"></i> Propinsi</label>
                                    <input type="text" id="propinsi" name="propinsi" value="{{ old('propinsi', auth()->user()->propinsi) }}" required>
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
