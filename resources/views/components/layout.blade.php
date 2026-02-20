<!DOCTYPE html>
<html lang="en" data-theme="lofi">

<head>
    <script>
        (function() {
            const userid = "{{ auth()->id() ?? 'guest' }}";
            const storagekey = `theme_user_${userid}`;
            const savedtheme = localStorage.getItem(storagekey);

            if (savedtheme === 'dark') {
                document.documentElement.classList.add('dark-mode');
                const css = 'html.dark-mode { background-color: #131314 !important; color: #e3e3e3 !important; }';
                const head = document.head || document.getElementsByTagName('head')[0];
                const style = document.createElement('style');
                style.appendChild(document.createTextNode(css));
                head.appendChild(style);
                document.head.appendChild(style);
            }
        })();
    </script>
    <style>
        body {
            background-color: var(--bg-main) !important;
            color: var(--text-main);
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .flux-sidebar-wrapper {
            height: 100% !important;
        }
    </style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Drone' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{ $head ?? '' }}
    @fluxAppearance
</head>

<body x-data="{ sidebarOpen: false }"
    class="h-screen flex flex-col font-sans antialiased overflow-hidden bg-white dark:bg-zinc-900">
    <flux:header sticky
        class="max-w-none w-full bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800">

        <flux:brand href="/home" name="DRONE" class="text-2xl font-bold text-gray-900 dark:text-white" />

        <flux:spacer />

        {{-- الـ navbar هنا بياخد العناصر وبيرصها صح --}}
        <flux:navbar class="gap-2 sm:gap-4">
            @auth

                <div class="flex items-center gap-2 bg-zinc-800 px-3 py-1.5 rounded-full border border-zinc-700">
                    <flux:icon.banknotes class="text-yellow-500 w-4 h-4" />
                    <span class="text-sm font-bold text-zinc-100">
                        {{ number_format(auth()->user()->balance, 2) }}
                    </span>
                </div>
                {{-- البروفايل الأول --}}
                <flux:dropdown position="bottom" align="end">
                    <flux:profile avatar="{{ auth()->user()->image_url }}" name="{{ Str::limit(auth()->user()->name, 10) }}"
                        class="cursor-pointer" />

                    <flux:menu>
                        <flux:menu.item icon="user-circle" href="/settings">settings</flux:menu.item>
                        <flux:menu.separator />
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle">Logout
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>

                <flux:button id="theme-toggle"/>

                <flux:navbar.item icon="bell" href="/notifications" label="Notifications" />

                {{-- زرار السايد بار --}}
                <flux:button variant="ghost" icon="bars-3" @click="sidebarOpen = !sidebarOpen" />
            @else
                <flux:navbar.item href="{{ route('login') }}">Log in</flux:navbar.item>
                <flux:button as="a" href="{{ route('register') }}" variant="primary" size="sm">Sign up
                </flux:button>
            @endauth
        </flux:navbar>
    </flux:header>

    <div class="flex flex-row-reverse flex-1 overflow-hidden h-[calc(100vh-4rem)] relative">

        @auth
            <flux:sidebar x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full" sticky
                class="bg-zinc-50 dark:bg-zinc-950 border-l border-zinc-200 dark:border-zinc-800 h-full w-64 shrink-0">
                <div class="flex justify-between items-center mb-6 lg:hidden">
                    <h3 class="font-bold uppercase text-xs">Menu</h3>
                    <flux:button variant="ghost" icon="x-mark" @click="sidebarOpen = false" />
                </div>

                <flux:navlist variant="outline">
                    <flux:navlist.item icon="home" href="/home">Home</flux:navlist.item>
                    <flux:navlist.item icon="chart-bar" href="/dashboard">Dashboard</flux:navlist.item>
                    <flux:navlist.item icon="ticket" href="/tickets">Tickets</flux:navlist.item>
                    <flux:navlist.item icon="archive-box" href="/products">products</flux:navlist.item>
                    <flux:navlist.item icon="currency-dollar" href="/transactions">Transactions</flux:navlist.item>
                    <flux:navlist.item icon="chat-bubble-left-ellipsis" href="/chat" >chat</flux:navlist.item>
                    @if (auth()->user()->IsAdmin())
                        <flux:navlist.item icon="cog-6-tooth" href="{{ route('admin.index') }}">Admin Link</flux:navlist.item>
                    @endif
                </flux:navlist>

                <flux:spacer />

                <flux:navlist>

                    <flux:navlist.item as="button" type="submit" icon="banknotes" class="text-red-500 w-full"
                        href="{{ route('payment_method') }}">
                        buy coins
                    </flux:navlist.item>

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:navlist.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                            class="text-red-500 w-full">
                            Logout
                        </flux:navlist.item>
                    </form>
                </flux:navlist>
            </flux:sidebar>
        @endauth

        <main class="flex-1 overflow-y-auto p-6 transition-all duration-300">
            {{ $slot }}
        </main>
    </div>

    @fluxScripts
    <script>
        window.userid = "{{ auth()->id() ?? 'guest' }}";
    </script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
