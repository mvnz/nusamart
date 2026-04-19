<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuliner extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'gambar',
        'alamat',
        'jam_buka',
        'jam_tutup',
        'kontak_wa',
        'kategori',
        'link_maps',
        'status',
    ];
}
