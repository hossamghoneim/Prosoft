<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HomeHeroSection;
use App\Models\HomePrimarySection;
use App\Models\HomeSecondarySection;
use App\Models\Partner;
use App\Models\Setting;
use App\Models\Solution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function getHomePage(Request $request)
    {
        $hero = HomeHeroSection::where('is_active', true)->first();
        $partnerLogos = Partner::pluck('inner_logo')->take(6)->toArray();
        $primarySection = HomePrimarySection::where('is_active', true)->first();
        $secondarySection = HomeSecondarySection::first();
        $solutions = Solution::select('id', 'title', 'image')->limit(6)->get();

        return response()->json([
            'success' => true,
            'data' => [
                'hero' => $hero,
                'partners' => $partnerLogos,
                'primarySection' => $primarySection,
                'secondarySection' => $secondarySection,
                'solutions' => $solutions
            ]
        ]);
    }

    public function seed(Request $request)
    {
        // === Validate Uploaded Files ===
        $request->validate([
            'hero_video' => 'required|file|mimetypes:video/mp4,video/webm|max:102400', // 100MB
            'partner_image' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'background_image' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:102400',      // 10MB
            'icon1' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'icon2' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'icon3' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'logo' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
        ]);

        // === Heroooooooooooooooooooooooooooooooooo ===
        $heroVideoPath = $request->file('hero_video')->store('hero-videos', 'public');
        $heroVideoUrl = Storage::url($heroVideoPath);

        // === Create Heroooooooooooooooooooooooooooooooo Section ===
        HomeHeroSection::create([
            'title' => 'Value Beyond Distribution',
            'description' => "Prosoft is a specialized value-added distributor with 30+ years of experience in the enterprise IT space. We partner with global technology vendors to bring their solutions to market through our network of trusted experts.",
            'button_text' => 'Experience True Partnership Synergy',
            'button_url' => 'https://example.com/about-us',
            'video_url' => $heroVideoUrl,
            'is_active' => true,
        ]);
        // -------------------------------------------------------- //

        // === Primary Section ===
        $partnerImagePath = $request->file('partner_image')->store('images', 'public');
        $partnerImageUrl = Storage::url($partnerImagePath);

        // === Create Primary Section ===
        HomePrimarySection::create([
            'title' => 'Your Strategic Distribution Partner',
            'description' => "At Prosoft, we’ve spent over 30 years quietly shaping Egypt’s technology landscape—partner by partner, solution by solution. As a value-added distributor, we don’t just move technology—we help move businesses forward. From deep-rooted industry partnerships to a growing portfolio across software and infrastructure, we bring the experience, focus, and local insight that global vendors and regional partners rely on. When precision, trust, and long-term thinking matter Prosoft is where the conversation starts.",
            'image' => $partnerImageUrl,
            'is_active' => true,
        ]);
        // -------------------------------------------------------- //

        // === Secondary Section ===
        $icon1 = $request->file('icon1');
        $icon2 = $request->file('icon2');
        $icon3 = $request->file('icon3');
        $icon1Path = Storage::url($icon1->store('icons', 'public'));
        $icon2Path = Storage::url($icon2->store('icons', 'public'));
        $icon3Path = Storage::url($icon3->store('icons', 'public'));
        $backgroundImage = $request->file('background_image');
        $backgroundImagePath = Storage::url($backgroundImage->store('background-images', 'public'));

        // === Create Secondary Section ===
        HomeSecondarySection::create([
            'main_title' => "Tunnel Focus Lights The Way",
            'main_description' => "We operate with intentional focus — like a beam of light through a tunnel, our efforts are directed with purpose and clarity. This approach isn’t about narrowing options — it’s about amplifying impact. By concentrating our energy where it matters most, we build deeper expertise, foster stronger collaboration, and drive momentum that endures. It’s how we transform powerful technologies into real, market-shaping outcomes.",
            'background_image' => $backgroundImagePath,
            'first_card_logo' => $icon1Path,
            'first_card_title' => "Depth Over Distraction",
            'first_card_description' => "Our focused approach allows us to go deep with our partners — building real expertise and alignment that broad coverage simply can't match.",
            'second_card_logo' => $icon2Path,
            'second_card_title' => "Committed Collaboration",
            'second_card_description' => "With more intentional partnerships, we invest fully in each relationship — from enablement to execution, every step is deliberate.",
            'third_card_logo' => $icon3Path,
            'third_card_title' => "Momentum That Lasts",
            'third_card_description' => "Focus creates velocity. By channeling our energy into select alliances, we generate market impact that’s both immediate and sustainable."
        ]);
        // -------------------------------------------------------- //

        //add secondary logo to header
        $logoPath = $request->file('logo')->store('header', 'public');
        $logoUrl = Storage::url($logoPath);
        $data['secondaryLogo'] = $logoUrl;

        Setting::updateOrCreate(
            ['key' => 'header'],
            ['value' => json_encode($data)]
        );

        return response()->json(['success' => true]);
    }
}
