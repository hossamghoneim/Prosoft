<?php

namespace App\Http\Controllers\Api;

use App\Enums\InquiryTypesEnum;
use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use App\Models\ContactUsContent;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Enum;

class ContactUsPageController extends Controller
{
    public function getFullPage()
    {
        // i want to limit contactUsSections with only the first 3 sections
        $contactUsContent = ContactUsContent::with(['contactUsSections' => function ($query) {
            $query->limit(3);
        }])->first();

        $locations = Location::where('is_active', true)
            ->orderBy('order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'contact_us_content' => $contactUsContent,
                'locations' => $locations
            ]
        ]);
    }

    public function sendContactInquiry(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:30',
            'last_name'  => 'required|string|max:30',
            'company'    => 'nullable|string|max:50',
            'email'      => 'required|email|max:50',
            'phone'      => 'required|string|max:20',
            'inquiry_type'  => ['required', 'string', 'in:' . implode(',', InquiryTypesEnum::names())],
            'message'    => 'required|string',
        ]);

        $inquiryTypesEnum = InquiryTypesEnum::fromName($request->inquiry_type);

        ContactInquiry::create([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'company'       => $request->company,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'inquiry_type'  => $inquiryTypesEnum->value, // store numeric value
            'message'       => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your inquiry has been sent successfully.',
        ]);
    }

    public function seedTestData(Request $request)
    {
        $request->validate([
            'video' => 'required|file|mimetypes:video/mp4,video/webm|max:102400', // 100MB
        ]);

        // === Upload Hero Video ===
        $heroVideoPath = $request->file('video')->store('hero-videos', 'public');
        $heroVideoUrl = Storage::url($heroVideoPath);

        $hero = ContactUsContent::create([
            'title' => 'Get In Touch',
            'description' => "Whether you're exploring a partnership, need technical support, or just have a question—we’re here to help.",
            'video_url' => $heroVideoUrl,
            'contact_email' => 'info@prosoft.com.eg',
            'contact_phone' => "0235372575"
        ]);

        $hero->contactUsSections()->createMany([
            [
                'title' => 'General Inquiries',
                'description' => 'Reach out to learn how Prosoft can support your digital transformation journey or provide the right solutions for your business needs.'
            ],
            [
                'title' => 'Technical Support',
                'description' => 'Need help with implementation, integration, or troubleshooting? Our technical team is on hand to provide expert assistance.',
            ],
            [
                'title' => 'Feedback & Suggestions',
                'description' => 'We value your input. Share your experience or suggestions so we can continue improving the way we serve you.',
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Test data seeded successfully.',
        ]);
    }
}
