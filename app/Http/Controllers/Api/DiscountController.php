<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function checkDiscount(Request $request)
    {
        $discount = Discount::select('id', 'code', 'value')->where('code', $request->input('code'))->first();

        if (!$discount) {
            return response()->json([
                'success' => false,
                'message' => 'Discount not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Succeed to get discount',
            'data' => $discount
        ], 200);
    }
}
