<x-layout title="Create Product">
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create Product</h1>
            <flux:button as="a" href="{{ route('products.index') }}" variant="ghost">
                <flux:icon.arrow-left class="w-4 h-4 mr-2" />
                Back to Products
            </flux:button>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-md p-6">
            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf
                @method('post')
                <img src="{{ asset('images/default-product.jpg') }}" id="preview"
                    class="w-full h-48 object-cover rounded-t-lg">
                <flux:field>
                    <flux:label>Product Image</flux:label>
                    <flux:input name="product_image" type="file" onchange="previewImage(event)" />
                    @error('product_image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Optional: Upload a product image (JPG, PNG, GIF up to 5MB)
                    </p>
                </flux:field>
                <br>
                <div class="space-y-6">
                    <flux:field>
                        <flux:label>Product Name</flux:label>
                        <flux:input name="name" type="text" required value="{{ old('name') }}"
                            placeholder="Enter product name" />
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </flux:field>

                    <flux:field>
                        <flux:label>Description</flux:label>
                        <flux:textarea name="description" rows="4" placeholder="Enter product description" required value="{{ old('description') }}">
                        </flux:textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </flux:field>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label>Price</flux:label>
                            <flux:input name="price" type="number" step="0.01" min="0" required
                                value="{{ old('price') }}" placeholder="0.00" />
                            @error('price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </flux:field>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label>Stock Quantity</flux:label>
                            <flux:input name="quantity" type="number" min="0" required value="{{ old('quantity') }}" />
                            @error('quantity')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </flux:field>

                    </div>

                    <flux:field>
                        <flux:label>Is this product open to public?</flux:label>

                        <flux:radio.group name="status" variant="cards" class="flex gap-4">
                            <flux:radio label="Open" value="open" checked />
                            <flux:radio label="Close" value="close" />
                        </flux:radio.group>

                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </flux:field>

                </div>

                <div class="flex gap-4 mt-8">
                    <flux:button type="submit" variant="primary" class="flex-1">
                        <flux:icon.check class="w-4 h-4 mr-2" />
                        Create Product
                    </flux:button>
                    <flux:button as="a" href="{{ route('products.index') }}" variant="outline">
                        Cancel
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
