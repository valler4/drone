<x-layout>
    <x-slot:title>Transaction</x-slot:title>

    <div class="flex justify-center items-center">
        <h1 class="text-2xl font-bold">Transfer</h1>
    </div>
    <a href="{{ route('transaction.create') }}" class="btn btn-primary">make transfer</a>

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

    @foreach ($transactions as $transaction)
        <div class="card w-full max-w-md bg-base-100 shadow-xl my-4">
            <a href="{{ route('transaction.show', $transaction) }}"
                class="btn btn-ghost btn-sm rounded-xl dark:text-white">View</a>
            <div class="card-body">
                @if ($transaction->sender->id === auth()->user()->id)
                    <h2 class="card-title text-green-600">You sent a transfer</h2>
                @else
                    <h2 class="card-title text-blue-600">You received a transfer</h2>
                @endif
                <h2 class="card-title">Transaction ID: {{ $transaction->id }}</h2>
                <p>Sender ID: {{ $transaction->sender_id }} . username : {{ $transaction->sender->name }}</p>
                <p>Receiver ID: {{ $transaction->receiver_id}} . username : {{$transaction->receiver->name }}</p>
                <p>Amount: {{ $transaction->amount }}</p>
                <p>Type: {{ $transaction->type }}</p>
                <p>Note: {{ $transaction->note }}</p>
                <p>Date: {{ $transaction->created_at }}</p>
            </div>
        </div>
    @endforeach

    {{ $transactions->links() }}


</x-layout>
