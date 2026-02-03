<x-layout title="Product | {{ $product->name ?? 'Product' }}">
    @if (isset($product))
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <flux:button as="a" href="{{ route('products.index') }}" variant="ghost" size="sm">
                        <flux:icon.arrow-left class="w-4 h-4 mr-2" />
                        Back
                    </flux:button>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $product->name }}</h1>
                        <p class="text-gray-600 dark:text-gray-400">Product Details</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    @if($product->user_id === auth()->user()->id)
                    <flux:button as="a" href="{{ route('products.edit', $product->id) }}" variant="outline">
                        <flux:icon.pencil class="w-4 h-4 mr-2" />
                        Edit
                    </flux:button>
                    @endif
                    <flux:button as="a" href="{{ route('products.create') }}" variant="primary">
                        <flux:icon.plus class="w-4 h-4 mr-2" />
                        New Product
                    </flux:button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-md overflow-hidden">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                class="w-full h-64 object-cover">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                        {{ $product->name }}</h2>
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="text-3xl font-bold text-green-600 dark:text-green-400">${{ number_format($product->price, 2) }}</span>
                                        @if ($product->status == 'open')
                                            <span
                                                class="bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 text-sm px-3 py-1 rounded-full">
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200 text-sm px-3 py-1 rounded-full">
                                                Inactive
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                                <div class="border-t border-gray-200 dark:border-zinc-700 pt-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Description
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                        {{ $product->description }}</p>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Product Information</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Product ID</span>
                                <span
                                    class="font-mono text-sm text-gray-900 dark:text-white">{{ $product->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Stock</span>
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ $product->quantity ?? 0 }} units
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Price</span>
                                <span
                                    class="font-semibold text-green-600 dark:text-green-400">${{ number_format($product->price, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Timestamps</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-gray-600 dark:text-gray-400 text-sm">Created</span>
                                <p class="text-gray-900 dark:text-white font-medium">
                                    {{ $product->created_at->format('M j, Y g:i A') }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-gray-400 text-sm">Last Updated</span>
                                <p class="text-gray-900 dark:text-white font-medium">
                                    {{ $product->updated_at->format('M j, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions</h3>
                        <div class="space-y-2">
                            @if($product->user_id === auth()->user()->id)
                            <flux:button as="a" href="{{ route('products.edit', $product->id) }}"
                                variant="outline" class="w-full">
                                <flux:icon.pencil class="w-4 h-4 mr-2" />
                                Edit Product
                            </flux:button>
                            @if ($product->status === 'open')
                                <form method="post" action="{{ route('products.close', $product->id) }}">
                                    @csrf
                                    @method('patch')
                                    <flux:button type="submit" variant="primary" color="cyan" size="sm"
                                        class="w-full">
                                        <flux:icon.lock-closed class="w-4 h-4 mr-2" />
                                        close Product
                                    </flux:button>
                                </form>
                            @elseif ($product->status === 'close')
                                <form method="post" action="{{ route('products.open', $product->id) }}">
                                    @csrf
                                    @method('patch')
                                    <flux:button type="submit" variant="primary" color="cyan" size="sm"
                                        class="w-full">
                                        <flux:icon.lock-open class="w-4 h-4 mr-2" />
                                        open Product
                                    </flux:button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('products.destroy', $product->id) }}"
                                onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.');">
                                @csrf
                                @method('delete')
                                <flux:button type="submit" variant="danger" class="w-full">
                                    <flux:icon.trash class="w-4 h-4 mr-2" />
                                    Delete Product
                                </flux:button>
                            </form>
                            @else
                                <form action="{{ route('purchase', $product->id) }}" method="POST">
                                    @csrf
                                    <flux:button type="submit" variant="primary" class="w-full">
                                        buy
                                    </flux:button>
                                </form>
                            @endif
                            @error('error')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <flux:icon.exclamation-triangle class="w-16 h-16 text-red-500 mx-auto mb-4" />
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Product Not Found</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-4">The product you're looking for doesn't exist.</p>
            <flux:button as="a" href="{{ route('products.index') }}" variant="primary">
                Back to Products
            </flux:button>
        </div>
    @endif
</x-layout>
