@extends('layouts.app')

@section('title', 'Kelola Kuliner - NusaMart Admin')

@section('content')
<style>
.kl-wrap { max-width: 1140px; margin: 0 auto; padding: 28px 16px 48px; }
.kl-page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 26px; flex-wrap: wrap; gap: 12px; }
.kl-page-title { font-size: 21px; font-weight: 800; color: #1e1f29; display: flex; align-items: center; gap: 10px; margin: 0; }
.kl-page-title i { color: #d97706; font-size: 20px; }
.kl-addbtn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px; background: #D10024; color: #fff; border: none; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit; transition: background .18s; text-decoration: none; }
.kl-addbtn:hover { background: #a8001e; }

.kl-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
@media(max-width: 600px) { .kl-stats { grid-template-columns: repeat(2, 1fr); } }
.kl-stat { background: #fff; border-radius: 14px; box-shadow: 0 2px 10px rgba(0,0,0,.06); padding: 20px; display: flex; align-items: center; gap: 14px; }
.kl-si { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 19px; flex-shrink: 0; }
.kl-si.orange { background: linear-gradient(135deg, #ffe4b2, #fff7e6); color: #d97706; }
.kl-si.green  { background: linear-gradient(135deg, #c8f7d6, #edfff3); color: #1a9e50; }
.kl-si.red    { background: linear-gradient(135deg, #ffd6d6, #ffefef); color: #D10024; }
.kl-sv { font-size: 26px; font-weight: 800; color: #1e1f29; line-height: 1; }
.kl-sl { font-size: 12px; color: #8d8d8d; margin-top: 3px; font-weight: 500; }

.kl-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,.07); overflow: hidden; }
.kl-toolbar { display: flex; align-items: center; gap: 12px; padding: 18px 22px; border-bottom: 1px solid #f2f2f5; flex-wrap: wrap; }
.kl-search { display: flex; align-items: center; border: 1.5px solid #e5e7eb; border-radius: 10px; overflow: hidden; transition: border .2s; background: #f9fafb; flex: 1; min-width: 180px; max-width: 280px; }
.kl-search:focus-within { border-color: #D10024; background: #fff; }
.kl-search i { padding: 0 12px; color: #c0c0c0; font-size: 13px; }
.kl-search input { flex: 1; border: none; outline: none; padding: 10px 0; font-size: 13px; background: transparent; font-family: inherit; }

.kl-alert { display: flex; align-items: center; gap: 8px; padding: 12px 22px; font-size: 13px; }
.kl-alert.success { background: #d1fae5; border-bottom: 1px solid #6ee7b7; color: #065f46; }
.kl-alert.error   { background: #fee2e2; border-bottom: 1px solid #fca5a5; color: #991b1b; }

.kl-table-wrap { overflow-x: auto; }
.kl-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.kl-table th { background: #f8f9fb; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #8d8d8d; padding: 11px 16px; text-align: left; border-bottom: 1px solid #f0f0f0; white-space: nowrap; }
.kl-table td { padding: 12px 16px; border-bottom: 1px solid #f7f7f9; vertical-align: middle; }
.kl-table tbody tr:last-child td { border-bottom: none; }
.kl-table tbody tr:hover td { background: #fafbfc; }

.kl-thumb { width: 52px; height: 52px; border-radius: 8px; object-fit: cover; background: #f0f0f0; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0; }
.kl-thumb img { width: 100%; height: 100%; object-fit: cover; }
.kl-thumb i { font-size: 22px; color: #ddd; }

.kl-name { font-weight: 700; color: #1e1f29; }
.kl-sub { font-size: 11px; color: #8d8d8d; margin-top: 2px; }

.badge-buka  { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; background: #d1fae5; color: #065f46; }
.badge-tutup { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; background: #fee2e2; color: #991b1b; }

.kl-btn { border: none; cursor: pointer; font-size: 11px; font-weight: 700; padding: 5px 12px; border-radius: 20px; transition: all .2s; text-transform: uppercase; letter-spacing: .4px; text-decoration: none; display: inline-block; }
.kl-btn-edit   { background: #e3f2fd; color: #1565c0; }
.kl-btn-edit:hover   { background: #1565c0; color: #fff; }
.kl-btn-delete { background: #fce4ec; color: #D10024; }
.kl-btn-delete:hover { background: #D10024; color: #fff; }

.kl-empty { text-align: center; padding: 48px 20px; color: #999; }
.kl-empty .fa { font-size: 42px; color: #e5e7eb; display: block; margin-bottom: 12px; }
</style>

<div class="kl-wrap">
    <div class="kl-page-header">
        <h1 class="kl-page-title"><i class="fa fa-cutlery"></i> Kelola Kuliner Lokal</h1>
        <a href="{{ route('admin.kuliner.create') }}" class="kl-addbtn">
            <i class="fa fa-plus"></i> Tambah Warung
        </a>
    </div>

    {{-- Stats --}}
    <div class="kl-stats">
        <div class="kl-stat">
            <div class="kl-si orange"><i class="fa fa-cutlery"></i></div>
            <div>
                <div class="kl-sv">{{ $kuliners->count() }}</div>
                <div class="kl-sl">Total Warung</div>
            </div>
        </div>
        <div class="kl-stat">
            <div class="kl-si green"><i class="fa fa-check-circle"></i></div>
            <div>
                <div class="kl-sv">{{ $kuliners->where('status', 'buka')->count() }}</div>
                <div class="kl-sl">Sedang Buka</div>
            </div>
        </div>
        <div class="kl-stat">
            <div class="kl-si red"><i class="fa fa-times-circle"></i></div>
            <div>
                <div class="kl-sv">{{ $kuliners->where('status', 'tutup')->count() }}</div>
                <div class="kl-sl">Sedang Tutup</div>
            </div>
        </div>
    </div>

    <div class="kl-card">
        <div class="kl-toolbar">
            <div class="kl-search">
                <i class="fa fa-search"></i>
                <input type="text" id="klSearch" placeholder="Cari nama warung..." oninput="filterKuliner()">
            </div>
            <span id="klCount" style="font-size:12px; color:#8d8d8d; margin-left:auto;"></span>
        </div>

        @if(session('success'))
            <div class="kl-alert success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="kl-alert error"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        <div class="kl-table-wrap">
            <table class="kl-table">
                <thead>
                    <tr>
                        <th>Warung</th>
                        <th>Kategori</th>
                        <th>Jam Buka</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="klTableBody">
                    @forelse($kuliners as $kuliner)
                    <tr data-search="{{ strtolower($kuliner->nama . ' ' . $kuliner->kategori . ' ' . $kuliner->alamat) }}">
                        <td>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="kl-thumb">
                                    @if($kuliner->gambar && file_exists(public_path('uploads/' . $kuliner->gambar)))
                                        <img src="{{ asset('uploads/' . $kuliner->gambar) }}" alt="{{ $kuliner->nama }}">
                                    @else
                                        <i class="fa fa-cutlery"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="kl-name">{{ $kuliner->nama }}</div>
                                    <div class="kl-sub"><i class="fa fa-map-marker"></i> {{ Str::limit($kuliner->alamat, 45) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $kuliner->kategori }}</td>
                        <td>{{ $kuliner->jam_buka }} – {{ $kuliner->jam_tutup }}</td>
                        <td>
                            <span class="badge-{{ $kuliner->status }}">{{ ucfirst($kuliner->status) }}</span>
                        </td>
                        <td>
                            <div style="display:flex; gap:6px; flex-wrap:wrap;">
                                <a href="{{ route('admin.kuliner.edit', $kuliner->id) }}" class="kl-btn kl-btn-edit">Edit</a>
                                <form action="{{ route('admin.kuliner.destroy', $kuliner->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus warung {{ addslashes($kuliner->nama) }}? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="kl-btn kl-btn-delete">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="kl-empty">
                            <i class="fa fa-cutlery"></i>
                            Belum ada warung. <a href="{{ route('admin.kuliner.create') }}" style="color:#D10024;">Tambah sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function filterKuliner() {
    var q = document.getElementById('klSearch').value.toLowerCase().trim();
    var rows = document.querySelectorAll('#klTableBody tr[data-search]');
    var count = 0;
    rows.forEach(function(row) {
        var match = !q || row.dataset.search.includes(q);
        row.style.display = match ? '' : 'none';
        if (match) count++;
    });
    var el = document.getElementById('klCount');
    el.textContent = q ? count + ' dari ' + rows.length + ' warung' : '';
}
</script>
@endsection
