<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kuliner;
use Illuminate\Http\Request;

class KulinerController extends Controller
{
    public function index()
    {
        $kuliners = Kuliner::latest()->get();
        return view('kuliner.admin.index', compact('kuliners'));
    }

    public function create()
    {
        return view('kuliner.admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar'    => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'alamat'    => 'required|string',
            'jam_buka'  => 'required|string',
            'jam_tutup' => 'required|string',
            'kontak_wa' => 'required|string|max:20',
            'kategori'  => 'required|string|max:100',
            'link_maps' => 'nullable|url',
            'status'    => 'required|in:buka,tutup',
        ], [
            'gambar.required' => 'Foto warung wajib diupload.',
            'gambar.image'    => 'File harus berupa gambar.',
            'gambar.mimes'    => 'Format gambar harus jpg, jpeg, atau png.',
            'gambar.max'      => 'Ukuran gambar maksimal 2MB.',
            'link_maps.url'   => 'Link Google Maps harus berupa URL yang valid.',
        ]);

        $filename = $this->uploadGambar($request);

        Kuliner::create([
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'gambar'    => $filename,
            'alamat'    => $request->alamat,
            'jam_buka'  => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,
            'kontak_wa' => $request->kontak_wa,
            'kategori'  => $request->kategori,
            'link_maps' => $request->link_maps,
            'status'    => $request->status,
        ]);

        return redirect()->route('admin.kuliner.index')->with('success', 'Warung "' . $request->nama . '" berhasil ditambahkan.');
    }

    public function edit(Kuliner $kuliner)
    {
        return view('kuliner.admin.edit', compact('kuliner'));
    }

    public function update(Request $request, Kuliner $kuliner)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'alamat'    => 'required|string',
            'jam_buka'  => 'required|string',
            'jam_tutup' => 'required|string',
            'kontak_wa' => 'required|string|max:20',
            'kategori'  => 'required|string|max:100',
            'link_maps' => 'nullable|url',
            'status'    => 'required|in:buka,tutup',
        ], [
            'gambar.image'  => 'File harus berupa gambar.',
            'gambar.mimes'  => 'Format gambar harus jpg, jpeg, atau png.',
            'gambar.max'    => 'Ukuran gambar maksimal 2MB.',
            'link_maps.url' => 'Link Google Maps harus berupa URL yang valid.',
        ]);

        $data = [
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'alamat'    => $request->alamat,
            'jam_buka'  => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,
            'kontak_wa' => $request->kontak_wa,
            'kategori'  => $request->kategori,
            'link_maps' => $request->link_maps,
            'status'    => $request->status,
        ];

        if ($request->hasFile('gambar')) {
            $this->hapusGambar($kuliner->gambar);
            $data['gambar'] = $this->uploadGambar($request);
        }

        $kuliner->update($data);

        return redirect()->route('admin.kuliner.index')->with('success', 'Warung "' . $kuliner->nama . '" berhasil diperbarui.');
    }

    public function destroy(Kuliner $kuliner)
    {
        $nama = $kuliner->nama;
        $this->hapusGambar($kuliner->gambar);
        $kuliner->delete();

        return redirect()->route('admin.kuliner.index')->with('success', 'Warung "' . $nama . '" berhasil dihapus.');
    }

    private function uploadGambar(Request $request): string
    {
        $webRoot   = $_SERVER['DOCUMENT_ROOT'] ?? public_path();
        $file      = $request->file('gambar');
        $filename  = 'kuliner/' . uniqid() . '.' . $file->getClientOriginalExtension();
        $uploadDir = $webRoot . '/uploads/kuliner';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $file->move($uploadDir, basename($filename));

        return $filename;
    }

    private function hapusGambar(?string $gambar): void
    {
        if (!$gambar) return;

        $webRoot = $_SERVER['DOCUMENT_ROOT'] ?? public_path();
        $path    = $webRoot . '/uploads/' . $gambar;

        if (file_exists($path)) {
            unlink($path);
        }
    }
}
