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

<body class="h-screen flex flex-col font-sans antialiased overflow-hidden">

    <nav class="navbar bg-base-100/80 backdrop-blur-md sticky top-0 z-50 border-b border-base-200 px-6">
        <div class="navbar-start">
            <a href="/home" class="w-24 text-xl navbar-start font-black tracking-tight flex items-start gap-8">
                <span class="text-primary text-2xl">DRONE</span>
            </a>
        </div>

        <div class="navbar-end gap-6">
            <button class="btn btn-ghost btn-circle" onclick="togglesidebar()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            <aside id="mysidebar" class="sidebar dark:bg-slate-950 dark:border-slate-800">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="font-bold uppercase tracking-widest text-xs dark:text-slate-400">Menu</h3>
                    <button class="btn btn-sm btn-circle btn-ghost dark:text-slate-400"
                        onclick="togglesidebar()">✕</button>
                </div>

                <ul class="menu w-full p-0 gap-2">
                    <li>
                        <a href="/home"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-primary/10 transition-all group">
                            <span class="group-hover:scale-110 transition-transform">🏠</span>
                            <span class="font-bold dark:text-slate-200">Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-primary/10 transition-all group">
                            <span class="group-hover:scale-110 transition-transform">📊</span>
                            <span class="font-bold dark:text-slate-200">dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="/profile"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-primary/10 transition-all group">
                            <span class="group-hover:scale-110 transition-transform">👤</span>
                            <span class="font-bold dark:text-slate-200">Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="/tickets"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-primary/10 transition-all group">
                            <span class="group-hover:scale-110 transition-transform">🎫</span>
                            <span class="font-bold dark:text-slate-200">Tickets</span>
                        </a>
                    </li>
                    <li class="mt-8 pt-4 border-t border-base-200 dark:border-slate-800">
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-error btn-outline btn-sm w-full rounded-xl gap-2">
                                <span>🚪</span> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </aside>
            <button id="theme-toggle" class="btn btn-ghost btn-circle">🌙</button>
        </div>
    </nav>

    <div class="flex flex-1 overflow-hidden relative">

        <aside class="hidden md:flex w-64 border-e border-base-200 bg-base-100 flex-col p-4 gap-4 flex-none h-full">
            <ul class="menu w-full p-0 gap-2">
                <li><a href="/log-dashboard" class="{{ request()->is('log-dashboard') ? 'active' : '' }}">LOGS</a></li>
                <li><a href="#">#</a></li>
                <li><a href="#">#</a></li>
            </ul>
            <div class="flex-1"></div>
            <div class="bg-primary/5 p-4 rounded-2xl text-center">
                <p class="text-xs font-medium">Need Help?</p>
                <a href="/support" class="btn btn-primary btn-sm btn-block mt-2">Support</a>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto p-6">
            {{ $slot }}
        </main>

    </div>

    <script>
        window.userid = "{{ auth()->id() ?? 'guest' }}";
    </script>
</body>

</html>
