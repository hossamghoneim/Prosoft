<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TermsConditionHeroSectionResource;
use App\Models\Setting;
use App\Models\TermsConditionHeroSection;
use App\Models\TermsConditionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TermsAndConditionsController extends Controller
{
    public function getFullPage()
    {
        $hero = TermsConditionHeroSection::where('is_active', true)->first();
        $items = TermsConditionItem::where('is_active', true)->get();
        $setting = Setting::where('key', 'contact_details')->first();
        $data = $setting ? json_decode($setting->value, true) : [];

        return response()->json([
            'success' => true,
            'data' => [
                'hero' => $hero ? new TermsConditionHeroSectionResource($hero) : null,
                'items' => $items,
                'contact_details' => $data
            ]
        ]);
    }

    public function seedTestData(Request $request)
    {
        // === Validate Uploaded Files ===
        $request->validate([
            'hero_video' => 'required|file|mimetypes:video/mp4,video/webm|max:102400', // 100MB
        ]);

        // === Heroooooooooooooooooooooooooooooooooo ===
        $heroVideoPath = $request->file('hero_video')->store('hero-videos', 'public');
        $heroVideoUrl = Storage::url($heroVideoPath);

        // === Create Heroooooooooooooooooooooooooooooooo Section ===
        TermsConditionHeroSection::create([
            'description' => "Welcome to the Prosoft website (the “Site”). By accessing or using this Site, you agree to comply with and be bound by the following terms and conditions (“Terms”). If you do not agree to these Terms, please do not use the Site.",
            'video_url' => $heroVideoUrl,
            'is_active' => true,
            'effective_date' => now(),
        ]);
        // -------------------------------------------------------- //

        $items = [
            [
                'title' => "Use of the Website",
                'description' => "This Site is intended to provide information about Prosoft’s services, solutions, partners, and general business activities. You may browse the Site freely, but you may not copy, distribute, modify, or reuse any content without prior written permission from Prosoft.",
                'order' => 1,
                'is_active' => true
            ],
            [
                'title' => "Intellectual Property",
                'description' => "All content on the Site, including but not limited to text, graphics, logos, icons, images, audio clips, and software, is the property of Prosoft or its partners and is protected by intellectual property laws. Unauthorized use may violate copyright, trademark, and other applicable laws.",
                'order' => 2,
                'is_active' => true
            ],
            [
                'title' => "Privacy",
                'description' => "Your use of this Site is subject to our Privacy Policy, which outlines how we collect, use, and protect your information. By using the Site, you consent to the practices described in the Privacy Policy.",
                'order' => 3,
                'is_active' => true
            ],
            [
                'title' => "Third-Party Links",
                'description' => "This Site may contain links to third-party websites. These links are provided for your convenience only. Prosoft does not endorse or control the content of these websites and is not responsible for any damage or loss caused by your use of third-party links.",
                'order' => 4,
                'is_active' => true
            ],
            [
                'title' => "Disclaimer of Warranties",
                'description' => "The Site and all content are provided on an “as is” and “as available” basis. Prosoft makes no warranties, express or implied, including but not limited to implied warranties of merchantability or fitness for a particular purpose. We do not warrant that the Site will be error-free, secure, or uninterrupted.",
                'order' => 5,
                'is_active' => true
            ],
            [
                'title' => "Limitation of Liability",
                'description' => "Prosoft shall not be liable for any direct, indirect, incidental, special, or consequential damages resulting from your use of or inability to use the Site, including but not limited to reliance on any information obtained from the Site.",
                'order' => 6,
                'is_active' => true
            ],
            [
                'title' => "Changes to the Terms",
                'description' => "Prosoft reserves the right to modify these Terms at any time without prior notice. Changes will be posted on this page with an updated effective date. Your continued use of the Site constitutes your acceptance of the revised Terms.",
                'order' => 7,
                'is_active' => true
            ],
            [
                'title' => "Governing Law",
                'description' => "These Terms shall be governed by and construed in accordance with the laws of Egypt without regard to its conflict of law provisions.",
                'order' => 8,
                'is_active' => true
            ],
            [
                'title' => "Contact Us",
                'description' => "If you have any questions or concerns about these Terms, please contact us:",
                'order' => 9,
                'is_active' => true
            ]
        ];

        foreach ($items as $item) {
            TermsConditionItem::create($item);
        }

        $data = [
            'name' => "Prosoft",
            'address' => "Smart Village, A25-B107",
            'email' => "info@prosoft.com.eg",
            'phone' => "0235372575"
        ];

        Setting::updateOrCreate(
            ['key' => 'contact_details'],
            ['value' => json_encode($data)]
        );

        return response()->json([
            'success' => true,
            'message' => 'Terms and conditions seeded successfully.',
        ]);
    }
}
