<x-layout>
    <x-slot:title>Pay with PayPal</x-slot:title>

    <div class="flex items-center justify-center min-h-[60vh]">
        <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm">
            <div class="text-center mb-6">
                <h1 class="text-xl font-bold text-gray-800 dark:text-white">تأكيد عملية الدفع</h1>
                <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/30 rounded-xl border border-blue-100 dark:border-blue-800">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">المبلغ الإجمالي</p>
                    <span class="text-3xl font-black text-white dark:text-text-white">${{ session('payment_amount') }}</span>
                </div>
            </div>

            <form action="{{ route('paypal.create') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary w-full rounded-2xl shadow-lg shadow-primary/20">
                    دفع
                </button>
            </form>

            <div id="loading-spinner" class="hidden text-center py-4">
                <p class="text-sm text-gray-500 dark:text-gray-400 animate-pulse">جاري معالجة العملية... لا تغلق الصفحة</p>
            </div>

            <p class="text-xs text-center text-gray-400 dark:text-gray-500 mt-6">
                سيتم تحويلك بشكل آمن عبر بوابة PayPal
            </p>
        </div>
    </div>
</x-layout>
