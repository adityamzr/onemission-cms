<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function getAll()
    {
        $gallery = Gallery::select('id', 'url')
            ->where('is_active', true)
            ->get()
            ->map(function ($gallery) {
                $gallery->url = asset('storage/' . $gallery->url);
                return $gallery;
            });

        if (!$gallery) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get photos'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Succeed to get photos',
            'data' => $gallery
        ], 200);
    }
}
