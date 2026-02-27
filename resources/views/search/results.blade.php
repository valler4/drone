<x-layout>
    <x-slot name="title">Search Results for: {{ $query }}</x-slot>

    <div class="space-y-6">
        <h2 class="text-2xl font-bold">Results for: "{{ $query }}"</h2>

        <section>
            <h3 class="text-lg font-semibold mb-4">Products ({{ $products->count() }})</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ($products as $product)
                    <a href="/products/{{ $product->id }}"
                        class="p-4 border rounded-lg shadow-sm bg-white dark:bg-zinc-800">
                        <h4 class="font-bold">{{ $product->name }}</h4>
                        <p class="text-sm text-gray-500">{{ Str::limit($product->description, 50) }}</p>
                    </a>
                @endforeach
            </div>
        </section>
        <div class="mt-4">
            {{ $products->links() }}
        </div>

        <hr class="border-zinc-200 dark:border-zinc-800">

        <section>
            <h3 class="text-lg font-semibold mb-4">Tickets ({{ $tickets->count() }})</h3>
            <flux:navlist>
                @foreach ($tickets as $ticket)
                    <flux:navlist.item href="/tickets/{{ $ticket->id }}">
                        {{ $ticket->subject }}
                    </flux:navlist.item>
                @endforeach
            </flux:navlist>
        </section>
        <div class="mt-4">
            {{ $tickets->links() }}
        </div>

        <hr class="border-zinc-200 dark:border-zinc-800">

        <section>
            <h3 class="text-lg font-semibold mb-4">Users ({{ $Users->count() }})</h3>
            <flux:navlist>
                @foreach ($Users as $user)
                    <flux:navlist.item href="/profile/{{ $user->id }}">
                        {{ $user->name }} ({{ $user->user_name }})
                    </flux:navlist.item>
                @endforeach
            </flux:navlist>
        </section>
        <div class="mt-4">
            {{ $Users->links() }}
        </div>
    </div>
</x-layout>
