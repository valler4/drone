<x-layout>
    <x-slot:title>Transaction</x-slot:title>

    <div class="flex justify-center items-center">
        <h1 class="text-2xl font-bold">Transfer</h1>
    </div>
    <a href="{{ route('transaction.create') }}" class="btn btn-primary">make transfer</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('transactions') }}"
        class="text-sm font-bold uppercase tracking-widest text-primary flex items-center gap-2 mb-2 hover:gap-3 transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
        </svg>
        Back
    </a>

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
            <p>Receiver ID: {{ $transaction->receiver_id }} . username : {{ $transaction->receiver->name }}</p>
            <p>Amount: {{ $transaction->amount }}</p>
            <p>Type: {{ $transaction->type }}</p>
            <p>Note: {{ $transaction->note }}</p>
            <p>Date: {{ $transaction->created_at }}</p>
        </div>
    </div>


</x-layout>
