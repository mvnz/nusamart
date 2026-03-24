<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

class WilayahController extends Controller
{
    public function provinces(): JsonResponse
    {
        $provinces = Province::orderBy('name')->get(['code', 'name']);
        return response()->json($provinces);
    }

    public function regencies(string $code): JsonResponse
    {
        $regencies = City::where('province_code', $code)->orderBy('name')->get(['code', 'name']);
        return response()->json($regencies);
    }

    public function districts(string $code): JsonResponse
    {
        $districts = District::where('city_code', $code)->orderBy('name')->get(['code', 'name']);
        return response()->json($districts);
    }

    public function villages(string $code): JsonResponse
    {
        $villages = Village::where('district_code', $code)->orderBy('name')->get(['code', 'name']);
        return response()->json($villages);
    }
}
