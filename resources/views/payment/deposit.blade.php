<x-layout>
    <x-slot:title>Deposit</x-slot:title>

    <div class="flex items-center justify-center min-h-[60vh]">
        <div
            class="w-full max-w-md p-8 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm">
            <div class="text-center mb-6">
                <h1 class="text-xl font-bold text-gray-800 dark:text-white">تأكيد عملية الدفع</h1>
                <div
                    class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/30 rounded-xl border border-blue-100 dark:border-blue-800">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">المبلغ الإجمالي</p>
                    {{-- <span class="text-3xl font-black text-white dark:text-text-white">${{ $deposit->amount }}</span> --}}
                </div>
            </div>

            @if (session('error'))
                <div
                    class="mb-4 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl text-red-700 dark:text-red-300 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div
                    class="mb-4 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-xl text-green-700 dark:text-green-300 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('payment.create') }}" method="POST">
                @csrf
                <input type="hidden" name="amount" value="{{ request('amount') }}">
                <input type="hidden" name="payment_data" value="{{ request('payment_data') }}">
                <button type="submit" class="btn btn-primary w-full rounded-2xl shadow-lg shadow-primary/20">
                    دفع
                </button>
            </form>

            <div id="loading-spinner" class="hidden text-center py-4">
                <p class="text-sm text-gray-500 dark:text-gray-400 animate-pulse">جاري معالجة العملية... لا تغلق الصفحة
                </p>
            </div>

        </div>
    </div>
</x-layout>
