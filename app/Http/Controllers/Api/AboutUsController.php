<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUsBannerSection;
use App\Models\AboutUsFeature;
use App\Models\AboutUsFinalSection;
use App\Models\AboutUsHeroSection;
use App\Models\AboutUsMiddleSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function getFullPage()
    {
        $hero = AboutUsHeroSection::where('is_active', true)->first();
        $aboutUsFeatures = AboutUsFeature::with(['aboutUsFeatureItems' => function ($q) {
            $q->where('is_active', true)->orderBy('order');
        }])->where('is_active', true)->get();
        $aboutUsMiddleSection = AboutUsMiddleSection::with(['aboutUsMiddleSectionItems' => function ($q) {
            $q->where('is_active', true)->orderBy('order');
        }])->where('is_active', true)->get();
        $aboutUsFinalSection = AboutUsFinalSection::with(['aboutUsFinalSectionItems' => function ($q) {
            $q->where('is_active', true)->orderBy('order');
        }])->where('is_active', true)->get();
        $banner = AboutUsBannerSection::where('is_active', true)->first();

        return response()->json([
            'success' => true,
            'data' => [
                'hero' => $hero,
                'aboutUsFeatures' => $aboutUsFeatures,
                'aboutUsMiddleSection' => $aboutUsMiddleSection,
                'aboutUsFinalSection' => $aboutUsFinalSection,
                'banner' => $banner
            ]
        ]);
    }

    public function seedTestData(Request $request)
    {
        // === Validate Uploaded Files ===
        $request->validate([
            'hero_video' => 'required|file|mimetypes:video/mp4,video/webm|max:102400', // 100MB
            'icon1' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'icon2' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'icon3' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'background_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',      // 5MB
            'icon4' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'icon5' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'icon6' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'icon7' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'icon8' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'icon9' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'banner_video' => 'required|file|mimetypes:video/mp4,video/webm|max:102400', // 100MB
        ]);

        // === Heroooooooooooooooooooooooooooooooooo ===
        $heroVideoPath = $request->file('hero_video')->store('hero-videos', 'public');
        $heroVideoUrl = Storage::url($heroVideoPath);

        // === Create Heroooooooooooooooooooooooooooooooo Section ===
        AboutUsHeroSection::create([
            'title' => 'Clarity. Commitment. Continuity.',
            'description' => "For over three decades, we’ve been a steady light in Egypt’s ever-evolving tech landscape — guiding, not flashing. In an industry that often chases trends and headlines, we’ve remained anchored, helping our partners navigate change with clarity and confidence. Our presence isn’t loud, but it’s always there — reliable, deliberate, and trusted when it matters most.",
            'button_text' => 'Experience True Partnership Synergy',
            'button_url' => 'https://example.com/about-us',
            'video_url' => $heroVideoUrl,
            'is_active' => true,
        ]);
        // -------------------------------------------------------- //

        // === Create Features && Features Sections ===
        $aboutUsFeature1 = AboutUsFeature::create([
            'title' => 'What We Do',
            'is_active' => true,
        ]);

        $aboutUsFeature2 = AboutUsFeature::create([
            'title' => 'How We Do It',
            'is_active' => true,
        ]);

        $icon1 = $request->file('icon1');
        $icon2 = $request->file('icon2');
        $icon3 = $request->file('icon3');
        $icon1Path = Storage::url($icon1->store('icons', 'public'));
        $icon2Path = Storage::url($icon2->store('icons', 'public'));
        $icon3Path = Storage::url($icon3->store('icons', 'public'));

        $aboutUsFeature1->aboutUsFeatureItems()->createMany([
            [
                'title' => 'Enterprise IT Distribution',
                'description' => 'Specialized value-added distribution with over 30 years of experience in the enterprise IT space, connecting global vendors with local markets.',
                'icon' => $icon1Path,
                'order' => 1,
                'is_active' => true,
            ],
        ]);
        $aboutUsFeature2->aboutUsFeatureItems()->createMany([
            [
                'title' => 'End-to-End Support',
                'description' => 'Comprehensive services including pre-sales consultancy, technical enablement, credit facilities, and strategic customer engagement.',
                'icon' => $icon2Path,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Market Expertise',
                'description' => 'Deep understanding of the local market dynamics and a carefully curated vendor portfolio, ensuring every solution is positioned for long-term success.',
                'icon' => $icon3Path,
                'order' => 3,
                'is_active' => true,
            ],
        ]);
        // -------------------------------------------------------- //

        // === Create Middle Section && Middle Section Items ===
        $backgroundImage = $request->file('background_image');
        $backgroundImagePath = Storage::url($backgroundImage->store('background-images', 'public'));
        $aboutUsMiddleSection = AboutUsMiddleSection::create([
            'title' => 'A Legacy of Excellence',
            'description' => "With deep roots in Egypt’s tech landscape, Prosoft has spent over three decades helping shape some of the country’s most transformative technology journeys. We’ve built our reputation not through scale, but through selectiveness — choosing the right partners, nurturing lasting relationships, and delivering value where it counts. Our approach isn’t about volume; it’s about vision. We enable momentum, open doors that matter, and stand firm when others shift course. Our legacy isn't in the logos we carry, but in the depth of the relationships we’ve built.",
            'background_image' => $backgroundImagePath,
            'is_active' => true,
        ]);

        $icon4 = $request->file('icon4');
        $icon5 = $request->file('icon5');
        $icon6 = $request->file('icon6');
        $icon4Path = Storage::url($icon4->store('icons', 'public'));
        $icon5Path = Storage::url($icon5->store('icons', 'public'));
        $icon6Path = Storage::url($icon6->store('icons', 'public'));

        $aboutUsMiddleSection->aboutUsMiddleSectionItems()->createMany([
            [
                'title' => 'Rooted in Purpose',
                'description' => "With over 30 years of local presence, we bring momentum and clarity to Egypt’s most strategic technology transformations.",
                'icon' => $icon4Path,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Selective by Design',
                'description' => "We focus on meaningful partnerships over mass reach, choosing to work with those who share our vision for lasting impact.",
                'icon' => $icon5Path,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Built on Trust',
                'description' => 'Our reputation comes from consistent delivery, long-term relationships, and showing up when it matters most.',
                'icon' => $icon6Path,
                'order' => 3,
                'is_active' => true,
            ],
        ]);
        // -------------------------------------------------------- //

        // === Create Final Section && Final Section Items ===
        $aboutUsFinalSection = AboutUsFinalSection::create([
            'title' => 'Our Philosophy',
            'description' => "At Prosoft, distribution isn’t a numbers game — it’s a long-term commitment to creating real, measurable value for our partners. We believe in depth over breadth, building intentional relationships with both vendors and resellers. Our approach is consultative, hands-on, and built on trust.
                We represent only a focused set of vendors whose solutions we believe in, allowing us to dedicate the time, resources, and strategic thinking each one deserves. This philosophy has shaped our reputation as a distributor that delivers not only reach — but impact.",
            'is_active' => true,
        ]);

        $icon7 = $request->file('icon7');
        $icon8 = $request->file('icon8');
        $icon9 = $request->file('icon9');
        $icon7Path = Storage::url($icon7->store('icons', 'public'));
        $icon8Path = Storage::url($icon8->store('icons', 'public'));
        $icon9Path = Storage::url($icon9->store('icons', 'public'));

        $aboutUsFinalSection->aboutUsFinalSectionItems()->createMany([
            [
                'title' => 'Precision',
                'description' => "Focused approach with attention to detail",
                'icon' => $icon7Path,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Trust',
                'description' => "Building lasting relationships through reliability",
                'icon' => $icon8Path,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Continuity',
                'description' => 'Committed to long-term partnerships',
                'icon' => $icon9Path,
                'order' => 3,
                'is_active' => true,
            ],
        ]);
        // -------------------------------------------------------- //

        // === Bannnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnner ===
        $bannerVideoPath = $request->file('banner_video')->store('banner-videos', 'public');
        $bannerVideoUrl = Storage::url($bannerVideoPath);

        // === Create Bannnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnner Section ===
        AboutUsBannerSection::create([
            'title' => 'Value Beyond Distribution',
            'description' => "At Prosoft, partnership isn’t transactional — it’s foundational. We build with intention, support with depth, and grow with those who see the value of doing things right.",
            'button_text' => "let's Build Something Lasting",
            'button_url' => 'https://example.com/about-us',
            'video_url' => $bannerVideoUrl,
            'is_active' => true,
        ]);
        // -------------------------------------------------------- //

        return response()->json([
            'success' => true,
            'message' => 'About us content seeded successfully.',
        ]);
    }
}
