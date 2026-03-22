@extends('layouts.app')

@section('title', 'Ubah Password - NusaMart')

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Beranda</a></li>
            <li><a href="{{ route('profile') }}">Akun Saya</a></li>
            <li class="active">Ubah Password</li>
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
                    </div>
                    <h3 class="profile-name">{{ auth()->user()->name }}</h3>
                    <span class="profile-role-badge">
                        <i class="fa {{ auth()->user()->role === 'admin' ? 'fa-shield' : (auth()->user()->role === 'penjual' ? 'fa-store' : 'fa-shopping-bag') }}"></i>
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                    <p class="profile-joined"><i class="fa fa-calendar"></i> Bergabung {{ auth()->user()->created_at->translatedFormat('d F Y') }}</p>
                </div>

                <nav class="profile-nav">
                    <a href="{{ route('profile') }}"><i class="fa fa-user"></i> Profil Saya</a>
                    <a href="{{ route('profile.password') }}" class="active"><i class="fa fa-lock"></i> Ubah Password</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="profile-main">
                <div class="profile-info-card">
                    <div class="card-header">
                        <h3><i class="fa fa-lock"></i> Ubah Password</h3>
                    </div>
                    <form method="POST" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="profile-form">
                            <div class="form-group">
                                <label for="current_password"><i class="fa fa-key"></i> Password Lama</label>
                                <input type="password" id="current_password" name="current_password" required>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="fa fa-lock"></i> Password Baru</label>
                                <input type="password" id="password" name="password" required>
                                <small class="form-hint">Minimal 8 karakter, kombinasi huruf besar & kecil, dan karakter spesial</small>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation"><i class="fa fa-check-circle"></i> Konfirmasi Password Baru</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn-save"><i class="fa fa-save"></i> Ubah Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
