@extends('layouts.app')

@section('title', 'Dashboard - NusaMart')

@push('styles')
<style>
@media (max-width: 768px) {
    .orders-card { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    table th, table td { padding: 10px 12px; font-size: 12px; white-space: nowrap; }
    .orders-card .card-header h3 { font-size: 14px; }
    .orders-card .card-header { padding: 12px 16px; }
    .two-col-grid { gap: 15px; }
    .orders-section .container { padding: 0 10px; }
}
@media (max-width: 480px) {
    .orders-section .container { padding: 0 6px; }
    .two-col-grid { gap: 10px; }
}
</style>
@endpush

@section('content')
    @if(auth()->user()->role == 'admin')
        @include('dashboard.admin')
    @elseif(auth()->user()->role == 'penjual')
        @include('dashboard.penjual')
    @else
        @include('dashboard.pembeli')
    @endif
@endsection
