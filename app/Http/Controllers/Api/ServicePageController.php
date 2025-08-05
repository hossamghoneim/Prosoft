<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceBannerSection;
use App\Models\ServiceHeroSection;
use App\Models\ServiceSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServicePageController extends Controller
{
    public function getFullPage()
    {
        $hero = ServiceHeroSection::where('is_active', true)->first();

        $sections = ServiceSection::with(['items' => function ($q) {
            $q->where('is_active', true)->orderBy('order');
        }])
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        $banner = ServiceBannerSection::where('is_active', true)->first();

        return response()->json([
            'success' => true,
            'data' => [
                'hero' => $hero,
                'sections' => $sections,
                'banner' => $banner
            ]
        ]);
    }

    public function seedTestData(Request $request)
    {
        // Validation
        $request->validate([
            'hero_video' => 'required|file|mimetypes:video/mp4,video/webm|max:102400', // 100MB
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',      // 5MB
            'icon1' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'icon2' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        // === Upload Hero Video ===
        $heroVideoPath = $request->file('hero_video')->store('hero-videos', 'public');
        $heroVideoUrl = Storage::url($heroVideoPath);

        $hero = ServiceHeroSection::create([
            'title' => 'Channel-First. Results-Driven',
            'description' => 'At Prosoft, our commitment goes beyond distribution. We empower our partners to grow.',
            'button_text' => 'Experience True Partnership Synergy',
            'button_url' => 'https://example.com/partners',
            'video_url' => $heroVideoUrl,
            'is_active' => true,
        ]);

        // === Upload Icons and Create Section + Items ===
        $section = ServiceSection::create([
            'title' => 'Sales Acceleration',
            'slug' => Str::slug('Sales Acceleration'),
            'order' => 1,
            'is_active' => true,
        ]);

        $icon1 = $request->file('icon1');
        $icon2 = $request->file('icon2');
        $icon1Path = Storage::url($icon1->store('icons', 'public'));
        $icon2Path = Storage::url($icon2->store('icons', 'public'));

        $section->items()->createMany([
            [
                'title' => 'Pre-Sales Support',
                'description' => 'Our team collaborates with partners to understand customer needs.',
                'icon' => $icon1Path,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Direct Sales',
                'description' => 'We go beyond distribution with strategic selling.',
                'icon' => $icon2Path,
                'order' => 2,
                'is_active' => true,
            ]
        ]);

        // === Upload Banner Image ===
        $bannerImagePath = $request->file('banner_image')->store('banners', 'public');
        $bannerImageUrl = Storage::url($bannerImagePath);

        ServiceBannerSection::create([
            'title' => 'Built for Performance',
            'description' => 'At Prosoft, we believe that speed and efficiency are key to success.',
            'image' => $bannerImageUrl,
            'alignment' => 'right',
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Dummy content with files uploaded and seeded successfully.',
        ]);
    }
}
