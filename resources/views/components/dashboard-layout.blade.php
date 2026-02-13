<x-layout>
    <x-slot:title>{{ $title ?? 'Dashboard - Drone' }}</x-slot:title>

    @isset($head)
        <x-slot:head>{{ $head }}</x-slot:head>
    @endisset

    <div class="flex h-full overflow-hidden">
        <aside
            class="hidden md:flex w-64 border-e border-base-200 bg-base-100 flex-col p-4 gap-4 flex-none h-full shadow-sm rounded-r-2xl">
            <ul class="menu w-full p-0 gap-2">
                <li>
                    <a href="/log-dashboard" @class([
                        'active' => request()->is('log-dashboard'),
                        'rounded-xl font-bold',
                    ])>
                        <span>📜</span> LOGS
                    </a>
                </li>
            </ul>

            <div class="flex-1"></div>

            <div class="bg-primary/5 p-4 rounded-3xl border border-primary/10 text-center">
                <p class="text-[10px] font-bold uppercase tracking-tighter text-primary/60">System Status</p>
                <p class="text-xs font-black mt-1">All Systems Operational</p>
                <a href="/support" class="btn btn-primary btn-sm btn-block mt-3 rounded-2xl shadow-md">Support</a>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto p-6">
            {{ $slot }}
        </main>
    </div>
</x-layout>
