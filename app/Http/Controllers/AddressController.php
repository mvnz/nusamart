<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->addresses()->orderByDesc('is_primary')->latest()->get();
        return view('profile-alamat', compact('addresses'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $this->validateAddress($request);
        $validated['user_id']    = $user->id;
        $validated['is_primary'] = $user->addresses()->count() === 0;

        $address = UserAddress::create($validated);

        if ($address->is_primary) {
            $this->syncToUser($user, $address);
        }

        return redirect()->route('profile.alamat')->with('success', 'Alamat berhasil ditambahkan.');
    }

    public function update(Request $request, UserAddress $address)
    {
        abort_if((int)$address->user_id !== (int)Auth::id(), 403);

        $validated = $this->validateAddress($request);
        $address->update($validated);

        if ($address->is_primary) {
            $this->syncToUser(Auth::user(), $address);
        }

        return redirect()->route('profile.alamat')->with('success', 'Alamat berhasil diperbarui.');
    }

    public function destroy(UserAddress $address)
    {
        abort_if((int)$address->user_id !== (int)Auth::id(), 403);
        abort_if($address->is_primary, 422, 'Tidak bisa menghapus alamat utama. Jadikan alamat lain sebagai utama terlebih dahulu.');

        $address->delete();

        return redirect()->route('profile.alamat')->with('success', 'Alamat berhasil dihapus.');
    }

    public function setPrimary(UserAddress $address)
    {
        abort_if((int)$address->user_id !== (int)Auth::id(), 403);

        /** @var User $user */
        $user = Auth::user();
        $user->addresses()->update(['is_primary' => false]);
        $address->update(['is_primary' => true]);
        $this->syncToUser($user, $address);

        return redirect()->route('profile.alamat')->with('success', 'Alamat utama berhasil diubah.');
    }

    private function validateAddress(Request $request): array
    {
        return $request->validate([
            'label'          => ['required', 'string', 'max:100'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone'          => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'alamat'         => ['required', 'string', 'max:500'],
            'province_code'  => ['required', 'string', 'size:2'],
            'regency_code'   => ['required', 'string', 'size:4'],
            'district_code'  => ['required', 'string', 'max:8'],
            'village_code'   => ['required', 'string', 'size:10'],
            'propinsi'       => ['required', 'string', 'max:255'],
            'kota'           => ['required', 'string', 'max:255'],
            'kecamatan'      => ['required', 'string', 'max:255'],
            'kelurahan'      => ['required', 'string', 'max:255'],
            'rt'             => ['required', 'string', 'max:5'],
            'rw'             => ['required', 'string', 'max:5'],
            'kodepos'        => ['required', 'digits:5'],
        ], [
            'label.required'          => 'Label alamat wajib diisi.',
            'recipient_name.required' => 'Nama penerima wajib diisi.',
            'phone.required'          => 'Nomor HP wajib diisi.',
            'province_code.required'  => 'Provinsi wajib dipilih.',
            'regency_code.required'   => 'Kota/Kabupaten wajib dipilih.',
            'district_code.required'  => 'Kecamatan wajib dipilih.',
            'village_code.required'   => 'Kelurahan/Desa wajib dipilih.',
            'rt.required'             => 'RT wajib diisi.',
            'rw.required'             => 'RW wajib diisi.',
            'kodepos.required'        => 'Kode Pos wajib diisi.',
            'kodepos.digits'          => 'Kode Pos harus tepat 5 digit angka.',
        ]);
    }

    private function syncToUser(User $user, UserAddress $address): void
    {
        $user->update([
            'alamat'        => $address->alamat,
            'province_code' => $address->province_code,
            'regency_code'  => $address->regency_code,
            'district_code' => $address->district_code,
            'village_code'  => $address->village_code,
            'propinsi'      => $address->propinsi,
            'kota'          => $address->kota,
            'kecamatan'     => $address->kecamatan,
            'kelurahan'     => $address->kelurahan,
            'rt'            => $address->rt,
            'rw'            => $address->rw,
            'kodepos'       => $address->kodepos,
        ]);
    }
}
