<x-layout>
    <x-slot:title>Transaction</x-slot:title>

    <div class="flex justify-center items-center">
        <h1 class="text-2xl font-bold">Transfer</h1>
    </div>

    <form action="{{ route('transaction.store') }}" method="post">
        @csrf
        @method('post')
        <input type="strange" name="receiver_id" placeholder="receiver_id" class="input input-bordered w-full max-w-xs mb-4">
        <input type="strange" name="amount" placeholder="Amount" class="input input-bordered w-full max-w-xs mb-4">
        <input type="text" name="note" placeholder="Note" class="input input-bordered w-full max-w-xs mb-4">
        <button type="submit" class="btn btn-primary">Send</button>
    </form>


</x-layout>
