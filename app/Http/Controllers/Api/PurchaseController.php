<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\product;
use App\Models\purchase;
use Illuminate\Support\Facades\DB;
use App\Traits\Logs;

class PurchaseController extends Controller
{
        use Logs;
    public function purchase(Request $request, product $product)
    {
        $buyer = $request->user();
        $seller = $product->user;
        $quantity = $request->input('quantity', 1);

        if ($buyer->id == $seller->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot buy your own product!'
            ], 400);
        }
        if ($product->price > $buyer->balance) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have enough balance to buy this product!'
            ], 400);
        }
        if ($product->status == 'close') {
            return response()->json([
                'success' => false,
                'message' => 'This product is closed!'
            ], 400);
        }
        if ($product->quantity <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'This product is out of stock!'
            ], 400);
        }

        DB::transaction(function () use ($buyer, $seller, $product, $quantity) {
            $buyer->decrement('balance', $product->price);
            $seller->increment('balance', $product->price);

            purchase::create([
                'buyer_id' => $buyer->id,
                'seller_id' => $seller->id,
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $quantity,
            ]);

            $product->decrement('quantity');
        });

        return response()->json([
            'success' => true,
            'message' => 'Purchase successful!',
        ], 200);
    }
}
