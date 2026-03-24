<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserManagementController extends Controller
{
    public function index()
    {
        $users        = User::latest()->get();
        $totalUsers   = $users->count();
        $totalBuyers  = $users->where('role', 'pembeli')->count();
        $totalSellers = $users->where('role', 'penjual')->count();
        $totalAdmins  = $users->where('role', 'admin')->count();

        return view('user.index', compact('users', 'totalUsers', 'totalBuyers', 'totalSellers', 'totalAdmins'));
    }

    public function toggleActive(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Tidak bisa menonaktifkan akun sendiri.');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.users')->with('success', "Pengguna berhasil {$status}.");
    }
}
