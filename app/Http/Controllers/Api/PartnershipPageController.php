<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PartnerBannerSection;
use App\Models\PartnershipHeroSection;
use App\Models\PartnershipSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnershipPageController extends Controller
{
    public function getFullPage()
    {
        $hero = PartnershipHeroSection::where('is_active', true)->first();

        $section = PartnershipSection::with(['partners' => function ($q) {
            $q->where('is_active', true);
        }])->where('is_active', true)->first();

        $banner = PartnerBannerSection::with(['partnerBannerSectionItems' => function ($q) {
            $q->where('is_active', true);
        }])->where('is_active', true)->first();

        return response()->json([
            'success' => true,
            'data' => [
                'hero' => $hero,
                'sections' => $section,
                'banner' => $banner
            ]
        ]);
    }

    public function seedTestData(Request $request)
    {
        // === Validate Uploaded Files ===
        $request->validate([
            'hero_video' => 'required|file|mimetypes:video/mp4,video/webm|max:102400', // 100MB
            'section_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',      // 5MB
            'outter_icon1' => 'required|image|mimes:svg,png,jpg,jpeg|max:2048',
            'outter_icon2' => 'required|image|mimes:svg,png,jpg,jpeg|max:2048',
            'outter_icon3' => 'required|image|mimes:svg,png,jpg,jpeg|max:2048',
            'outter_icon4' => 'required|image|mimes:svg,png,jpg,jpeg|max:2048',
            'outter_icon5' => 'required|image|mimes:svg,png,jpg,jpeg|max:2048',
            'outter_icon6' => 'required|image|mimes:svg,png,jpg,jpeg|max:2048',
            'inner_icon1' => 'required|image|mimes:svg,png,jpg,jpeg|max:2048',
            'inner_icon2' => 'required|image|mimes:svg,png,jpg,jpeg|max:2048',
            'inner_icon3' => 'required|image|mimes:svg,png,jpg,jpeg|max:2048',
            'inner_icon4' => 'required|image|mimes:svg,png,jpg,jpeg|max:2048',
            'inner_icon5' => 'required|image|mimes:svg,png,jpg,jpeg|max:2048',
            'inner_icon6' => 'required|image|mimes:svg,png,jpg,jpeg|max:2048',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',      // 5MB
            'icon1' => 'required|image|mimes:svg,png,jpg,jpeg|max:2048',
            'icon2' => 'required|image|mimes:svg,png,jpg,jpeg|max:2048',
            'icon3' => 'required|image|mimes:svg,png,jpg,jpeg|max:2048',
        ]);

        // === Heroooooooooooooooooooooooooooooooooo ===
        $heroVideoPath = $request->file('hero_video')->store('hero-videos', 'public');
        $heroVideoUrl = Storage::url($heroVideoPath);

        // === Create Heroooooooooooooooooooooooooooooooo Section ===
        PartnershipHeroSection::create([
            'title' => 'Powerful Partnerships, Unmatched Possibilities',
            'description' => "Our success isn’t built on technology alone — it’s built on the strength of our partnerships. By collaborating with global technology leaders and cybersecurity pioneers, we deliver more than just products — we deliver future-ready solutions designed to fuel innovation, enhance security, and drive growth. Each partnership represents a commitment to helping your business evolve, adapt, and lead in an ever-changing digital landscape.",
            'button_text' => 'Experience True Partnership Synergy',
            'button_url' => 'https://example.com/become-partner',
            'video_url' => $heroVideoUrl,
            'is_active' => true,
        ]);
        // -------------------------------------------------------- //

        // Sectionnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn //

        $sectionImagePath = $request->file('section_image')->store('sections', 'public');
        $sectionImageUrl = Storage::url($sectionImagePath);

        $section = PartnershipSection::create([
            'title' => 'Strategic Technology Alliances',
            'description' => 'At Prosoft, our vendor relationships are built on more than product distribution — they’re grounded in shared goals and long-term alignment. We work closely with a focused group of global technology leaders to bring best-in-class solutions to the local market, ensuring every partnership is purposeful, supported, and positioned for impact.',
            'image' => $sectionImageUrl,
            'is_active' => true,
        ]);

        // -------------------------------------------------------------------------------- //

        // section itemssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss //

        $outterIcon1Path = Storage::url($request->file('outter_icon1')->store('icons', 'public'));
        $outterIcon2Path = Storage::url($request->file('outter_icon2')->store('icons', 'public'));
        $outterIcon3Path = Storage::url($request->file('outter_icon3')->store('icons', 'public'));
        $outterIcon4Path = Storage::url($request->file('outter_icon4')->store('icons', 'public'));
        $outterIcon5Path = Storage::url($request->file('outter_icon5')->store('icons', 'public'));
        $outterIcon6Path = Storage::url($request->file('outter_icon6')->store('icons', 'public'));

        $innerIcon1Path = Storage::url($request->file('inner_icon1')->store('icons', 'public'));
        $innerIcon2Path = Storage::url($request->file('inner_icon2')->store('icons', 'public'));
        $innerIcon3Path = Storage::url($request->file('inner_icon3')->store('icons', 'public'));
        $innerIcon4Path = Storage::url($request->file('inner_icon4')->store('icons', 'public'));
        $innerIcon5Path = Storage::url($request->file('inner_icon5')->store('icons', 'public'));
        $innerIcon6Path = Storage::url($request->file('inner_icon6')->store('icons', 'public'));

        $section->partners()->createMany([
            [
                'inner_logo' => $innerIcon1Path,
                'outer_logo' => $outterIcon1Path,
                'title' => 'A Legacy of Innovation, Powering Tomorrow',
                'description' => 'For over a century, IBM has defined what it means to lead in technology — driving breakthroughs from mainframe computing to AI, hybrid cloud, and quantum computing. Partnering with IBM means gaining access to a legacy of innovation paired with a vision that never stops evolving. Whether you’re modernizing infrastructure or transforming operations, IBM empowers you with the technology and expertise to outpace the competition.',
                'button_text' => "Power What’s Next",
                'button_url' => 'https://example.com/partner1',
                'background_color' => '#0E61FE',
                'is_active' => true,
            ],
            [
                'inner_logo' => $innerIcon2Path,
                'outer_logo' => $outterIcon2Path,
                'title' => 'Empowering Businesses with Scalable Software Solutions',
                'description' => 'HCLSoftware, a division of HCLTech, delivers innovative, cloud-native solutions designed to help businesses work smarter and scale faster. Serving over 20,000 global enterprises — including many Fortune 100 and Fortune 500 companies — HCLSoftware specializes in automation, data analytics, security, and customer experience platforms. From streamlining processes to enhancing operational agility, HCLSoftware helps future-proof your digital transformation journey.',
                'button_text' => 'Accelerate Smarter Outcomes',
                'button_url' => 'https://example.com/partner2',
                'background_color' => '#01010D',
                'is_active' => true,
            ],
            [
                'inner_logo' => $innerIcon3Path,
                'outer_logo' => $outterIcon3Path,
                'title' => 'Empowering Intelligent, Connected, and Secure Enterprises',
                'description' => 'OpenText helps organizations take control of their most valuable asset — information. As a global leader in information management, OpenText enables businesses to securely capture, govern, and extract insights from data across the enterprise. From content management and workflow automation to AI-driven analytics and cybersecurity, OpenText delivers the tools to accelerate decisions, improve collaboration, and ensure regulatory compliance — making your business smarter, faster, and more resilient.',
                'button_text' => 'Unlock Seamless Outcomes',
                'button_url' => 'https://example.com/partner1',
                'background_color' => '#000066',
                'is_active' => true,
            ],
            [
                'inner_logo' => $innerIcon4Path,
                'outer_logo' => $outterIcon4Path,
                'title' => 'Setting the Standard in Open Source Security',
                'description' => 'Black Duck is a recognized leader in securing open source software, empowering businesses to innovate without compromise. Named a Leader in the Gartner® Magic Quadrant™ for Application Security Testing for seven consecutive years, Black Duck helps organizations identify vulnerabilities, ensure license compliance, and manage risk across their software supply chain. With advanced Software Composition Analysis (SCA) and Application Security Testing (AST) capabilities, Black Duck provides the confidence to build and scale securely — even in the most complex environments.',
                'button_text' => 'Build fast. Stay secure.',
                'button_url' => 'https://example.com/partner2',
                'background_color' => '#9871B4',
                'is_active' => true,
            ],
            [
                'inner_logo' => $innerIcon5Path,
                'outer_logo' => $outterIcon5Path,
                'title' => 'Building Cyber Resilience Through Immersive Training',
                'description' => 'In cybersecurity, theory isn’t enough — action is everything. RangeForce offers hands-on, real-world cyber defense training, immersing your team in simulated attacks that mirror today’s most sophisticated threats. By teaching them to detect, respond, and mitigate incidents in real time, RangeForce builds practical skills that strengthen your security posture. Whether you’re upskilling your IT team or empowering frontline defenders, RangeForce helps create a more resilient, battle-ready cybersecurity force.',
                'button_text' => 'Train with RangeForce Now',
                'button_url' => 'https://example.com/partner1',
                'background_color' => '#080708',
                'is_active' => true,
            ],
            [
                'inner_logo' => $outterIcon6Path,
                'outer_logo' => $innerIcon6Path,
                'title' => 'Driving Data Protection and Productivity With Behavioral Insight',
                'description' => "Teramind brings powerful visibility to both security and productivity. Its insider threat detection and data loss prevention capabilities are paired with intelligent user behavior and productivity analytics — giving organizations the tools to protect data, enforce policies, and optimize workforce performance. Whether you're securing sensitive assets or streamlining remote team output, Teramind delivers real-time insights that translate into actionable outcomes",
                'button_text' => 'Start Monitoring Smarter',
                'button_url' => 'https://example.com/partner2',
                'background_color' => '#D8DADC',
                'is_active' => true,
            ]
        ]);

        // -------------------------------------------------------------------------------- //

        // === Upload Bannerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr Image ===
        $bannerImagePath = $request->file('banner_image')->store('banners', 'public');
        $bannerImageUrl = Storage::url($bannerImagePath);

        // === Create Bannerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr Section ===
        $bannerSection = PartnerBannerSection::create([
            'title' => 'Bridging Global Innovation with Local Mastery ',
            'description' => "We understand that truly effective technology solutions require a deep understanding of local markets. That's why, alongside our collaborations with international tech leaders, we prioritize partnerships with local technology integrators. These partnerships enable us to deliver customized, impactful solutions that address the unique needs of each region. We're committed to fostering strong, collaborative relationships that drive growth for all our partners. ",
            'image' => $bannerImageUrl,
            'is_active' => true,
        ]);

        // === Upload Icons ===
        $icon1Path = Storage::url($request->file('icon1')->store('icons', 'public'));
        $icon2Path = Storage::url($request->file('icon2')->store('icons', 'public'));
        $icon3Path = Storage::url($request->file('icon3')->store('icons', 'public'));

        // === Create Banner Section Items ===
        $bannerSection->partnerBannerSectionItems()->createMany([
            [
                'title' => 'Local Insight, Global Vision ',
                'description' => 'We translate technologies into relevant strategies, aligning innovation with local opportunity.',
                'icon' => $icon1Path,
                'is_active' => true,
            ],
            [
                'title' => 'Unified Channel Enablement',
                'description' => 'Acting as a connector, we ensure both vendors and partners are equipped, informed, and aligned for success.',
                'icon' => $icon2Path,
                'is_active' => true,
            ],
            [
                'title' => 'Hands-On Market Activation',
                'description' => 'Beyond matchmaking — we actively support deployment, positioning, and growth across the full solution lifecycle.',
                'icon' => $icon3Path,
                'is_active' => true,
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Partnerships content seeded successfully.',
        ]);
    }
}
