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

        /* عشان نضمن ان Flux sidebar ياخد الطول الصح */
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
</head>

<body x-data="{ sidebarOpen: false }"
    class="h-screen flex flex-col font-sans antialiased overflow-hidden bg-white dark:bg-zinc-900">

    <nav class="navbar bg-base-100/80 backdrop-blur-md sticky top-0 z-50 border-b border-base-200 px-6 h-16 shrink-0">
        <div class="navbar-start">
            <a href="/home" class="w-24 text-xl font-black tracking-tight flex items-start gap-8">
                <span class="text-primary text-2xl">DRONE</span>
            </a>
        </div>
        <div class="navbar-end gap-6">
            @auth
                <button id="theme-toggle" class="btn btn-ghost btn-circle">🌙</button>
                <button class="btn btn-ghost btn-circle" @click="sidebarOpen = !sidebarOpen">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            @else
                <div class="flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-ghost btn-sm rounded-full">Log in</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-6 rounded-full">Sign up</a>
                </div>
            @endauth
        </div>
    </nav>

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
                    <flux:navlist.item icon="user" href="/profile">Profile</flux:navlist.item>
                    <flux:navlist.item icon="chart-bar" href="/dashboard">Dashboard</flux:navlist.item>
                    <flux:navlist.item icon="ticket" href="/tickets">Tickets</flux:navlist.item>
                    <flux:navlist.item icon="currency-dollar" href="/transactions">Transactions</flux:navlist.item>
                </flux:navlist>

                <flux:spacer />

                <flux:navlist>

                    <flux:navlist.item as="button" type="submit"
                        class="text-red-500 w-full" href="{{ route('amount') }}">
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
</body>

</html>
