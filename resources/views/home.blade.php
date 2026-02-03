<x-layout>
<body class="min-h-screen flex flex-col bg-base-200 font-sans">
        <x-slot:title>
            home
        </x-slot:title>
        @php
            $user = auth()->user();
        @endphp
        <div class="max-w-2xl mx-auto">
            <div class="card bg-base-100 shadow mt-8">
                <div class="card-body">
                    <div>
                        <h1 class="text-3xl font-bold">Home</h1>
                        @auth
                            <div
                                class="w-24 h-24 rounded-full bg-base-300 shadow-2xl rotate-6 hover:rotate-0 transition-all duration-500 overflow-hidden border-2 border-primary/20">
                                <img src="{{ auth()->user()->image_url }}" alt="profile image"
                                    class="w-full h-full object-cover">
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div id="toast-success"
                class="alert alert-success rounded-2xl mb-8 shadow-lg shadow-success/10 border-none bg-success/10 text-success font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif


    </x-layout>

</body>

</html>
