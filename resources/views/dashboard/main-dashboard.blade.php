<x-dashboard-layout>
    <x-slot:title>Dashboard</x-slot:title>
    @php
        $user = auth()->user();
    @endphp

<div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 mt-4">
    <h2 class="text-gray-600 dark:text-gray-300 text-sm font-medium">رصيدك الحالي</h2>
    <p class="text-3xl font-bold text-white dark:text-white mt-1">
        ${{ number_format(auth()->user()->balance, 2) }}
    </p>
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

        @if (session('error'))
            <div id="toast-error"
                class="alert alert-error rounded-2xl mb-8 shadow-lg shadow-error/10 border-none bg-error/10 text-error font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        
</x-dashboard-layout>
