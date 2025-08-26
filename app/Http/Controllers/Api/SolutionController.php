<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUsBannerSection;
use App\Models\Solution;
use App\Models\SolutionHeroSection;
use App\Models\SolutionMainSection;
use App\Models\SolutionMainSectionItemContent;
use App\Models\SolutionMiddleSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SolutionController extends Controller
{
    public function index()
    {
        $solutions = Solution::where('is_active', true)->get();

        return response()->json([
            'success' => true,
            'data' => [
                'solutions' => $solutions,
            ]
        ]);
    }

    public function getFullPage(Request $request)
    {
        $request->validate([
            'solution_id' => 'required|integer|exists:solutions,id',
        ]);

        $hero = SolutionHeroSection::where('solution_id', $request->solution_id)->where('is_active', true)->first();
        $mainSection = SolutionMainSection::with([
            'solutionMainSectionItems' => function ($q) {
                $q->where('is_active', true)
                    ->orderBy('order')
                    ->with([
                        'solutionMainSectionItemContent' => function ($q) {
                            $q->orderBy('id', 'asc');
                        }
                    ])->get();
            }
        ])->where('solution_id', $request->solution_id)->where('is_active', true)->first();

        $middleSection = SolutionMiddleSection::with([
            'solutionMiddleSectionItems' => function ($q) {
                $q->where('is_active', true)->orderBy('order');
            }
        ])->where('solution_id', $request->solution_id)->where('is_active', true)->first();

        $banner = AboutUsBannerSection::where('is_active', true)->first();


        return response()->json([
            'success' => true,
            'data' => [
                'hero' => $hero,
                'mainSection' => $mainSection,
                'middleSection' => $middleSection,
                'banner' => $banner
            ]
        ]);
    }

    public function seed(Request $request)
    {

        // === Validate Uploaded Files ===
        $request->validate([
            'hero_video' => 'required|file|mimetypes:video/mp4,video/webm|max:102400', // 100MB
            'image1' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
            'image2' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
            'image3' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
            'image4' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
            'image5' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
            'image6' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
            'logo1' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'logo2' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'logo3' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
        ]);

        // === Create Solutions ===
        $solution = Solution::create([
            'title' => 'Data & AI',
            'slug' => 'data-ai',
            'is_active' => true,
        ]);
        // -------------------------------------------------------- //

        // === Heroooooooooooooooooooooooooooooooooo ===
        $heroVideoPath = $request->file('hero_video')->store('hero-videos', 'public');
        $heroVideoUrl = Storage::url($heroVideoPath);

        // === Create Heroooooooooooooooooooooooooooooooo Section ===
        SolutionHeroSection::create([
            'title' => 'Smarter Data. Stronger AI. Better Decisions.',
            'solution_id' => $solution->id,
            'description' => "Data is everywhere, but without AI, it’s just noise. The real advantage comes from transforming raw data into intelligence—powering smarter decisions, automation, and innovation. Organizations that harness AI-driven data strategies gain faster insights, stronger governance, and a competitive edge.",
            'button_text' => 'Unlock AI-Driven Insights Today',
            'button_url' => 'https://prosoft.com.eg/solutions/data-ai/',
            'video_url' => $heroVideoUrl,
            'is_active' => true,
        ]);
        // -------------------------------------------------------- //

        // === Create Mainnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn Section ===
        $solutionMainSection = SolutionMainSection::create([
            'solution_id' => $solution->id,
            'title' => 'The Three Pillars of AI-Powered Transformation',
            'description' => 'With watsonx, you get a unified AI platform designed to manage, scale, and govern enterprise AI—ensuring trust, efficiency, and business impact from day one.',
            'is_active' => true,
            'enable_grid_view' => true
        ]);
        // -------------------------------------------------------- //

        // === Create Main Section itemsssssssssssssssssssssssssssssssssssssssssss ===
        $image1 = $request->file('image1');
        $image2 = $request->file('image2');
        $image3 = $request->file('image3');
        $image1Path = Storage::url($image1->store('images', 'public'));
        $image2Path = Storage::url($image2->store('images', 'public'));
        $image3Path = Storage::url($image3->store('images', 'public'));
        $solutionMainSection->solutionMainSectionItems()->createMany([
            [
                'title' => 'Data',
                'image' => $image1Path,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'AI',
                'image' => $image2Path,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Governance',
                'image' => $image3Path,
                'order' => 3,
                'is_active' => true,
            ],
        ]);
        // -------------------------------------------------------- //

        // === Create Main Section item content ===
        $image4 = $request->file('image4');
        $image5 = $request->file('image5');
        $image6 = $request->file('image6');
        $image4Path = Storage::url($image4->store('images', 'public'));
        $image5Path = Storage::url($image5->store('images', 'public'));
        $image6Path = Storage::url($image6->store('images', 'public'));

        //Content 1
        SolutionMainSectionItemContent::create([
            'solution_main_section_item_id' => 1,
            'main_title' => 'Data',
            'description' => 'Organizations need flexible, scalable data platforms that support AI-driven analytics. watsonx.data is designed for businesses that demand speed, cost efficiency, and security in data management.',
            'background_image' => $image4Path,
            'first_card_title' => 'Unified Data Lakehouse',
            'first_card_description' => 'Combine all your data types into a single lakehouse, eliminating silos and enabling faster, organization-wide access.',
            'second_card_title' => 'AI-Optimized',
            'second_card_description' => 'Built to power advanced analytics and AI, turning raw data into real business insights quickly and efficiently.',
            'third_card_title' => 'Governance & Security',
            'third_card_description' => 'Enterprise-level controls and security features keep your data protected and compliant at every stage.',
            'button_text' => 'See How AI-Optimized Data Works'
        ]);

        //Content 2
        SolutionMainSectionItemContent::create([
            'solution_main_section_item_id' => 2,
            'main_title' => 'AI',
            'description' => 'With watsonx.ai, organizations can develop, deploy, and scale AI models tailored to their business needs. Whether it’s predictive analytics, automation, or generative AI, this platform gives you the power to create AI that drives real results.',
            'background_image' => $image5Path,
            'first_card_title' => 'Build and Train Models Faster',
            'first_card_description' => 'Streamline the creation and fine-tuning of AI models with powerful tools and an intuitive interface.',
            'second_card_title' => 'Foundation Models at Your Fingertips',
            'second_card_description' => 'Access a library of pre-trained foundation models you can adapt quickly for industry-specific use cases.',
            'third_card_title' => 'Enterprise-Grade Governance',
            'third_card_description' => 'Control, transparency, and compliance in AI workflows, from experimentation to deployment.',
            'button_text' => 'Explore AI-Powered Business Solutions'
        ]);

        //Content 3
        SolutionMainSectionItemContent::create([
            'solution_main_section_item_id' => 3,
            'main_title' => 'Governance',
            'description' => 'AI-driven decisions need to be fair, explainable, and compliant. watsonx.governance provides the tools to monitor, manage, and regulate AI models—so your AI remains ethical, reliable, and free from bias.preview',
            'background_image' => $image6Path,
            'first_card_title' => 'Automate AI Compliance',
            'first_card_description' => 'Streamline policy enforcement and documentation to keep AI projects aligned with regulatory standards.',
            'second_card_title' => 'Transparent Model Insights',
            'second_card_description' => 'Gain clear visibility into how models make decisions, supporting explainability and audit readiness.',
            'third_card_title' => 'Risk Mitigation Built In',
            'third_card_description' => 'Proactively detect and address bias, drift, and other risks to protect your AI investments and reputation.',
            'button_text' => 'Learn How to Govern AI with Confidence'
        ]);
        // -------------------------------------------------------- //

        // === Create Solution Middle Section ===
        $solutionMiddleSection = SolutionMiddleSection::create([
            'solution_id' => $solution->id,
            'title' => 'The Future of AI-Powered Business Starts Now',
            'is_active' => true
        ]);
        // -------------------------------------------------------- //

        // === Create Middle Section itemsssssssssssssssssssssssssssssssssssssssssss ===
        $logo1 = $request->file('logo1');
        $logo2 = $request->file('logo2');
        $logo3 = $request->file('logo3');
        $logo1Path = Storage::url($logo1->store('images', 'public'));
        $logo2Path = Storage::url($logo2->store('images', 'public'));
        $logo3Path = Storage::url($logo3->store('images', 'public'));
        $solutionMiddleSection->solutionMiddleSectionItems()->createMany([
            [
                'title' => 'Build on Quality Data',
                'description' => 'Lay the foundation for reliable AI with clean, well-managed data that drives accurate, actionable insights.',
                'icon' => $logo1Path,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Scale with Purpose',
                'description' => 'Deploy AI models that don’t just work — they create measurable business value and support strategic growth.',
                'icon' => $logo2Path,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Embed Trust by Design',
                'description' => 'Integrate responsible governance and compliance throughout the AI lifecycle to build confidence and transparency.',
                'icon' => $logo3Path,
                'order' => 3,
                'is_active' => true,
            ],
        ]);
        // -------------------------------------------------------- //

        return response()->json([
            'success' => true,
            'message' => 'Solution seeded successfully.',
        ]);
    }
}
