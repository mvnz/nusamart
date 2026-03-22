<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function tentang()
    {
        return view('pages.tentang');
    }

    public function kontak()
    {
        return view('pages.kontak');
    }

    public function privasi()
    {
        return view('pages.privasi');
    }

    public function syarat()
    {
        return view('pages.syarat');
    }

    public function pengembalian()
    {
        return view('pages.pengembalian');
    }

    public function bantuan()
    {
        return view('pages.bantuan');
    }
}
