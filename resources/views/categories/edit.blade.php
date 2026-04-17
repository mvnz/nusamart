@extends('layouts.app')

@section('title', 'Edit Kategori - NusaMart')

@push('styles')
<style>
    .form-header {
        background: linear-gradient(135deg, #15161d 0%, #1a1b2e 100%);
        padding: 40px 0;
        margin-bottom: 40px;
        border-bottom: 2px solid rgba(209, 0, 36, 0.3);
    }

    .form-header h1 {
        color: #fff;
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .form-header p {
        color: #b9babc;
        font-size: 14px;
        margin: 0;
    }

    .form-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 0 15px 80px;
    }

    .form-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-size: 14px;
        font-weight: 600;
    }

    .form-group input {
        width: 100%;
        padding: 12px 14px;
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        font-size: 14px;
        font-family: 'Montserrat', sans-serif;
        transition: border-color 0.2s;
    }

    .form-group input:focus {
        outline: none;
        border-color: #D10024;
        box-shadow: 0 0 0 3px rgba(209, 0, 36, 0.1);
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
    }

    .btn-submit {
        flex: 1;
        background: linear-gradient(135deg, #D10024, #ff4d6d);
        color: #fff;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 16px rgba(209, 0, 36, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(209, 0, 36, 0.4);
    }

    .btn-cancel {
        flex: 1;
        background: #f5f5f5;
        color: #333;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        transition: all 0.2s;
    }

    .btn-cancel:hover {
        background: #eee;
        color: #333;
    }

    .error-messages {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 24px;
        color: #721c24;
    }

    .error-messages ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .error-messages li {
        margin-bottom: 6px;
    }

    .error-messages li:last-child {
        margin-bottom: 0;
    }

    .form-help {
        color: #888;
        font-size: 12px;
        margin-top: 6px;
    }
</style>
@endpush

<section class="form-header">
    <div class="form-container">
        <h1>✏️ Edit Kategori</h1>
        <p>Perbarui informasi kategori produk</p>
    </div>
</section>

<main class="form-container">
    <div class="form-card">
        @if ($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Kategori <span style="color: #D10024;">*</span></label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    class="@error('name') is-invalid @enderror"
                    placeholder="Masukkan nama kategori"
                    value="{{ old('name', $category->name) }}"
                    required
                >
                <div class="form-help">Perbarui nama kategori sesuai kebutuhan</div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fa fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('categories.index') }}" class="btn-cancel">
                    <i class="fa fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</main>
@endsection
