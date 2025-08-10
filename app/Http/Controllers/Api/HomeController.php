<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Setting;
use App\Models\Solution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function getHomePage(Request $request)
    {
        $partnerLogos = Partner::pluck('inner_logo')->take(6)->toArray();
        $solutions = Solution::select('id', 'title', 'image')->limit(6)->get();

        return response()->json([
            'success' => true,
            'data' => [
                'partners' => $partnerLogos,
                'solutions' => $solutions
            ]
        ]);
    }

    public function seed(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:5120', // 5MB
        ]);

        $imagePath = $request->file('image')->store('images', 'public');
        $imageUrl = Storage::url($imagePath);

        Solution::find(1)->update([
            'image' => $imageUrl
        ]);

        return response()->json(['success' => true]);
    }
}
