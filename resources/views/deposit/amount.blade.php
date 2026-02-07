<x-layout>
    <x-slot:title>Deposit | إيداع</x-slot:title>

    <div class="flex items-center justify-center min-h-[60vh]">
        <div
            class="w-full max-w-md p-8 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">شحن الرصيد</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">حدد المبلغ الذي ترغب بإضافته لمحفظتك</p>
            </div>

            <form action="{{ route('amount.post') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">المبلغ المطلوب
                        (USD)</label>
                    <div class="relative">
                        <span
                            class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 dark:text-gray-400">$</span>
                        <input type="number" name="amount" min="1" step="0.01"
                            class="block w-full pl-8 pr-4 py-3 bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all placeholder-gray-400"
                            placeholder="0.00" required>
                        <flux:radio.group name="payment_method" variant="cards" class="flex gap-4">
                            <flux:radio label="paypal" value="paypal" checked />
                            <flux:radio label="stripe" value="stripe" />
                        </flux:radio.group>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition-all transform hover:scale-[1.02]">
                    متابعة للدفع
                </button>
            </form>
        </div>
    </div>
</x-layout>
