<x-layout title="Products">
    <div class="space-y-1">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold">My Products</h1>
            <flux:button as="a" href="{{ route('products.create') }}" variant="primary">
                create Product
            </flux:button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="group bg-white dark:bg-zinc-800 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 relative overflow-hidden">
                    <div class="relative">
                        <img src="{{ $product->image_url }}" class="w-full h-48 object-cover rounded-t-lg">
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center gap-2">
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('delete')
                                <flux:button type="submit" variant="danger" size="sm" onclick="return confirm('Are you sure you want to delete this product?')">
                                    <flux:icon.trash class="w-4 h-4" />
                                </flux:button>
                            </form>
                            @if($product->status === 'open')
                                <form action="{{ route('products.close', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('patch')
                                    <flux:button type="submit" variant="primary" color="orange" size="sm">
                                        <flux:icon.lock-closed class="w-4 h-4" />
                                    </flux:button>
                                </form>
                            @elseif ($product->status === 'close')
                                <form action="{{ route('products.open', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('patch')
                                    <flux:button type="submit" variant="primary" color="orange" size="sm">
                                        <flux:icon.lock-open class="w-4 h-4" />
                                    </flux:button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="p-4">
                        <h3 class="font-semibold text-lg text-gray-900 dark:text-white mb-2">{{ Str::limit($product->name ?? 'No name', 25) }}</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">{{ Str::limit($product->description ?? 'No description', 30) }}</p>

                        <div class="flex justify-between items-center mb-3">
                            <span class="text-2xl font-bold text-green-600 dark:text-green-400">${{ number_format($product->price, 2) }}</span>
                            @if($product->category)
                                <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200 text-xs px-2 py-1 rounded-full">
                                    {{ $product->category }}
                                </span>
                            @endif
                        </div>

                        <div class="flex gap-2">
                            <flux:button as="a" href="{{ route('products.show', $product->id) }}" variant="outline" size="sm" class="flex-1">
                                View
                            </flux:button>
                            <flux:button as="a" href="{{ route('products.edit', $product->id) }}" variant="ghost" size="sm">
                                <flux:icon.pencil class="w-4 h-4" />
                            </flux:button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <flux:icon.cube class="w-16 h-16 text-gray-400 mx-auto mb-4" />
                    <h3 class="text-lg font-medium ">No products found</h3>
                    <p class=" mb-4">Get started by creating your first product.</p>
                    <flux:button as="a" href="{{ route('products.create') }}" variant="primary">
                        <flux:icon.plus class="w-4 h-4 mr-2" />
                        Add Product
                    </flux:button>
                </div>
            @endforelse
        </div>

        @if(isset($products) && $products->hasPages())
            <div class="flex justify-center">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</x-layout>
