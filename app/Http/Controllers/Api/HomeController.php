<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function getHomePage(Request $request)
    {
        $setting = Setting::where('key', 'footer')->first();

        $data = $setting ? json_decode($setting->value, true) : [];

        if (isset($data['logo'])) {
            $data['banner_image'] = asset($data['banner_image']);
            $data['logo'] = asset($data['logo']);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'footer' => $data,
            ]
        ]);
    }

    public function updateFooter(Request $request)
    {
        $request->validate([
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:5120', // 5MB
            'logo' => 'required|image|mimes:svg,png,jpg,jpeg,svg|max:2048',
        ]);

        $data = [
            'description' => "Prosoft is a specialized value-added distributor with 30+ years of experience in the enterprise IT space. We partner with global technology vendors to bring their solutions to market through our network of trusted experts.",
            'linkedin_url' => "https://www.linkedin.com/company/prosoft-infomation-systems/",
        ];

        $bannerImagePath = $request->file('banner_image')->store('footer', 'public');
        $bannerImageUrl = Storage::url($bannerImagePath);
        $logoPath = $request->file('logo')->store('footer', 'public');
        $logoUrl = Storage::url($logoPath);
        $data['banner_image'] = $bannerImageUrl;
        $data['logo'] = $logoUrl;

        Setting::updateOrCreate(
            ['key' => 'footer'],
            ['value' => json_encode($data)]
        );

        return response()->json(['success' => true]);
    }
}
