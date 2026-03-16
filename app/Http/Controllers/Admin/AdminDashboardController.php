<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $totalUsers = User::count();
            $totalSellers = User::where('role', 'penjual')->count();
            $totalBuyers = User::where('role', 'pembeli')->count();
            $totalAdmins = User::where('role', 'admin')->count();
            $recentUsers = User::latest()->take(5)->get();

            return view('dashboard', compact(
                'totalUsers', 'totalSellers', 'totalBuyers', 'totalAdmins', 'recentUsers'
            ));
        }

        return view('dashboard');
    }
}
