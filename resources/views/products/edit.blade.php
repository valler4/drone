<x-layout title="Edit Product | {{ $product->name ?? '' }}">
    <div class="max-w-2xl mx-auto space-y-6 px-4 py-8">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-black tracking-tighter">Edit Product</h1>
                    <a href="{{ route('products.index') }}"
                        class="flex items-center text-sm font-bold hover:opacity-70 transition-opacity">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Products
                    </a>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-slate-200 dark:border-zinc-800 p-8">
            <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <img src="{{ $product->image_url }}"
                        class="w-full h-56 object-cover rounded-xl border border-slate-100 dark:border-zinc-700">
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Product
                            Image</label>
                        <input name="product_image" type="file"
                            class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-slate-100 dark:file:bg-zinc-800 dark:file:text-slate-300 file:text-slate-700 hover:file:bg-slate-200">
                        @error('product_image')
                            <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Product
                            Name</label>
                        <input name="name" type="text" required value="{{ old('name', $product->name) }}"
                            class="w-full border border-slate-200 dark:border-zinc-700 dark:bg-zinc-800 rounded-xl px-4 py-2 focus:ring-2 focus:ring-primary outline-none text-slate-900 dark:text-white">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label
                            class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Description</label>
                        <textarea name="description" rows="4"
                            class="w-full border border-slate-200 dark:border-zinc-700 dark:bg-zinc-800 rounded-xl px-4 py-2 focus:ring-2 focus:ring-primary outline-none text-slate-900 dark:text-white">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Price
                                ($)</label>
                            <input name="price" type="number" step="0.01" min="0" required
                                value="{{ old('price', $product->price) }}"
                                class="w-full border border-slate-200 dark:border-zinc-700 dark:bg-zinc-800 rounded-xl px-4 py-2 text-slate-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Stock
                                Quantity</label>
                            <input name="quantity" type="number" min="0"
                                value="{{ old('quantity', $product->quantity ?? 0) }}"
                                class="w-full border border-slate-200 dark:border-zinc-700 dark:bg-zinc-800 rounded-xl px-4 py-2 text-slate-900 dark:text-white">
                        </div>
                    </div>

                        <div>
                            <label
                                class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Status</label>
                            <select name="status"
                                class="w-full border border-slate-200 dark:border-zinc-700 dark:bg-zinc-800 rounded-xl px-4 py-2 text-slate-900 dark:text-white">
                                <option value="open" {{ $product->status === 'open' ? 'selected' : '' }}>Open
                                </option>
                                <option value="close" {{ $product->status === 'close' ? 'selected' : '' }}>Close
                                </option>
                            </select>
                        </div>

                    <div
                        class="bg-slate-50 dark:bg-zinc-800/50 rounded-xl p-4 border border-slate-100 dark:border-zinc-800">
                        <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Technical Info</h3>
                        <div class="space-y-1 text-xs text-slate-600 dark:text-slate-400 font-medium">
                            <p>ID: <span
                                    class="font-mono text-slate-900 dark:text-slate-200">{{ $product->id }}</span></p>
                            <p>Created: {{ $product->created_at->format('M j, Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 mt-8">
                    <button type="submit"
                        class="flex-1 bg-emerald-600 text-white font-bold py-3 rounded-xl hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-900/10">
                        Update Product
                    </button>
                    <a href="{{ route('products.show', $product->id) }}"
                        class="flex-1 text-center border border-slate-200 dark:border-zinc-700 text-slate-700 dark:text-slate-300 font-bold py-3 rounded-xl hover:bg-slate-50 dark:hover:bg-zinc-800 transition-colors">
                        View
                    </a>
                </div>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-100 dark:border-zinc-800 text-center">
                <form method="POST" action="{{ route('products.destroy', $product->id) }}"
                    onsubmit="return confirm('Delete this product permanently?');">
                    @csrf
                    @method('delete')
                    <button type="submit"
                        class="text-red-600 dark:text-red-400 font-bold text-sm hover:underline flex items-center justify-center gap-2 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete Product
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
