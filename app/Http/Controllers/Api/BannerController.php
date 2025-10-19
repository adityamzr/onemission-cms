<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function getAll()
    {
        $banners = Banner::select('id', 'url', 'is_primary')->where('is_active', true)->get();

        if (!$banners) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get banners'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Succeed to get banners',
            'data' => $banners
        ], 200);
    }
}
