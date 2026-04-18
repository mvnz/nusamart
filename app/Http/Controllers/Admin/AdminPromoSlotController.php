<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoSlot;
use Illuminate\Http\Request;

class AdminPromoSlotController extends Controller
{
    public function index()
    {
        $slots = PromoSlot::orderBy('sort_order')->orderBy('start_time')->get();
        return view('admin.promo-slots.index', compact('slots'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        PromoSlot::create([
            'name'       => $data['name'],
            'start_time' => $data['start_time'] . ':00',
            'end_time'   => $data['end_time'] . ':00',
            'is_active'  => true,
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.promo-slots')->with('success', 'Jadwal "' . $data['name'] . '" berhasil ditambahkan.');
    }

    public function update(Request $request, PromoSlot $promoSlot)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $promoSlot->update([
            'name'       => $data['name'],
            'start_time' => $data['start_time'] . ':00',
            'end_time'   => $data['end_time'] . ':00',
            'sort_order' => $data['sort_order'] ?? $promoSlot->sort_order,
        ]);

        return redirect()->route('admin.promo-slots')->with('success', 'Jadwal "' . $promoSlot->name . '" berhasil diperbarui.');
    }

    public function destroy(PromoSlot $promoSlot)
    {
        $name = $promoSlot->name;
        $promoSlot->delete();
        return redirect()->route('admin.promo-slots')->with('success', 'Jadwal "' . $name . '" berhasil dihapus.');
    }

    public function toggleActive(PromoSlot $promoSlot)
    {
        $promoSlot->update(['is_active' => !$promoSlot->is_active]);
        $msg = $promoSlot->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.promo-slots')->with('success', 'Jadwal "' . $promoSlot->name . '" berhasil ' . $msg . '.');
    }
}
