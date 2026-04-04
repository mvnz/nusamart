<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'alamat' => ['required', 'string', 'max:500'],
            'province_code' => ['required', 'string', 'size:2'],
            'regency_code' => ['required', 'string', 'size:4'],
            'district_code' => ['required', 'string', 'size:6'],
            'village_code' => ['required', 'string', 'size:10'],
            'propinsi' => ['required', 'string', 'max:255'],
            'kota' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'rt' => ['required', 'string', 'max:5'],
            'rw' => ['required', 'string', 'max:5'],
            'kodepos' => ['required', 'digits:5'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).+$/'],
            'role' => ['nullable', 'in:penjual,pembeli'],
        ], [
            'province_code.required'  => 'Provinsi wajib dipilih.',
            'regency_code.required'   => 'Kota/Kabupaten wajib dipilih.',
            'district_code.required'  => 'Kecamatan wajib dipilih.',
            'village_code.required'   => 'Kelurahan/Desa wajib dipilih.',
            'rt.required'             => 'RT wajib diisi.',
            'rw.required'             => 'RW wajib diisi.',
            'kodepos.required'        => 'Kode Pos wajib diisi.',
            'kodepos.digits'          => 'Kode Pos harus tepat 5 digit angka.',
            'tanggal_lahir.required'  => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'      => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before'    => 'Tanggal lahir harus sebelum hari ini.',
            'jenis_kelamin.required'  => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'        => 'Jenis kelamin tidak valid.',
            'password.min'            => 'Password minimal 8 karakter.',
            'password.regex'          => 'Password harus mengandung huruf besar, huruf kecil, dan karakter spesial.',
            'password.confirmed'      => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'phone' => $validated['phone'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'alamat' => $validated['alamat'],
            'kota' => $validated['kota'],
            'propinsi' => $validated['propinsi'],
            'kecamatan' => $validated['kecamatan'],
            'kelurahan' => $validated['kelurahan'],
            'rt' => $validated['rt'],
            'rw' => $validated['rw'],
            'kodepos' => $validated['kodepos'],
            'province_code' => $validated['province_code'],
            'regency_code' => $validated['regency_code'],
            'district_code' => $validated['district_code'],
            'village_code' => $validated['village_code'],
            'role' => $validated['role'] ?? 'pembeli',
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));

        // Buat alamat utama otomatis dari data registrasi
        UserAddress::create([
            'user_id'        => $user->id,
            'label'          => 'Rumah',
            'recipient_name' => $user->name,
            'phone'          => $user->phone,
            'alamat'         => $validated['alamat'],
            'province_code'  => $validated['province_code'],
            'regency_code'   => $validated['regency_code'],
            'district_code'  => $validated['district_code'],
            'village_code'   => $validated['village_code'],
            'propinsi'       => $validated['propinsi'],
            'kota'           => $validated['kota'],
            'kecamatan'      => $validated['kecamatan'],
            'kelurahan'      => $validated['kelurahan'],
            'rt'             => $validated['rt'],
            'rw'             => $validated['rw'],
            'kodepos'        => $validated['kodepos'],
            'is_primary'     => true,
        ]);

        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}
