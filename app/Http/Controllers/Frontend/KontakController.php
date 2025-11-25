<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\KontakResmi;

class KontakController extends Controller
{
    public function index()
    {
        // Data hanya satu record
        $kontak = KontakResmi::first();

        return view('frontend.kontak.index', compact('kontak'));
    }
}
