<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use App\Models\CourierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourierController extends Controller
{
    public function index(Request $request)
    {
        $query = Courier::withCount(['services', 'activeServices'])->orderBy('name');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }

        $couriers = $query->with('services')->get();

        $stats = [
            'total'    => Courier::count(),
            'active'   => Courier::where('is_active', true)->count(),
            'inactive' => Courier::where('is_active', false)->count(),
            'services' => CourierService::where('is_active', true)->count(),
        ];

        return view('couriers.index', compact('couriers', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'code'        => 'required|string|max:20|unique:couriers,code|alpha_dash',
            'description' => 'nullable|string|max:255',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:512',
        ]);

        $data = [
            'name'        => $request->name,
            'code'        => strtolower($request->code),
            'description' => $request->description,
            'is_active'   => true,
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('couriers', 'public');
        }

        Courier::create($data);

        return redirect()->route('admin.couriers')->with('success', 'Kurir ' . $request->name . ' berhasil ditambahkan.');
    }

    public function update(Request $request, Courier $courier)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'code'        => 'required|string|max:20|alpha_dash|unique:couriers,code,' . $courier->id,
            'description' => 'nullable|string|max:255',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:512',
        ]);

        $data = [
            'name'        => $request->name,
            'code'        => strtolower($request->code),
            'description' => $request->description,
        ];

        if ($request->hasFile('logo')) {
            if ($courier->logo) {
                Storage::disk('public')->delete($courier->logo);
            }
            $data['logo'] = $request->file('logo')->store('couriers', 'public');
        }

        $courier->update($data);

        return redirect()->route('admin.couriers')->with('success', 'Kurir ' . $courier->name . ' berhasil diperbarui.');
    }

    public function destroy(Courier $courier)
    {
        $courier->update(['is_active' => false]);

        return redirect()->route('admin.couriers')->with('success', 'Kurir ' . $courier->name . ' berhasil dinonaktifkan.');
    }

    public function toggleActive(Courier $courier)
    {
        $courier->update(['is_active' => !$courier->is_active]);

        $msg = $courier->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.couriers')->with('success', 'Kurir ' . $courier->name . ' berhasil ' . $msg . '.');
    }

    // --- Courier Services ---

    public function storeService(Request $request, Courier $courier)
    {
        $request->validate([
            'name'           => 'required|string|max:100',
            'code'           => 'required|string|max:20|alpha_dash',
            'estimated_days' => 'nullable|string|max:30',
        ]);

        $courier->services()->create([
            'name'           => $request->name,
            'code'           => strtoupper($request->code),
            'estimated_days' => $request->estimated_days,
            'is_active'      => true,
        ]);

        return redirect()->route('admin.couriers')->with('success', 'Layanan ' . $request->name . ' berhasil ditambahkan ke ' . $courier->name . '.');
    }

    public function destroyService(CourierService $service)
    {
        $service->update(['is_active' => false]);

        return redirect()->route('admin.couriers')->with('success', 'Layanan ' . $service->name . ' berhasil dinonaktifkan.');
    }

    public function toggleService(CourierService $service)
    {
        $service->update(['is_active' => !$service->is_active]);

        $msg = $service->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.couriers')->with('success', 'Layanan ' . $service->name . ' berhasil ' . $msg . '.');
    }
}
