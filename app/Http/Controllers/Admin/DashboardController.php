<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Akomodasi;
use App\Models\Destinasi;
use App\Models\PenyediaDiving;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
{
    // DESTINASI
    $totalDestinasi = Destinasi::count();
    $destinasiUnggulan = Destinasi::where('unggulan', true)->count();

    // AKOMODASI
    $totalAkomodasi = Akomodasi::count();
    $akomodasiPublished = Akomodasi::where('is_published', true)->count();

    // DIVING
    $totalDiving = PenyediaDiving::count();
    $divingPublished = PenyediaDiving::where('is_published', true)->count();

    // USER
    $totalAdmin = User::where('role', 'admin')->count();
    $totalSuperAdmin = User::where('role', 'super_admin')->count();

    // 5 POST TERBARU (3 MODEL)
    $recentDestinasi = Destinasi::latest()->take(5)->get();
    $recentAkomodasi = Akomodasi::latest()->take(5)->get();
    $recentDiving = PenyediaDiving::latest()->take(5)->get();

    // GABUNG SEMUA → 5 TERBARU
    $recentAll = collect()
        ->merge($recentDestinasi)
        ->merge($recentAkomodasi)
        ->merge($recentDiving)
        ->sortByDesc('created_at')
        ->take(5);

    return view('admin.dashboard.index', compact(
        'recentAll',
        'recentDestinasi',
        'recentAkomodasi',
        'recentDiving',
        'totalDestinasi',
        'destinasiUnggulan',
        'totalAkomodasi',
        'akomodasiPublished',
        'totalDiving',
        'divingPublished',
        'totalAdmin',
        'totalSuperAdmin'
    ));

}

}
