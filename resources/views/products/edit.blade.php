<x-layout title="Edit Product | {{ $product->name ?? '' }}">
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Product</h1>
            <flux:button as="a" href="{{ route('products.index') }}" variant="ghost">
                <flux:icon.arrow-left class="w-4 h-4 mr-2" />
                Back to Products
            </flux:button>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-md p-6">
            <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <img src="{{ $product->image_url }}" id="preview" class="w-full h-48 object-cover rounded-t-lg">
                <flux:field>
                    <flux:label>Product Image</flux:label>
                    <flux:input name="product_image" type="file" onchange="previewImage(event)" />
                    @error('product_image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        leave empty if you don't want to update the image
                    </p>
                </flux:field>
                <br>
                <div class="space-y-6">
                    <flux:field>
                        <flux:label>Product Name</flux:label>
                        <flux:input name="name" type="text" required value="{{ old('name', $product->name) }}"
                            placeholder="Enter product name" />
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </flux:field>

                    <flux:field>
                        <flux:label>Description</flux:label>
                        <flux:textarea name="description" rows="4" placeholder="Enter product description">
                            {{ old('description', $product->description) }}</flux:textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </flux:field>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label>Price</flux:label>
                            <flux:input name="price" type="number" step="0.01" min="0" required
                                value="{{ old('price', $product->price) }}" placeholder="0.00" />
                            @error('price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </flux:field>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label>Stock Quantity</flux:label>
                            <flux:input name="quantity" type="number" min="0"
                                value="{{ old('quantity', $product->quantity ?? 0) }}" placeholder="0" />
                            @error('quantity')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </flux:field>

                    </div>


                    @if ($product->status === 'open')
                    <flux:radio.group name="status" variant="cards" class="flex gap-4">
                        <flux:radio label="Open" value="open" checked />
                        <flux:radio label="Close" value="close" />
                    </flux:radio.group>
                    @elseif ($product->status === 'close')
                    <flux:radio.group name="status" variant="cards" class="flex gap-4">
                        <flux:radio label="Open" value="open" />
                        <flux:radio label="Close" value="close" checked />
                    </flux:radio.group>
                    @endif

                    <div class="bg-gray-50 dark:bg-zinc-700/50 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Information</h3>
                        <div class="space-y-1 text-sm text-gray-600 dark:text-gray-400">
                            <p>ID: {{ $product->id }}</p>
                            <p>Created: {{ $product->created_at->format('M j, Y g:i A') }}</p>
                            <p>last Update: {{ $product->updated_at->format('M j, Y g:i A') }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 mt-8">
                    <flux:button type="submit" variant="primary" color="emerald" class="flex-1">
                        Update Product
                    </flux:button>
                    <flux:button as="a" href="{{ route('products.show', $product->id) }}" variant="outline">
                        View
                    </flux:button>
                    <flux:button as="a" href="{{ route('products.index') }}" variant="ghost">
                        Cancel
                    </flux:button>
                </div>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-zinc-700">
                <form method="POST" action="{{ route('products.destroy', $product->id) }}">
                    @csrf
                    @method('delete')
                    <flux:button type="submit" variant="danger" size="sm" class="w-full">
                        <flux:icon.trash class="w-4 h-4 mr-2" />
                        Delete Product
                    </flux:button>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-layout>
