@extends('layouts.app')

@section('title', 'Daftar Alamat - NusaMart')

@push('styles')
<style>
/* -- Searchable Select ---------------------------------------- */
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
/* -- Address page (pa-*) -------------------------------------- */
.pa-header{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:18px 24px;border-bottom:1px solid #f0f2f5;}
.pa-title{font-size:16px;font-weight:800;color:#1a1f2e;display:flex;align-items:center;gap:9px;margin:0;}
.pa-title i{color:#D10024;}
.pa-add-btn{display:inline-flex;align-items:center;gap:7px;background:#D10024;color:#fff;border:none;border-radius:10px;padding:10px 18px;font-size:13px;font-weight:700;cursor:pointer;font-family:inherit;transition:background .18s,transform .1s;white-space:nowrap;}
.pa-add-btn:hover{background:#b5001f;}.pa-add-btn:active{transform:scale(.97);}
/* -- Alerts ---------------------------------------------------- */
.pa-alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px;}
.pa-alert.success{background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;}
.pa-alert.error  {background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;}
.pa-alert i{margin-top:1px;flex-shrink:0;}
.pa-alert ul{margin:4px 0 0;padding-left:18px;}
/* -- Address list ---------------------------------------------- */
.pa-list{display:flex;flex-direction:column;gap:14px;margin-bottom:24px;}
.pa-card{border:1.5px solid #e9eaf0;border-radius:14px;padding:18px 20px;position:relative;background:#fff;transition:border-color .2s,box-shadow .2s;}
.pa-card:hover{border-color:#d0d1dc;box-shadow:0 4px 16px rgba(0,0,0,.06);}
.pa-card.pa-primary{border-color:#D10024;background:linear-gradient(135deg,#fff8f8 0%,#fff 60%);}
.pa-card-head{display:flex;align-items:center;gap:8px;margin-bottom:10px;}
.pa-label{font-size:13px;font-weight:800;color:#1a1f2e;}
.pa-primary-badge{display:inline-flex;align-items:center;gap:4px;background:#D10024;color:#fff;font-size:11px;font-weight:700;padding:2px 10px;border-radius:20px;}
.pa-primary-badge i{font-size:9px;}
.pa-recipient{font-size:14px;font-weight:700;color:#1a1f2e;margin-bottom:3px;}
.pa-phone{font-size:13px;color:#6b7280;margin-bottom:6px;display:flex;align-items:center;gap:5px;}
.pa-phone i{color:#D10024;font-size:11px;}
.pa-address{font-size:13px;color:#4b5563;line-height:1.6;}
.pa-foot{display:flex;align-items:center;gap:0;margin-top:14px;padding-top:12px;border-top:1px solid #f3f4f6;flex-wrap:wrap;}
.pa-btn{background:none;border:none;padding:5px 12px;font-size:12px;font-weight:700;cursor:pointer;font-family:inherit;border-radius:7px;transition:background .15s;display:inline-flex;align-items:center;gap:5px;}
.pa-btn.edit   {color:#1565c0;background:#e3f2fd;}
.pa-btn.edit:hover{background:#bbdefb;}
.pa-btn.primary{color:#065f46;background:#d1fae5;}
.pa-btn.primary:hover{background:#a7f3d0;}
.pa-btn.del    {color:#dc2626;background:#fee2e2;}
.pa-btn.del:hover{background:#fecaca;}
.pa-btn-sep{width:1px;height:18px;background:#e5e7eb;margin:0 5px;flex-shrink:0;align-self:center;}
.pa-check{margin-left:auto;color:#D10024;font-size:18px;display:flex;align-items:center;gap:5px;font-size:12px;font-weight:700;}
.pa-check i{font-size:16px;}
/* -- Empty state ----------------------------------------------- */
.pa-empty{text-align:center;padding:52px 24px;}
.pa-empty-icon{width:70px;height:70px;border-radius:50%;background:linear-gradient(135deg,#ffd6d6,#ffefef);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;}
.pa-empty-icon i{font-size:28px;color:#D10024;}
.pa-empty h4{font-size:15px;font-weight:700;color:#374151;margin:0 0 6px;}
.pa-empty p{font-size:13px;color:#9ca3af;margin:0;}
/* -- Form section ---------------------------------------------- */
.pa-form-wrap{border-radius:14px;border:2px solid #D10024;background:#fff;overflow:hidden;margin-top:4px;}
.pa-form-head{display:flex;align-items:center;justify-content:space-between;padding:15px 22px;background:linear-gradient(135deg,#1a1f2e 0%,#2d3347 100%);}
.pa-form-head-title{font-size:14px;font-weight:800;color:#fff;display:flex;align-items:center;gap:9px;}
.pa-form-head-title i{color:rgba(255,255,255,.55);font-size:13px;}
.pa-form-close{background:rgba(255,255,255,.12);border:none;width:30px;height:30px;border-radius:8px;color:#fff;font-size:18px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .15s;line-height:1;}
.pa-form-close:hover{background:rgba(255,255,255,.25);}
.pa-form-body{padding:22px;}
.pa-section-lbl{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#9ca3af;margin-bottom:14px;display:flex;align-items:center;gap:6px;}
.pa-section-lbl i{color:#D10024;font-size:12px;}
.pa-section-div{margin-top:8px;padding-top:18px;border-top:1px dashed #e9eaf0;margin-bottom:0;}
.pa-form-actions{display:flex;gap:10px;margin-top:22px;}
.pa-save-btn{display:inline-flex;align-items:center;gap:7px;background:#D10024;color:#fff;border:none;border-radius:10px;padding:11px 22px;font-size:13px;font-weight:700;cursor:pointer;font-family:inherit;transition:background .18s;}
.pa-save-btn:hover{background:#b5001f;}
.pa-cancel-btn{display:inline-flex;align-items:center;gap:7px;background:#f4f5f7;color:#555;border:none;border-radius:10px;padding:11px 18px;font-size:13px;font-weight:700;cursor:pointer;font-family:inherit;transition:background .15s;}
.pa-cancel-btn:hover{background:#e5e7eb;}
.profile-form>.form-group{margin-bottom:18px}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:18px}
</style>
@endpush

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li><a href="{{ route('profile.biodata') }}">Akun Saya</a></li>
            <li class="active">Daftar Alamat</li>
        </ul>
    </div>
</div>

<section class="profile-page-section">
    <div class="container">
        <div class="profile-page-grid">
            <!-- Sidebar -->
            <div class="profile-sidebar">
                <div class="profile-avatar-card">
                    <div class="profile-avatar-wrapper">
                        @if(auth()->user()->photo)
                            <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto Profil" class="profile-avatar-img">
                        @else
                            <div class="profile-avatar"><i class="fa fa-user"></i></div>
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
                    <a href="{{ route('profile.biodata') }}" class="{{ request()->routeIs('profile.biodata') ? 'active' : '' }}"><i class="fa fa-user"></i> Biodata</a>
                    <a href="{{ route('profile.alamat') }}" class="{{ request()->routeIs('profile.alamat') ? 'active' : '' }}"><i class="fa fa-map-marker"></i> Alamat</a>
                    <a href="{{ route('profile.password') }}" class="{{ request()->routeIs('profile.password*') ? 'active' : '' }}"><i class="fa fa-lock"></i> Ubah Password</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="profile-main">
                <div class="profile-info-card" style="padding:0">

                    <div class="pa-header">
                        <h3 class="pa-title"><i class="fa fa-map-marker"></i> Daftar Alamat</h3>
                        <button class="pa-add-btn" onclick="openNewForm()">
                            <i class="fa fa-plus"></i> Tambah Alamat Baru
                        </button>
                    </div>

                    <div style="padding:20px 24px 24px">

                        @if(session('success'))
                            <div class="pa-alert success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="pa-alert error">
                                <i class="fa fa-exclamation-circle"></i>
                                <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                            </div>
                        @endif
                        @php
                            $addrList   = $addresses ?? collect();
                            $showForm   = $errors->any();
                            $formMode   = old('_form_mode', 'add');
                            $editAddrId = old('_addr_id', '');
                            $formAction = ($formMode === 'edit' && $editAddrId)
                                ? route('profile.alamat.update', $editAddrId)
                                : route('profile.alamat.store');
                        @endphp

                        <!-- Address List -->
                        @if($addrList->isEmpty())
                            <div class="pa-empty">
                                <div class="pa-empty-icon"><i class="fa fa-map-marker"></i></div>
                                <h4>Belum Ada Alamat</h4>
                                <p>Tambahkan alamat pengiriman agar proses checkout lebih cepat.</p>
                            </div>
                        @else
                            <div class="pa-list">
                                @foreach($addrList as $addr)
                                <div class="pa-card {{ $addr->is_primary ? 'pa-primary' : '' }}">
                                    <div class="pa-card-head">
                                        <span class="pa-label">{{ $addr->label }}</span>
                                        @if($addr->is_primary)
                                            <span class="pa-primary-badge"><i class="fa fa-star"></i> Utama</span>
                                        @endif
                                    </div>
                                    <div class="pa-recipient">{{ $addr->recipient_name }}</div>
                                    <div class="pa-phone"><i class="fa fa-phone"></i> {{ $addr->phone }}</div>
                                    <div class="pa-address">
                                        {{ $addr->alamat }}, RT.{{ $addr->rt }}/RW.{{ $addr->rw }},
                                        {{ $addr->kelurahan }}, {{ $addr->kecamatan }},
                                        {{ $addr->kota }}, {{ $addr->propinsi }} {{ $addr->kodepos }}
                                    </div>
                                    <div class="pa-foot">
                                        <button type="button" class="pa-btn edit" onclick='openEditForm(@json($addr))'>
                                            <i class="fa fa-pencil"></i> Ubah
                                        </button>
                                        @if(!$addr->is_primary)
                                            <span class="pa-btn-sep"></span>
                                            <form method="POST" action="{{ route('profile.alamat.primary', $addr) }}" style="display:inline;margin:0">
                                                @csrf
                                                <button type="submit" class="pa-btn primary">
                                                    <i class="fa fa-star"></i> Jadikan Utama
                                                </button>
                                            </form>
                                            <span class="pa-btn-sep"></span>
                                            <form method="POST" action="{{ route('profile.alamat.destroy', $addr) }}" style="display:inline;margin:0"
                                                  onsubmit="return confirm('Hapus alamat ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="pa-btn del">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        @else
                                            <span class="pa-check"><i class="fa fa-check-circle"></i> Alamat Utama</span>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Add / Edit Form -->
                        <div id="addr-form-wrap" style="{{ $showForm ? '' : 'display:none' }}">
                            <div class="pa-form-wrap">
                                <div class="pa-form-head">
                                    <span class="pa-form-head-title">
                                        <i class="fa fa-map-marker"></i>
                                        <span id="addr-form-title">{{ $formMode === 'edit' ? 'Ubah Alamat' : 'Tambah Alamat Baru' }}</span>
                                    </span>
                                    <button type="button" class="pa-form-close" onclick="closeAddrForm()" title="Tutup">&times;</button>
                                </div>
                                <div class="pa-form-body">
                                <form id="addr-form" method="POST" action="{{ $formAction }}">
                                    @csrf
                                    <input type="hidden" name="_method"    id="form-method-override" value="{{ $formMode === 'edit' ? 'PUT' : 'POST' }}">
                                    <input type="hidden" name="_form_mode" id="form-mode-field"      value="{{ $formMode }}">
                                    <input type="hidden" name="_addr_id"   id="form-addr-id"         value="{{ $editAddrId }}">
                                    <input type="hidden" id="propinsi"  name="propinsi"  value="{{ old('propinsi', '') }}">
                                    <input type="hidden" id="kota"      name="kota"      value="{{ old('kota', '') }}">
                                    <input type="hidden" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', '') }}">
                                    <input type="hidden" id="kelurahan" name="kelurahan" value="{{ old('kelurahan', '') }}">

                                    <div class="pa-section-lbl"><i class="fa fa-id-card-o"></i> Informasi Penerima</div>
                                    <div class="profile-form">
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label><i class="fa fa-tag"></i> Label Alamat</label>
                                                <input type="text" name="label" id="f_label" value="{{ old('label', '') }}" placeholder="Contoh: Rumah, Kantor" required>
                                                @error('label')<span class="error-message">{{ $message }}</span>@enderror
                                            </div>
                                            <div class="form-group">
                                                <label><i class="fa fa-user"></i> Nama Penerima</label>
                                                <input type="text" name="recipient_name" id="f_recipient_name" value="{{ old('recipient_name', '') }}" placeholder="Nama lengkap penerima" required>
                                                @error('recipient_name')<span class="error-message">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label><i class="fa fa-phone"></i> No. HP Penerima</label>
                                            <input type="text" name="phone" id="f_phone" value="{{ old('phone', '') }}" placeholder="08xxxxxxxxxx" inputmode="tel" required>
                                            @error('phone')<span class="error-message">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="pa-section-lbl pa-section-div"><i class="fa fa-map-marker"></i> Detail Lokasi</div>
                                    <div class="profile-form">
                                        <div class="form-group">
                                            <label><i class="fa fa-home"></i> Alamat (Nama Jalan/Gang/No. Rumah)</label>
                                            <input type="text" name="alamat" id="f_alamat" value="{{ old('alamat', '') }}" placeholder="Jl. Contoh No. 123" required>
                                            @error('alamat')<span class="error-message">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label><i class="fa fa-map-marker"></i> Provinsi</label>
                                                <select id="province_code" name="province_code" required>
                                                    <option value="">-- Memuat data... --</option>
                                                </select>
                                                @error('province_code')<span class="error-message">{{ $message }}</span>@enderror
                                            </div>
                                            <div class="form-group">
                                                <label><i class="fa fa-building-o"></i> Kota / Kabupaten</label>
                                                <select id="regency_code" name="regency_code" disabled required>
                                                    <option value="">-- Pilih Provinsi dulu --</option>
                                                </select>
                                                @error('regency_code')<span class="error-message">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label><i class="fa fa-map-o"></i> Kecamatan</label>
                                                <select id="district_code" name="district_code" disabled required>
                                                    <option value="">-- Pilih Kota/Kab dulu --</option>
                                                </select>
                                                @error('district_code')<span class="error-message">{{ $message }}</span>@enderror
                                            </div>
                                            <div class="form-group">
                                                <label><i class="fa fa-home"></i> Kelurahan / Desa</label>
                                                <select id="village_code" name="village_code" disabled required>
                                                    <option value="">-- Pilih Kecamatan dulu --</option>
                                                </select>
                                                @error('village_code')<span class="error-message">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="form-row" style="grid-template-columns:1fr 1fr 1fr">
                                            <div class="form-group">
                                                <label><i class="fa fa-hashtag"></i> RT</label>
                                                <input type="text" name="rt" id="f_rt" value="{{ old('rt', '') }}" placeholder="001" maxlength="5" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                                                @error('rt')<span class="error-message">{{ $message }}</span>@enderror
                                            </div>
                                            <div class="form-group">
                                                <label><i class="fa fa-hashtag"></i> RW</label>
                                                <input type="text" name="rw" id="f_rw" value="{{ old('rw', '') }}" placeholder="001" maxlength="5" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                                                @error('rw')<span class="error-message">{{ $message }}</span>@enderror
                                            </div>
                                            <div class="form-group">
                                                <label><i class="fa fa-envelope-o"></i> Kode Pos</label>
                                                <input type="text" name="kodepos" id="f_kodepos" value="{{ old('kodepos', '') }}" placeholder="12345" maxlength="5" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,5)" required>
                                                @error('kodepos')<span class="error-message">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="pa-form-actions">
                                            <button type="submit" class="pa-save-btn"><i class="fa fa-save"></i> Simpan Alamat</button>
                                            <button type="button" class="pa-cancel-btn" onclick="closeAddrForm()"><i class="fa fa-times"></i> Batal</button>
                                        </div>
                                    </div>
                                </form>
                                </div>{{-- pa-form-body --}}
                            </div>{{-- pa-form-wrap --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    const urls = {
        provinces: '{{ route('wilayah.provinces', [], false) }}',
        regencies: c => '/api/wilayah/regencies/' + c,
        districts: c => '/api/wilayah/districts/' + c,
        villages:  c => '/api/wilayah/villages/' + c,
    };

    // -- Province cache -------------------------------------------
    let provincesCache = null;

    // -- Searchable Select ----------------------------------------
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
        panel.innerHTML = '<div class="ss-search"><input type="text" placeholder="Cari..."></div><div class="ss-list"></div>';
        document.body.appendChild(panel);

        const trigger  = wrapper.querySelector('.ss-trigger');
        const trigText = wrapper.querySelector('.ss-trigger-text');
        const searchEl = panel.querySelector('.ss-search input');
        const listEl   = panel.querySelector('.ss-list');
        let   items    = [];

        function positionPanel() {
            const r = trigger.getBoundingClientRect();
            panel.style.top    = (r.bottom + 4) + 'px';
            panel.style.left   = r.left + 'px';
            panel.style.width  = r.width + 'px';
        }

        function renderList(filter) {
            const q = (filter || '').toLowerCase();
            const matched = q ? items.filter(i => i.text.toLowerCase().includes(q)) : items;
            if (!matched.length) {
                listEl.innerHTML = '<div class="ss-empty-msg">Tidak ada hasil</div>';
                return;
            }
            listEl.innerHTML = matched.map(i =>
                `<div class="ss-item${i.value === select.value ? ' ss-selected' : ''}" data-value="${i.value}">${i.text}</div>`
            ).join('');
            listEl.querySelectorAll('.ss-item').forEach(el => {
                el.addEventListener('mousedown', e => {
                    e.preventDefault();
                    select.value = el.dataset.value;
                    trigText.textContent = el.textContent;
                    trigText.classList.remove('ss-empty');
                    closePanel();
                    select.dispatchEvent(new Event('change', { bubbles: true }));
                });
            });
        }

        function openPanel() {
            if (select.disabled) return;
            wrapper.classList.add('ss-open');
            panel.classList.add('ss-panel-open');
            positionPanel();
            searchEl.value = '';
            renderList('');
            searchEl.focus();
        }

        function closePanel() {
            wrapper.classList.remove('ss-open');
            panel.classList.remove('ss-panel-open');
        }

        function refreshItems() {
            items = Array.from(select.options)
                .filter(o => o.value !== '')
                .map(o => ({ value: o.value, text: o.textContent.trim() }));
            if (select.value) {
                const sel = items.find(i => i.value === select.value);
                if (sel) {
                    trigText.textContent = sel.text;
                    trigText.classList.remove('ss-empty');
                } else {
                    trigText.textContent = placeholder;
                    trigText.classList.add('ss-empty');
                }
            } else {
                trigText.textContent = placeholder;
                trigText.classList.add('ss-empty');
            }
        }

        trigger.addEventListener('click', () => wrapper.classList.contains('ss-open') ? closePanel() : openPanel());
        searchEl.addEventListener('input', () => renderList(searchEl.value));
        document.addEventListener('click', e => {
            if (!wrapper.contains(e.target) && !panel.contains(e.target)) closePanel();
        });
        window.addEventListener('scroll', () => { if (panel.classList.contains('ss-panel-open')) positionPanel(); }, true);

        refreshItems();

        return { refreshItems, enable() { select.disabled = false; wrapper.classList.remove('ss-disabled'); }, disable() { select.disabled = true; wrapper.classList.add('ss-disabled'); } };
    }

    // -- Initialize selects ---------------------------------------
    const ssProvince = makeSearchableSelect('province_code', 'Pilih Provinsi');
    const ssRegency  = makeSearchableSelect('regency_code',  'Pilih Kota/Kab');
    const ssDistrict = makeSearchableSelect('district_code', 'Pilih Kecamatan');
    const ssVillage  = makeSearchableSelect('village_code',  'Pilih Kelurahan/Desa');

    // hidden name fields
    const hidPropinsi  = document.getElementById('propinsi');
    const hidKota      = document.getElementById('kota');
    const hidKecamatan = document.getElementById('kecamatan');
    const hidKelurahan = document.getElementById('kelurahan');

    // -- Load provinces -------------------------------------------
    async function loadProvinces(selectedValue) {
        if (provincesCache) {
            populateSelect('province_code', provincesCache, selectedValue);
            if (ssProvince) ssProvince.refreshItems();
            return;
        }
        const resp = await fetch(urls.provinces);
        const data = await resp.json();
        provincesCache = data;
        populateSelect('province_code', data, selectedValue);
        if (ssProvince) ssProvince.refreshItems();
    }

    function populateSelect(id, data, selectedValue) {
        const sel = document.getElementById(id);
        sel.innerHTML = '<option value="">-- Pilih --</option>';
        data.forEach(item => {
            const opt = document.createElement('option');
            opt.value = item.code ?? item.id;
            opt.textContent = item.name;
            if (opt.value === String(selectedValue)) opt.selected = true;
            sel.appendChild(opt);
        });
    }

    async function loadRegencies(provCode, selectedValue) {
        const sel = document.getElementById('regency_code');
        sel.innerHTML = '<option value="">-- Memuat... --</option>';
        if (ssRegency) ssRegency.disable();
        const resp = await fetch(urls.regencies(provCode));
        const data = await resp.json();
        populateSelect('regency_code', data, selectedValue);
        if (ssRegency) { ssRegency.enable(); ssRegency.refreshItems(); }
    }

    async function loadDistricts(regCode, selectedValue) {
        const sel = document.getElementById('district_code');
        sel.innerHTML = '<option value="">-- Memuat... --</option>';
        if (ssDistrict) ssDistrict.disable();
        const resp = await fetch(urls.districts(regCode));
        const data = await resp.json();
        populateSelect('district_code', data, selectedValue);
        if (ssDistrict) { ssDistrict.enable(); ssDistrict.refreshItems(); }
    }

    async function loadVillages(distCode, selectedValue) {
        const sel = document.getElementById('village_code');
        sel.innerHTML = '<option value="">-- Memuat... --</option>';
        if (ssVillage) ssVillage.disable();
        const resp = await fetch(urls.villages(distCode));
        const data = await resp.json();
        populateSelect('village_code', data, selectedValue);
        if (ssVillage) { ssVillage.enable(); ssVillage.refreshItems(); }
    }

    // -- Cascade change events ------------------------------------
    document.getElementById('province_code').addEventListener('change', function () {
        hidPropinsi.value = this.options[this.selectedIndex] ? this.options[this.selectedIndex].textContent : '';
        document.getElementById('regency_code').innerHTML  = '<option value="">-- Pilih Kota/Kab dulu --</option>';
        document.getElementById('district_code').innerHTML = '<option value="">-- Pilih Kota/Kab dulu --</option>';
        document.getElementById('village_code').innerHTML  = '<option value="">-- Pilih Kecamatan dulu --</option>';
        hidKota.value = ''; hidKecamatan.value = ''; hidKelurahan.value = '';
        if (ssRegency)  { ssRegency.disable();  ssRegency.refreshItems(); }
        if (ssDistrict) { ssDistrict.disable(); ssDistrict.refreshItems(); }
        if (ssVillage)  { ssVillage.disable();  ssVillage.refreshItems(); }
        if (this.value) loadRegencies(this.value, '');
    });

    document.getElementById('regency_code').addEventListener('change', function () {
        hidKota.value = this.options[this.selectedIndex] ? this.options[this.selectedIndex].textContent : '';
        document.getElementById('district_code').innerHTML = '<option value="">-- Pilih Kota/Kab dulu --</option>';
        document.getElementById('village_code').innerHTML  = '<option value="">-- Pilih Kecamatan dulu --</option>';
        hidKecamatan.value = ''; hidKelurahan.value = '';
        if (ssDistrict) { ssDistrict.disable(); ssDistrict.refreshItems(); }
        if (ssVillage)  { ssVillage.disable();  ssVillage.refreshItems(); }
        if (this.value) loadDistricts(this.value, '');
    });

    document.getElementById('district_code').addEventListener('change', function () {
        hidKecamatan.value = this.options[this.selectedIndex] ? this.options[this.selectedIndex].textContent : '';
        document.getElementById('village_code').innerHTML = '<option value="">-- Pilih Kecamatan dulu --</option>';
        hidKelurahan.value = '';
        if (ssVillage) { ssVillage.disable(); ssVillage.refreshItems(); }
        if (this.value) loadVillages(this.value, '');
    });

    document.getElementById('village_code').addEventListener('change', function () {
        hidKelurahan.value = this.options[this.selectedIndex] ? this.options[this.selectedIndex].textContent : '';
    });

    // -- Form open/close ------------------------------------------
    window.openNewForm = function () {
        document.getElementById('addr-form-wrap').style.display = '';
        document.getElementById('addr-form-title').textContent  = 'Tambah Alamat Baru';
        document.getElementById('addr-form').action = '{{ route('profile.alamat.store', [], false) }}';
        document.getElementById('form-method-override').value   = 'POST';
        document.getElementById('form-mode-field').value        = 'add';
        document.getElementById('form-addr-id').value           = '';

        // Clear fields
        ['f_label','f_recipient_name','f_phone','f_alamat','f_rt','f_rw','f_kodepos'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
        hidPropinsi.value = ''; hidKota.value = ''; hidKecamatan.value = ''; hidKelurahan.value = '';

        // Reset selects
        document.getElementById('regency_code').innerHTML  = '<option value="">-- Pilih Provinsi dulu --</option>';
        document.getElementById('district_code').innerHTML = '<option value="">-- Pilih Kota/Kab dulu --</option>';
        document.getElementById('village_code').innerHTML  = '<option value="">-- Pilih Kecamatan dulu --</option>';
        if (ssRegency)  { ssRegency.disable();  ssRegency.refreshItems(); }
        if (ssDistrict) { ssDistrict.disable(); ssDistrict.refreshItems(); }
        if (ssVillage)  { ssVillage.disable();  ssVillage.refreshItems(); }

        // Reload provinces (use cache if available)
        loadProvinces('').then(() => {
            document.getElementById('addr-form-wrap').scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    };

    window.openEditForm = function (addr) {
        document.getElementById('addr-form-wrap').style.display = '';
        document.getElementById('addr-form-title').textContent  = 'Ubah Alamat';
        document.getElementById('addr-form').action = '/profile/alamat/' + addr.id;
        document.getElementById('form-method-override').value   = 'PUT';
        document.getElementById('form-mode-field').value        = 'edit';
        document.getElementById('form-addr-id').value           = addr.id;

        document.getElementById('f_label').value          = addr.label          ?? '';
        document.getElementById('f_recipient_name').value = addr.recipient_name ?? '';
        document.getElementById('f_phone').value          = addr.phone          ?? '';
        document.getElementById('f_alamat').value         = addr.alamat         ?? '';
        document.getElementById('f_rt').value             = addr.rt             ?? '';
        document.getElementById('f_rw').value             = addr.rw             ?? '';
        document.getElementById('f_kodepos').value        = addr.kodepos        ?? '';

        hidPropinsi.value  = addr.propinsi  ?? '';
        hidKota.value      = addr.kota      ?? '';
        hidKecamatan.value = addr.kecamatan ?? '';
        hidKelurahan.value = addr.kelurahan ?? '';

        // Load cascade: province ? regency ? district ? village
        loadProvinces(addr.province_code).then(() => {
            if (!addr.province_code) return;
            return loadRegencies(addr.province_code, addr.regency_code);
        }).then(() => {
            if (!addr.regency_code) return;
            return loadDistricts(addr.regency_code, addr.district_code);
        }).then(() => {
            if (!addr.district_code) return;
            return loadVillages(addr.district_code, addr.village_code);
        }).then(() => {
            document.getElementById('addr-form-wrap').scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    };

    window.closeAddrForm = function () {
        document.getElementById('addr-form-wrap').style.display = 'none';
    };

    // -- Auto-open form on validation error -----------------------
    @if($errors->any())
    (async () => {
        const pCode = '{{ old('province_code', '') }}';
        const rCode = '{{ old('regency_code', '') }}';
        const dCode = '{{ old('district_code', '') }}';
        const vCode = '{{ old('village_code', '') }}';

        await loadProvinces(pCode);
        if (pCode) await loadRegencies(pCode, rCode);
        if (rCode) await loadDistricts(rCode, dCode);
        if (dCode) await loadVillages(dCode, vCode);

        document.getElementById('addr-form-wrap').scrollIntoView({ behavior: 'smooth', block: 'start' });
    })();
    @endif

    // -- Initial province load ----------------------------------- 
    // (only load if form is already visible — e.g. on error)
    @if(!$errors->any())
    loadProvinces('');
    @endif

})();
</script>
@endpush
