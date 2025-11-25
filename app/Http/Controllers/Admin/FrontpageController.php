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
    /**
     * Tampilkan halaman pengaturan frontpage.
     */
    public function index()
    {
        $settings = FrontpageSetting::first() ?? new FrontpageSetting();

        // Decode slider agar tidak error di view
        $settings->slider = $settings->slider ? json_decode($settings->slider, true) : [];

        // Ambil destinasi untuk pilihan slider
        // PERBAIKAN: kolom adalah "nama", bukan "name"
        $destinasi = Destinasi::orderBy('nama')->get();

        return view('admin.web.frontpage.index', compact('settings', 'destinasi'));
    }

    /**
     * Update pengaturan frontpage (aman level produksi)
     */
    public function update(Request $request)
    {
        $settings = FrontpageSetting::first() ?? new FrontpageSetting();

        // VALIDASI
        $data = $request->validate([
            // HERO
            'hero_title'    => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string',
            'hero_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4048',

            // WELCOME
            'welcome_title' => 'nullable|string|max:255',
            'welcome_text'  => 'nullable|string',
            'welcome_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            // GUIDE
            'guide1_title'  => 'nullable|string|max:255',
            'guide1_text'   => 'nullable|string',
            'guide2_title'  => 'nullable|string|max:255',
            'guide2_text'   => 'nullable|string',
            'guide3_title'  => 'nullable|string|max:255',
            'guide3_text'   => 'nullable|string',

            // SLIDER
            'slider'        => 'nullable|array',

            // CONTACT
            'contact_address' => 'nullable|string|max:255',
            'contact_phone'   => 'nullable|string|max:255',
            'contact_email'   => 'nullable|string|max:255',

            // BRANDING
            'logo'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'favicon' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        /* -----------------------------------------------------------
         | HERO IMAGE
         ----------------------------------------------------------- */
        if ($request->hasFile('hero_image')) {

            $file = $request->file('hero_image');

            // Signature validation
            if (!SafeUpload::isRealImage($file)) {
                return back()->withErrors(['hero_image' => 'File tidak valid atau berbahaya.']);
            }

            // Hapus file lama
            if ($settings->hero_image) {
                $old = 'uploads/frontpage/' . basename($settings->hero_image);
                Storage::disk('public')->delete($old);
            }

            // Upload aman
            $data['hero_image'] = SafeUpload::upload($file, 'uploads/frontpage');
        }

        /* -----------------------------------------------------------
         | WELCOME IMAGE
         ----------------------------------------------------------- */
        if ($request->hasFile('welcome_image')) {

            $file = $request->file('welcome_image');

            if (!SafeUpload::isRealImage($file)) {
                return back()->withErrors(['welcome_image' => 'File tidak valid atau berbahaya.']);
            }

            if ($settings->welcome_image) {
                $old = 'uploads/frontpage/' . basename($settings->welcome_image);
                Storage::disk('public')->delete($old);
            }

            $data['welcome_image'] = SafeUpload::upload($file, 'uploads/frontpage');
        }

        /* -----------------------------------------------------------
         | LOGO UPLOAD AMAN
         ----------------------------------------------------------- */
        if ($request->hasFile('logo')) {

            $file = $request->file('logo');

            if (!SafeUpload::isRealImage($file)) {
                return back()->withErrors(['logo' => 'Logo tidak valid atau berbahaya.']);
            }

            if ($settings->logo) {
                $old = 'uploads/frontpage/' . basename($settings->logo);
                Storage::disk('public')->delete($old);
            }

            $data['logo'] = SafeUpload::upload($file, 'uploads/frontpage');
        }

        /* -----------------------------------------------------------
         | FAVICON UPLOAD AMAN
         ----------------------------------------------------------- */
        if ($request->hasFile('favicon')) {

            $file = $request->file('favicon');

            if (!SafeUpload::isRealImage($file)) {
                return back()->withErrors(['favicon' => 'Favicon tidak valid atau berbahaya.']);
            }

            if ($settings->favicon) {
                $old = 'uploads/frontpage/' . basename($settings->favicon);
                Storage::disk('public')->delete($old);
            }

            $data['favicon'] = SafeUpload::upload($file, 'uploads/frontpage');
        }

        /* -----------------------------------------------------------
         | SLIDER (Array ID destinasi → JSON)
         ----------------------------------------------------------- */
        if (isset($data['slider'])) {
            $data['slider'] = json_encode($data['slider']);
        }

        /* -----------------------------------------------------------
         | SIMPAN SEMUA
         ----------------------------------------------------------- */
        $settings->fill($data);
        $settings->save();

        return back()->with('success', 'Pengaturan halaman depan berhasil disimpan.');
    }
}
