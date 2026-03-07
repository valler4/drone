<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\Logs;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\productRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use Logs, AuthorizesRequests;

    public function index()
    {
        $products = Product::where('status', 'open')->latest()->paginate(30);

        return response()->json([
            'success' => true,
            'products' => new ProductResource($products),
        ], 200);
    }

    public function mine()
    {
        $products = request()->user()->products()->latest()->paginate(30);
        return response()->json([
            'success' => true,
            'products' => new ProductResource($products),
        ], 200);
    }

    public function store(productRequest $request)
    {
        $productData = $request->validated();
        $product = $request->user()->products()->create($productData);

        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $fileName = $product->id . '.' . $file->extension();
            $path = $file->storeAs('products', $fileName, 'public');
            $product->update(['product_image' => $path]);
        }

        return response()->json([
            'success' => true,
            'message' => 'product created successfully',
            'product' => new ProductResource($product),
        ], 201);
    }

    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'product' => new ProductResource($product),
        ], 200);
    }

    public function update(productRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        $productData = $request->validated();

        if ($request->hasFile('product_image')) {
            if ($product->product_image) {
                Storage::disk('public')->delete($product->product_image);
            }
            $file = $request->file('product_image');
            $fileName = $product->id . '.' . $file->extension();
            $path = $file->storeAs('products', $fileName, 'public');

            $productData['product_image'] = $path;
        }

        $product->update($productData);

        return response()->json([
            'success' => true,
            'message' => 'product updated successfully',
            'product' => new ProductResource($product),
        ], 200);
    }

    public function destroy(Product $product)
    {
        $this->authorize('view', $product);
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'product deleted successfully',
        ], 200);
    }

    public function close(Product $product)
    {
        $this->authorize('view', $product);
        $product->update(['status' => 'close']);
        return response()->json([
            'success' => true,
            'message' => 'product closed successfully',
        ], 200);
    }

    public function open(Product $product)
    {
        $this->authorize('view', $product);
        $product->update(['status' => 'open']);
        return response()->json([
            'success' => true,
            'message' => 'product opened successfully',
        ], 200);
    }
}
