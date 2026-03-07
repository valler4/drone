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
            return redirect()->back()->with('error', 'You cannot buy your own product');
        }
        if ($product->price > $buyer->balance) {
            return redirect()->back()->with('error', 'You do not have enough balance to buy this product');
        }
        if ($product->status == 'close') {
            return redirect()->back()->with('error', 'This product is closed');
        }
        if ($product->quantity <= 0) {
            return redirect()->back()->with('error', 'This product is out of stock');
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
