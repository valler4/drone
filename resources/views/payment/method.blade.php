<x-layout>
    <x-slot:title>Deposit | إيداع</x-slot:title>

    <div class="flex items-center justify-center min-h-[60vh]">
        <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">شحن الرصيد</h1>
                <p class="text-sm text-gray-500 mt-2">حدد المبلغ وطريقة الدفع</p>
            </div>

            <form action="{{ route('payment_method.post') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">المبلغ المطلوب (USD)</label>
                    <input type="number" name="amount" min="1" step="0.01"
                        class="block w-full px-4 py-3 text-gray-950 rounded-xl shadow-sm transition-all"
                        placeholder="0.00" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">طريقة الدفع</label>
                    <flux:radio.group name="payment_method" variant="cards" class="flex gap-4">
                        <flux:radio label="PayPal" value="paypal" />
                        <flux:radio label="Stripe" value="stripe" />
                    </flux:radio.group>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition-all transform hover:scale-[1.02]">
                    تأكيد والدفع الآن
                </button>
            </form>
        </div>
    </div>
</x-layout>
