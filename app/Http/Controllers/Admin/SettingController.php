<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()
            ->mapWithKeys(function ($item) {
                return [$item->key => $item->value];
            })
            ->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    // update method
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name'        => 'required|string|max:255',
            'site_logo'        => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:5048',
            'contact_email'    => 'required|email',
            'contact_phone'    => 'nullable|string|max:50',
            'contact_address'  => 'nullable|string',
            'privacy_policy'   => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'about_us'         => 'nullable|string',
        ], [
            'site_logo.max' => 'Logo file size must not exceed 5 MB.',
            'site_logo.mimes' => 'Logo must be PNG, JPG, GIF or SVG format.',
        ]);

        // Site logo upload
        if ($request->hasFile('site_logo')) {
            $file = $request->file('site_logo');
            if ($file->getClientOriginalExtension() === 'svg' && $file->getMimeType() !== 'image/svg+xml') {
                return back()->withErrors(['site_logo' => 'Invalid SVG file detected.']);
            }

            // Delete old logo
            $oldLogo = SiteSetting::where('key', 'site_logo')->value('value');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            $logoPath = $file->store('site-logos', 'public');
            SiteSetting::setValue('site_logo', $logoPath);
        }

        foreach ($validated as $key => $value) {
            if ($key !== 'site_logo') {
                SiteSetting::setValue($key, $value);
            }
        }

        // normal redirect + flash
        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    /* =========================
       Delete Logo
    ========================== */
    public function deleteLogo(Request $request)
    {
        $setting = SiteSetting::where('key', 'site_logo')->first();

        if (!$setting || !$setting->value) {
            return redirect()->back()->with('error', 'No logo found.');
        }

        if (Storage::disk('public')->exists($setting->value)) {
            Storage::disk('public')->delete($setting->value);
        }

        $setting->value = null;
        $setting->save();

        return redirect()->back()->with('success', 'Logo deleted successfully.');
    }
}
