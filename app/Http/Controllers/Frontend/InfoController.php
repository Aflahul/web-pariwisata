<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\InformasiDaerah;

class InfoController extends Controller
{
    public function index()
    {
        // Data hanya 1 record
        $info = InformasiDaerah::first();

        return view('frontend.info.index', compact('info'));
    }
}
