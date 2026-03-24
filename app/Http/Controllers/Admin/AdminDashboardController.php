<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role === 'admin') {
            $totalUsers = User::count();
            $totalSellers = User::where('role', 'penjual')->count();
            $totalBuyers = User::where('role', 'pembeli')->count();
            $totalAdmins = User::where('role', 'admin')->count();
            $totalActive = User::where('is_active', true)->count();
            $totalInactive = User::where('is_active', false)->count();
            $newThisMonth = User::whereYear('created_at', now()->year)
                                ->whereMonth('created_at', now()->month)->count();
            $newThisWeek = User::where('created_at', '>=', now()->startOfWeek())->count();
            $recentUsers = User::latest()->take(5)->get();

            return view('dashboard', compact(
                'totalUsers', 'totalSellers', 'totalBuyers', 'totalAdmins',
                'totalActive', 'totalInactive', 'newThisMonth', 'newThisWeek',
                'recentUsers'
            ));
        }

        return view('dashboard');
    }
}
