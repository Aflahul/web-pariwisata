<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Culture;

class CultureController extends Controller
{
    public function index()
    {
        $data = Culture::where('status', 1)
            ->orderBy('id', 'desc')
            ->paginate(9);

        return view('frontend.budaya.index', compact('data'));
    }

    public function show($slug)
    {
        $budaya = Culture::where('status', 1)
            ->where('slug', $slug)
            ->firstOrFail();

        return view('frontend.budaya.show', compact('budaya'));
    }
}
