@extends('layouts.app')

@section('title', 'Dashboard - NusaMart')

@section('content')
    @if(auth()->user()->role == 'admin')
        @include('dashboard.admin')
    @elseif(auth()->user()->role == 'penjual')
        @include('dashboard.penjual')
    @else
        @include('dashboard.pembeli')
    @endif
@endsection
