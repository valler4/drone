<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use App\Traits\Logs;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\productRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use Logs, AuthorizesRequests;
    public function index(): View
    {
        $products = request()->user()->products()->latest()->paginate(30);

        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(productRequest $request): RedirectResponse
    {
        $productdata = $request->validated();
        $product = $request->user()->products()->create($productdata);

        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $fileName = $product->id . '.' . $file->extension();
            $path = $file->storeAs('products', $fileName, 'public');
            $product->update(['product_image' => $path]);
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function show(product $product): View
    {
        $this->authorize('view', $product);
        return view('products.show', compact('product'));
    }

    public function edit(product $product): View
    {
        $this->authorize('update', $product);
        return view('products.edit', compact('product'));
    }

    public function update(productRequest $request, product $product): RedirectResponse
    {
        $this->authorize('update', $product);
        $productdata = $request->validated();

        if ($request->hasFile('product_image')) {
            if ($product->product_image) {
                Storage::disk('public')->delete($product->product_image);
            }
            $file = $request->file('product_image');
            $fileName = $product->id . '.' . $file->extension();
            $path = $file->storeAs('products', $fileName, 'public');

            $productdata['product_image'] = $path;
        }

        $product->update($productdata);

        return redirect()->route('products.index')->with('success', 'product updated successfully');
    }

    public function destroy(Request $request, product $product): RedirectResponse
    {
        $this->authorize('view', $product);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'product deleted successfully');
    }

    public function close(Request $request, product $product): RedirectResponse
    {
        $this->authorize('view', $product);
        $product->update(['status' => 'close']);
        return redirect()->route('products.index')->with('success', 'product closed successfully');
    }

    public function open(Request $request, product $product): RedirectResponse
    {
        $this->authorize('view', $product);
        $product->update(['status' => 'open']);
        return redirect()->route('products.index')->with('success', 'product opened successfully');
    }
}
