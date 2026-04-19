<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminVoucherController extends Controller
{
    public function index(Request $request)
    {
        $query = Voucher::latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('code', 'like', '%' . $request->search . '%')
                  ->orWhere('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $now = now();
            match ($request->status) {
                'active'     => $query->where('is_active', true)
                                      ->where(fn($q) => $q->whereNull('start_date')->orWhere('start_date', '<=', $now))
                                      ->where(fn($q) => $q->whereNull('end_date')->orWhere('end_date', '>=', $now)),
                'scheduled'  => $query->where('start_date', '>', $now),
                'expired'    => $query->where('end_date', '<', $now),
                'inactive'   => $query->where('is_active', false),
                default      => null,
            };
        }

        $vouchers = $query->paginate(20)->withQueryString();

        $stats = [
            'total'     => Voucher::count(),
            'active'    => Voucher::where('is_active', true)
                            ->where(fn($q) => $q->whereNull('start_date')->orWhere('start_date', '<=', now()))
                            ->where(fn($q) => $q->whereNull('end_date')->orWhere('end_date', '>=', now()))
                            ->count(),
            'scheduled' => Voucher::where('start_date', '>', now())->count(),
            'expired'   => Voucher::where('end_date', '<', now())->count(),
        ];

        return view('admin.vouchers.index', compact('vouchers', 'stats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'           => 'required|string|max:50|unique:vouchers,code|alpha_dash',
            'name'           => 'required|string|max:150',
            'description'    => 'nullable|string|max:500',
            'discount_type'  => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'max_discount'   => 'nullable|numeric|min:0',
            'min_purchase'   => 'nullable|numeric|min:0',
            'quota'          => 'nullable|integer|min:0',
            'start_date'     => 'nullable|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
        ]);

        // Validate percentage <= 100
        if ($data['discount_type'] === 'percentage' && $data['discount_value'] > 100) {
            return back()->withErrors(['discount_value' => 'Diskon persentase tidak boleh lebih dari 100%'])->withInput();
        }

        $data['code']         = strtoupper($data['code']);
        $data['min_purchase'] = $data['min_purchase'] ?? 0;
        $data['quota']        = $data['quota'] ?? 0;
        $data['is_active']    = true;

        Voucher::create($data);

        return redirect()->route('admin.vouchers')->with('success', 'Voucher "' . $data['code'] . '" berhasil dibuat.');
    }

    public function update(Request $request, Voucher $voucher)
    {
        $data = $request->validate([
            'code'           => ['required','string','max:50','alpha_dash', Rule::unique('vouchers','code')->ignore($voucher->id)],
            'name'           => 'required|string|max:150',
            'description'    => 'nullable|string|max:500',
            'discount_type'  => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'max_discount'   => 'nullable|numeric|min:0',
            'min_purchase'   => 'nullable|numeric|min:0',
            'quota'          => 'nullable|integer|min:0',
            'start_date'     => 'nullable|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($data['discount_type'] === 'percentage' && $data['discount_value'] > 100) {
            return back()->withErrors(['discount_value' => 'Diskon persentase tidak boleh lebih dari 100%'])->withInput();
        }

        $data['code']         = strtoupper($data['code']);
        $data['min_purchase'] = $data['min_purchase'] ?? 0;
        $data['quota']        = $data['quota'] ?? 0;

        $voucher->update($data);

        return redirect()->route('admin.vouchers')->with('success', 'Voucher "' . $voucher->code . '" berhasil diperbarui.');
    }

    public function toggleActive(Voucher $voucher)
    {
        $voucher->update(['is_active' => !$voucher->is_active]);
        $msg = $voucher->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.vouchers')->with('success', 'Voucher "' . $voucher->code . '" berhasil ' . $msg . '.');
    }

    public function destroy(Voucher $voucher)
    {
        $code = $voucher->code;
        $voucher->delete();
        return redirect()->route('admin.vouchers')->with('success', 'Voucher "' . $code . '" berhasil dihapus.');
    }
}
