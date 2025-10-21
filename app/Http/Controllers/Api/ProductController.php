<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Outfit;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProducts(Request $request)
    {
        $limit = $request->get('limit', 10);

        $products = Product::with('variants', 'category')->orderBy('id', 'desc')->cursorPaginate($limit);

        $flattened = $products->flatMap(function ($product) {
            return $product->variants->map(function ($variant) use ($product) {
                return [
                    'id' => $product->id,
                    'variantId' => $variant->id,
                    'name' => $product->name,
                    'slug' => $variant->slug,
                    'price' => (float) ($variant->price ?? $product->price),
                    'category' => $product->category?->name ?? null,
                    'color' => $variant->color,
                    'colorCode' => $variant->color_code,
                    'images' => [$product->image],
                    'otherVariants' => $product->variants
                        ->where('id', '!=', $variant->id)
                        ->map(fn($v) => [
                            'variantId' => $v->id,
                            'colorCode' => $v->color_code,
                            'slug' => $v->slug,
                            'images' => $v->images->pluck('image_url'),
                        ])
                        ->values(),
                    'isActive' => $variant->is_active,
                ];
            });
        })->values();


        return response()->json([
            'data' => $flattened,
            'meta' => [
                'next_cursor' => $products->nextCursor()?->encode(),
                'prev_cursor' => $products->previousCursor()?->encode(),
            ]
        ]);
    }

    public function getProductDetail(Request $request, $id)
    {
        $product = Product::with([
            'variants.sizes',
            'variants.images',
            'variants.details',
            'tags',
            'category',
            'reviews'
        ])->findOrFail($id);

        $variant = $product->variants->where('slug', $request->input('slug'))->first();

        $data = [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => (float) $product->price,
            'category' => $product->category?->name,
            'otherVariants' => $product->variants
                ->where('id', '!=', $variant->id)
                ->where('is_active', true)
                ->map(fn($v) => [
                    'id' => $v->id,
                    'colorCode' => $v->color_code,
                    'slug' => $v->slug,
                    'images' => $v->images->pluck('image_url')
                ])
                ->values(),
            'isActive' => $variant->is_active,
            'tags' => $product->tags->map(fn($t) => [
                'id' => $t->id,
                'name' => $t->name,
                'info' => $t->info,
            ]),
            'usage' => $product->usage,
            'technology' => $product->technology,
            'features' => explode(',', $product->features), // ubah string jadi array
            'composition' => $product->composition,
            'sustainability' => $product->sustainability,
            'warranty' => $product->warranty,
            'reviews' => $product->reviews->map(fn($r) => [
                'id' => $r->id,
                'user' => $r->user->name ?? 'Anonymous',
                'rating' => $r->rating,
                'comment' => $r->comment,
                'image' => $r->image ? asset('storage/' . $r->image) : null,
            ]),
            'variant' => [
                'id' => $variant->id,
                'slug' => $variant->slug,
                'inStock' => $variant->in_stock,
                'color' => $variant->color,
                'colorCode' => $variant->color_code,
                'sizes' => $variant->sizes->map(fn($s) => [
                    'id' => $s->id,
                    'size' => $s->size,
                    'stock' => $s->stock,
                ]),
                'images' => $variant->images->pluck('image_url'),
                'outfit' => Outfit::with('images')->where('id', $variant->outfit_id)->first(),
                'details' => $variant->details->map(fn($d) => [
                    'info' => $d->info,
                    'image' => asset('storage/' . $d->image),
                ]),
            ]
        ];

        return response()->json([
            'data' => $data
        ]);
    }

    public function getOutfits()
    {
        $outfits = Outfit::with('variants.product.category', 'variants.sizes', 'variants.images')->where('is_shown', true)->orderBy('id', 'desc')->get();

        $data = [];
        foreach ($outfits as $outfit) {
            if ($outfit->variants->isEmpty()) continue;

            $items = [
                'id' => $outfit->id,
                'model_name' => $outfit->model_name,
                'model_height' => $outfit->model_height,
                'model_size' => $outfit->model_size,
                'is_shown' => true,
                'outfitItems' => $outfit->variants->where('is_active', true)->map(function ($variant) {
                    return [
                        'id' => $variant->id,
                        'product_id' => $variant->product->id ?? null,
                        'name' => $variant->product->name ?? null,
                        'slug' => $variant->slug,
                        'price' => $variant->product->price ?? null,
                        'category' => $variant->product->category->name ?? null,
                        'color' => $variant->color,
                        'in_stock' => $variant->in_stock,
                        'image' => optional($variant->images->firstWhere('is_primary', true))->image_url ?? optional($variant->images->first())->image_url,
                        'sizes' => $variant->sizes->map(function ($size) {
                            return [
                                'id' => $size->id,
                                'name' => $size->size,
                                'stock' => $size->stock ?? null
                            ];
                        }),
                    ];
                }),
            ];
            $data[] = $items;
        }

        return response()->json([
            'data' => $data
        ]);
    }
}
