<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FrontpageSetting;
use App\Models\Destinasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\SafeUpload;

class FrontpageController extends Controller
{
    public function index()
    {
        $settings = FrontpageSetting::first() ?? new FrontpageSetting();
        $settings->slider = $settings->slider ? json_decode($settings->slider, true) : [];

        $destinasi = Destinasi::orderBy('nama')->get();

        return view('admin.web.frontpage.index', compact('settings', 'destinasi'));
    }

    public function update(Request $request)
{
    $settings = FrontpageSetting::first() ?? new FrontpageSetting();

    $data = $request->validate([
        'hero_title'    => 'nullable|string|max:255',
        'hero_subtitle' => 'nullable|string',
        'hero_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

        'welcome_title' => 'nullable|string|max:255',
        'welcome_text'  => 'nullable|string',
        'welcome_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',

        'guide1_title'  => 'nullable|string|max:255',
        'guide1_text'   => 'nullable|string',
        'guide2_title'  => 'nullable|string|max:255',
        'guide2_text'   => 'nullable|string',
        'guide3_title'  => 'nullable|string|max:255',
        'guide3_text'   => 'nullable|string',

        'slider'        => 'nullable|array|max:3',

        'contact_address' => 'nullable|string|max:255',
        'contact_phone'   => 'nullable|string|max:255',
        'contact_email'   => 'nullable|string|max:255',

        'logo'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        'favicon' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
    ]);


    /* -----------------------------------------------------------
     | HERO — NO RESIZE, NO OPTIMIZE (4MB)
     ----------------------------------------------------------- */
    if ($request->hasFile('hero_image')) {

        $file = $request->file('hero_image');

        if (!SafeUpload::isRealImage($file)) {
            return back()->withErrors(['hero_image' => 'File tidak valid atau berbahaya.']);
        }

        if ($settings->hero_image && Storage::disk('public')->exists($settings->hero_image)) {
            Storage::disk('public')->delete($settings->hero_image);
        }

        $data['hero_image'] = SafeUpload::upload(
            file: $file,
            folder: 'uploads/frontpage',
            resize: false,
            optimize: false,
            isHero: true
        );
    }


    /* -----------------------------------------------------------
     | WELCOME IMAGE — RESIZE + OPTIMIZE
     ----------------------------------------------------------- */
    if ($request->hasFile('welcome_image')) {

        $file = $request->file('welcome_image');

        if (!SafeUpload::isRealImage($file)) {
            return back()->withErrors(['welcome_image' => 'File tidak valid atau berbahaya.']);
        }

        if ($settings->welcome_image && Storage::disk('public')->exists($settings->welcome_image)) {
            Storage::disk('public')->delete($settings->welcome_image);
        }

        $data['welcome_image'] = SafeUpload::upload(
            file: $file,
            folder: 'uploads/frontpage',
            resize: true,
            optimize: true,
            maxWidth: 1600,
            quality: 85
        );
    }


    /* -----------------------------------------------------------
     | LOGO — NO RESIZE, NO OPTIMIZE
     ----------------------------------------------------------- */
    if ($request->hasFile('logo')) {

        $file = $request->file('logo');

        if (!SafeUpload::isRealImage($file)) {
            return back()->withErrors(['logo' => 'Logo tidak valid atau berbahaya.']);
        }

        if ($settings->logo && Storage::disk('public')->exists($settings->logo)) {
            Storage::disk('public')->delete($settings->logo);
        }

        $data['logo'] = SafeUpload::upload(
            file: $file,
            folder: 'uploads/frontpage',
            resize: false,
            optimize: false
        );
    }


    /* -----------------------------------------------------------
     | FAVICON — NO RESIZE, NO OPTIMIZE
     ----------------------------------------------------------- */
    if ($request->hasFile('favicon')) {

        $file = $request->file('favicon');

        if (!SafeUpload::isRealImage($file)) {
            return back()->withErrors(['favicon' => 'Favicon tidak valid atau berbahaya.']);
        }

        if ($settings->favicon && Storage::disk('public')->exists($settings->favicon)) {
            Storage::disk('public')->delete($settings->favicon);
        }

        $data['favicon'] = SafeUpload::upload(
            file: $file,
            folder: 'uploads/frontpage',
            resize: false,
            optimize: false
        );
    }


    /* -----------------------------------------------------------
     | SLIDER
     ----------------------------------------------------------- */
    if (isset($data['slider'])) {
        $data['slider'] = json_encode($data['slider']);
    }

    $settings->fill($data);
    $settings->save();

    return back()->with('success', 'Pengaturan halaman depan berhasil disimpan.');
}
}