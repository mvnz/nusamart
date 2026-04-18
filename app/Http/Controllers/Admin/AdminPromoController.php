<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPromoController extends Controller
{
    /**
     * Tampilkan daftar semua promo (monitoring)
     */
    public function index(Request $request)
    {
        $query = Promo::with(['product', 'seller'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->whereHas('product', fn($q) => 
                $q->where('name', 'like', '%' . $request->search . '%')
            )->orWhereHas('seller', fn($q) =>
                $q->where('name', 'like', '%' . $request->search . '%')
            );
        }

        if ($request->filled('seller_id')) {
            $query->where('user_id', $request->seller_id);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
            } elseif ($request->status === 'scheduled') {
                $query->where('start_date', '>', now());
            } elseif ($request->status === 'expired') {
                $query->where('end_date', '<', now());
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $promos = $query->paginate(20);
        $sellers = User::where('role', 'penjual')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.promos.index', compact('promos', 'sellers'));
    }

    /**
     * Lihat detail promo
     */
    public function show(Promo $promo)
    {
        $promo->load(['product', 'seller']);
        
        return view('admin.promos.show', compact('promo'));
    }

    /**
     * Nonaktifkan promo (admin action)
     */
    public function deactivate(Request $request, Promo $promo)
    {
        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $promo->deactivate();

        return back()->with('success', 'Promo berhasil dinonaktifkan oleh admin');
    }

    /**
     * Aktifkan promo kembali (admin action)
     */
    public function activate(Promo $promo)
    {
        $promo->activate();

        return back()->with('success', 'Promo berhasil diaktifkan kembali');
    }

    /**
     * Hapus promo (admin action)
     */
    public function destroy(Request $request, Promo $promo)
    {
        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $productName = $promo->product->name;
        $promo->delete();

        return redirect()->route('admin.promos')
            ->with('success', "Promo '{$productName}' berhasil dihapus");
    }

    /**
     * Get promo stats untuk dashboard
     */
    public static function getStats()
    {
        return [
            'active' => Promo::where('is_active', true)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->count(),
            'scheduled' => Promo::where('start_date', '>', now())->count(),
            'expired' => Promo::where('end_date', '<', now())->count(),
            'inactive' => Promo::where('is_active', false)->count(),
        ];
    }
}
