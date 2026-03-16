<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('user.index', compact('users'));
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus.');
    }
}
