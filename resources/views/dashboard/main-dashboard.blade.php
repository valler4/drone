<x-dashboard-layout>
    <x-slot:title>Dashboard</x-slot:title>
    <body>
        @php
            $user = auth()->user();
        @endphp

        <script src="{{ asset('js/main.js') }}"></script>
    </body>
</x-dashboard-layout>
