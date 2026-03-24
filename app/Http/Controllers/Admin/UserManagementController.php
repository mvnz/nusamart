<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role   = $request->input('role');

        $query = User::latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        if ($role) {
            $query->where('role', $role);
        }

        $users       = $query->paginate(10)->appends($request->query());
        $totalUsers   = User::count();
        $totalBuyers  = User::where('role', 'pembeli')->count();
        $totalSellers = User::where('role', 'penjual')->count();
        $totalAdmins  = User::where('role', 'admin')->count();

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
