<!DOCTYPE html>
<html lang="en" data-theme="lofi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>drone - Home</title>
</head>

<body class="min-h-screen flex flex-col bg-base-200 font-sans">
    <x-layout>
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
            <div class="success">
                {{ session('success') }}
            </div>
        @endif
        <script src="{{ asset('js/main.js') }}"></script>
    </x-layout>

</body>

</html>
