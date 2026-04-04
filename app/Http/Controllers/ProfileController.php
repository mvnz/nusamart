<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        return redirect()->route('profile.biodata');
    }

    public function showBiodata()
    {
        return view('profile-biodata');
    }

    public function updateBiodata(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone'          => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'tanggal_lahir'  => ['required', 'date', 'before:today'],
            'jenis_kelamin'  => ['required', 'in:L,P'],
            'alamat'         => ['required', 'string', 'max:500'],
            'province_code'  => ['required', 'string', 'size:2'],
            'regency_code'   => ['required', 'string', 'size:4'],
            'district_code'  => ['required', 'string', 'size:6'],
            'village_code'   => ['required', 'string', 'size:10'],
            'propinsi'       => ['required', 'string', 'max:255'],
            'kota'           => ['required', 'string', 'max:255'],
            'kecamatan'      => ['required', 'string', 'max:255'],
            'kelurahan'      => ['required', 'string', 'max:255'],
            'rt'             => ['required', 'string', 'max:5'],
            'rw'             => ['required', 'string', 'max:5'],
            'kodepos'        => ['required', 'digits:5'],
        ], [
            'province_code.required' => 'Provinsi wajib dipilih.',
            'regency_code.required'  => 'Kota/Kabupaten wajib dipilih.',
            'district_code.required' => 'Kecamatan wajib dipilih.',
            'village_code.required'  => 'Kelurahan/Desa wajib dipilih.',
            'rt.required'            => 'RT wajib diisi.',
            'rw.required'            => 'RW wajib diisi.',
            'kodepos.required'       => 'Kode Pos wajib diisi.',
            'kodepos.digits'         => 'Kode Pos harus tepat 5 digit angka.',
        ]);

        $user->update($validated);

        return redirect()->route('profile.biodata')->with('success', 'Biodata berhasil diperbarui.');
    }

    public function showAlamat()
    {
        return view('profile-alamat');
    }

    public function updateAlamat(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'alamat'          => ['required', 'string', 'max:500'],
            'province_code'   => ['required', 'string', 'size:2'],
            'regency_code'    => ['required', 'string', 'size:4'],
            'district_code'   => ['required', 'string', 'size:6'],
            'village_code'    => ['required', 'string', 'size:10'],
            'propinsi'        => ['required', 'string', 'max:255'],
            'kota'            => ['required', 'string', 'max:255'],
            'kecamatan'       => ['required', 'string', 'max:255'],
            'kelurahan'       => ['required', 'string', 'max:255'],
            'rt'              => ['required', 'string', 'max:5'],
            'rw'              => ['required', 'string', 'max:5'],
            'kodepos'         => ['required', 'digits:5'],
        ], [
            'province_code.required'  => 'Provinsi wajib dipilih.',
            'regency_code.required'   => 'Kota/Kabupaten wajib dipilih.',
            'district_code.required'  => 'Kecamatan wajib dipilih.',
            'village_code.required'   => 'Kelurahan/Desa wajib dipilih.',
            'rt.required'             => 'RT wajib diisi.',
            'rw.required'             => 'RW wajib diisi.',
            'kodepos.required'        => 'Kode Pos wajib diisi.',
            'kodepos.digits'          => 'Kode Pos harus tepat 5 digit angka.',
        ]);

        $user->update($validated);

        return redirect()->route('profile.alamat')->with('success', 'Alamat berhasil diperbarui.');
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
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
        ], [
            'province_code.required' => 'Provinsi wajib dipilih.',
            'regency_code.required' => 'Kota/Kabupaten wajib dipilih.',
            'district_code.required' => 'Kecamatan wajib dipilih.',
            'village_code.required' => 'Kelurahan/Desa wajib dipilih.',
            'rt.required' => 'RT wajib diisi.',
            'rw.required' => 'RW wajib diisi.',
            'kodepos.required' => 'Kode Pos wajib diisi.',
            'kodepos.digits' => 'Kode Pos harus tepat 5 digit angka.',
        ]);

        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        $webRoot = $_SERVER['DOCUMENT_ROOT'] ?? public_path();

        if ($user->photo) {
            $oldPath = $webRoot . '/uploads/' . $user->photo;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $file = $request->file('photo');
        $filename = 'photos/' . uniqid() . '.' . $file->getClientOriginalExtension();
        $uploadDir = $webRoot . '/uploads/photos';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $file->move($uploadDir, basename($filename));
        $user->update(['photo' => $filename]);

        return redirect()->route('profile')->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function deletePhoto()
    {
        /** @var User $user */
        $user = Auth::user();

        $webRoot = $_SERVER['DOCUMENT_ROOT'] ?? public_path();

        if ($user->photo) {
            $oldPath = $webRoot . '/uploads/' . $user->photo;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $user->update(['photo' => null]);

        return redirect()->route('profile')->with('success', 'Foto profil berhasil dihapus.');
    }

    public function showChangePassword()
    {
        return view('profile-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).+$/'],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan karakter spesial.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('profile.password')->with('success', 'Password berhasil diubah.');
    }
}
