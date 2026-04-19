<?php

namespace App\Http\Controllers;

use App\Models\Kuliner;

class KulinerController extends Controller
{
    public function index()
    {
        $kuliners = Kuliner::latest()->get();
        return view('kuliner.index', compact('kuliners'));
    }

    public function show($id)
    {
        $kuliner = Kuliner::findOrFail($id);
        return view('kuliner.show', compact('kuliner'));
    }
}
