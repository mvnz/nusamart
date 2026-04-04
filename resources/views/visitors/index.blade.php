@extends('layouts.app')

@section('title', 'Statistik Pengunjung - NusaMart Admin')

@section('content')
<style>
.ck-wrap         { max-width:1140px; margin:0 auto; padding:28px 16px 48px; }
.ck-page-header  { display:flex; align-items:center; justify-content:space-between; margin-bottom:26px; flex-wrap:wrap; gap:12px; }
.ck-page-title   { font-size:21px; font-weight:800; color:#1e1f29; display:flex; align-items:center; gap:10px; margin:0; }
.ck-page-title i { color:#D10024; font-size:20px; }
.ck-back-btn     { display:inline-flex; align-items:center; gap:7px; padding:9px 16px; background:#f4f5f7; color:#555; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; text-decoration:none; transition:background .15s; }
.ck-back-btn:hover { background:#e5e7eb; color:#1e1f29; }

.ck-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
@media(max-width:700px){ .ck-stats{ grid-template-columns:repeat(2,1fr); } }
.ck-stat  { background:#fff; border-radius:14px; box-shadow:0 2px 10px rgba(0,0,0,.06); padding:20px; display:flex; align-items:center; gap:14px; }
.ck-si    { width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:19px; flex-shrink:0; }
.ck-si.red   { background:linear-gradient(135deg,#ffd6d6,#ffefef); color:#D10024; }
.ck-si.blue  { background:linear-gradient(135deg,#c9e9ff,#edf6ff); color:#1565c0; }
.ck-si.green { background:linear-gradient(135deg,#c8f7d6,#edfff3); color:#1a9e50; }
.ck-si.grey  { background:linear-gradient(135deg,#e5e7eb,#f3f4f6); color:#6b7280; }
.ck-sv { font-size:26px; font-weight:800; color:#1e1f29; line-height:1; }
.ck-sl { font-size:12px; color:#8d8d8d; margin-top:3px; font-weight:500; }

.ck-grid { display:grid; grid-template-columns:1fr 340px; gap:20px; align-items:start; }
@media(max-width:900px){ .ck-grid { grid-template-columns:1fr } }

.ck-card  { background:#fff; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.07); overflow:hidden; }
.ck-card-header { display:flex; align-items:center; justify-content:space-between; padding:18px 22px; border-bottom:1px solid #f2f2f5; }
.ck-card-title  { font-size:14px; font-weight:800; color:#1e1f29; display:flex; align-items:center; gap:8px; margin:0; }
.ck-card-title i { color:#D10024; }

.ck-table { width:100%; border-collapse:collapse; font-size:13px; }
.ck-table th { background:#f8f9fb; font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#8d8d8d; padding:11px 20px; text-align:left; border-bottom:1px solid #f0f0f0; }
.ck-table td { padding:13px 20px; border-bottom:1px solid #f7f7f9; vertical-align:middle; }
.ck-table tbody tr:last-child td { border-bottom:none }
.ck-table tbody tr:hover td { background:#fafbfc }

.ck-bar-wrap { padding:16px 22px 20px; }
.ck-bar-row  { margin-bottom:12px; }
.ck-bar-meta { display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px; }
.ck-bar-meta span:first-child { font-weight:600; color:#444 }
.ck-bar-meta span:last-child  { color:#888 }
.ck-bar-bg   { background:#f0f0f0; border-radius:4px; height:7px; overflow:hidden; }
.ck-bar-fill { height:7px; border-radius:4px; background:linear-gradient(90deg,#D10024,#ff6b6b); }

.ck-device-row { display:flex; align-items:center; gap:12px; padding:14px 22px; border-bottom:1px solid #f5f5f5; }
.ck-device-row:last-child { border-bottom:none }
.ck-device-icon { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.ck-device-name { font-size:13px; font-weight:700; color:#333; }
.ck-device-sub  { font-size:11px; color:#aaa; margin-top:1px; }
.ck-device-pct  { margin-left:auto; font-size:14px; font-weight:800; }

.pagination { justify-content:center; margin:16px 0 4px }
</style>

<div class="ck-wrap">
    <div class="ck-page-header">
        <h1 class="ck-page-title"><i class="fa fa-line-chart"></i> Statistik Pengunjung</h1>
        <a href="{{ route('dashboard') }}" class="ck-back-btn"><i class="fa fa-arrow-left"></i> Kembali ke Dashboard</a>
    </div>

    {{-- Stat Cards --}}
    <div class="ck-stats">
        <div class="ck-stat">
            <div class="ck-si red"><i class="fa fa-clock-o"></i></div>
            <div><div class="ck-sv">{{ $visitorsToday }}</div><div class="ck-sl">Hari Ini</div></div>
        </div>
        <div class="ck-stat">
            <div class="ck-si blue"><i class="fa fa-calendar-check-o"></i></div>
            <div><div class="ck-sv">{{ $visitorsThisWeek }}</div><div class="ck-sl">Minggu Ini</div></div>
        </div>
        <div class="ck-stat">
            <div class="ck-si green"><i class="fa fa-calendar"></i></div>
            <div><div class="ck-sv">{{ $visitorsThisMonth }}</div><div class="ck-sl">Bulan Ini</div></div>
        </div>
        <div class="ck-stat">
            <div class="ck-si grey"><i class="fa fa-users"></i></div>
            <div><div class="ck-sv">{{ $visitorsTotal }}</div><div class="ck-sl">Total Pengunjung</div></div>
        </div>
    </div>

    <div class="ck-grid">
        {{-- City Table --}}
        <div class="ck-card">
            <div class="ck-card-header">
                <h2 class="ck-card-title"><i class="fa fa-map-marker"></i> Kota Pengunjung</h2>
                <span style="font-size:12px;color:#aaa">Halaman {{ $allCities->currentPage() }} / {{ $allCities->lastPage() }}</span>
            </div>
            @if($allCities->isEmpty())
                <div style="text-align:center;padding:48px;color:#bbb;font-size:13px">
                    <i class="fa fa-map-marker" style="font-size:32px;margin-bottom:12px;display:block"></i>
                    Belum ada data kota pengunjung
                </div>
            @else
            @php $globalMax = $allCities->getCollection()->first()->total; @endphp
            <table class="ck-table">
                <thead>
                    <tr>
                        <th style="width:44px">#</th>
                        <th>Kota</th>
                        <th style="width:140px">Pengunjung</th>
                        <th style="width:180px">Proporsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allCities as $row)
                    @php
                        $rank = ($allCities->currentPage() - 1) * $allCities->perPage() + $loop->iteration;
                        $pct  = $globalMax > 0 ? round($row->total / $globalMax * 100) : 0;
                    @endphp
                    <tr>
                        <td style="color:#ccc;font-weight:800;font-size:12px">{{ $rank }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px">
                                <div style="width:28px;height:28px;background:#fff0f2;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                    <i class="fa fa-map-marker" style="color:#D10024;font-size:12px"></i>
                                </div>
                                <span style="font-weight:600;color:#333">{{ $row->city }}</span>
                            </div>
                        </td>
                        <td>
                            <span style="font-weight:700;color:#1e1f29">{{ number_format($row->total) }}</span>
                            <span style="font-size:11px;color:#bbb;margin-left:2px">pengunjung</span>
                        </td>
                        <td>
                            <div style="background:#f0f0f0;border-radius:4px;height:7px;overflow:hidden">
                                <div class="ck-bar-fill" style="width:{{ $pct }}%"></div>
                            </div>
                            <div style="font-size:10.5px;color:#aaa;margin-top:3px">{{ $pct }}%</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding:12px 20px">
                {{ $allCities->links() }}
            </div>
            @endif
        </div>

        {{-- Side Panel: Device + Top 10 bar --}}
        <div style="display:flex;flex-direction:column;gap:20px">
            {{-- Device --}}
            <div class="ck-card">
                <div class="ck-card-header">
                    <h2 class="ck-card-title"><i class="fa fa-laptop"></i> Perangkat</h2>
                </div>
                @php
                    $cntDesktop = $deviceStats['desktop'] ?? 0;
                    $cntMobile  = $deviceStats['mobile']  ?? 0;
                    $cntAll     = $cntDesktop + $cntMobile;
                    $pctD = $cntAll > 0 ? round($cntDesktop / $cntAll * 100) : 0;
                    $pctM = $cntAll > 0 ? 100 - $pctD : 0;
                @endphp
                <div class="ck-device-row">
                    <div class="ck-device-icon" style="background:#e8f4fd">
                        <i class="fa fa-desktop" style="color:#2196f3;font-size:18px"></i>
                    </div>
                    <div>
                        <div class="ck-device-name">PC / Desktop</div>
                        <div class="ck-device-sub">{{ number_format($cntDesktop) }} pengunjung</div>
                    </div>
                    <div class="ck-device-pct" style="color:#2196f3">{{ $pctD }}%</div>
                </div>
                <div class="ck-device-row">
                    <div class="ck-device-icon" style="background:#fff0f2">
                        <i class="fa fa-mobile" style="color:#D10024;font-size:22px"></i>
                    </div>
                    <div>
                        <div class="ck-device-name">HP / Mobile</div>
                        <div class="ck-device-sub">{{ number_format($cntMobile) }} pengunjung</div>
                    </div>
                    <div class="ck-device-pct" style="color:#D10024">{{ $pctM }}%</div>
                </div>
                @if($cntAll > 0)
                <div style="padding:8px 22px 16px">
                    <div style="background:#f0f0f0;border-radius:4px;height:7px;overflow:hidden">
                        <div style="height:7px;border-radius:4px;background:linear-gradient(90deg,#2196f3 {{ $pctD }}%,#D10024 {{ $pctD }}%)"></div>
                    </div>
                </div>
                @endif
            </div>

            {{-- Top 10 bar chart --}}
            @if($allCities->isNotEmpty())
            <div class="ck-card">
                <div class="ck-card-header">
                    <h2 class="ck-card-title"><i class="fa fa-bar-chart"></i> Top 10 Kota</h2>
                </div>
                @php
                    $top10   = \App\Models\VisitorLog::whereNotNull('city')->where('city','!=','')
                        ->selectRaw('city, COUNT(*) as total')->groupBy('city')->orderByDesc('total')->take(10)->get();
                    $maxTop = $top10->first()->total ?? 1;
                @endphp
                <div class="ck-bar-wrap">
                    @foreach($top10 as $row)
                    <div class="ck-bar-row">
                        <div class="ck-bar-meta">
                            <span>{{ $row->city }}</span>
                            <span>{{ number_format($row->total) }}</span>
                        </div>
                        <div class="ck-bar-bg">
                            <div class="ck-bar-fill" style="width:{{ round($row->total / $maxTop * 100) }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
