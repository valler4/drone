<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransRequest;
use App\Models\transaction;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



class TransactionController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = $request->user();
        $transactions = transaction::with(['sender', 'receiver'])
            ->where('sender_id', $user->id)
            ->orwhere('receiver_id', $user->id)
            ->latest()
            ->paginate(30);
        return view('transactions.index', compact('user', 'transactions'));
    }

    public function create(Request $request)
    {
        $user = $request->user();
        return view('transactions.create', compact('user'));
    }

    public function show(transaction $transaction)
    {
        $this->authorize('view', $transaction);
        return view('transactions.show', compact('transaction'));
    }

    public function store(TransRequest $request)
    {

        if ($request->receiver_id == $request->user()->id) {
            return back()->withErrors(['error' => 'You cannot transfer money to yourself.']);
        }

        $sender = $request->user();
        $receiver = User::find($request->receiver_id);
        $amount = $request->amount;
        $note = $request->note;

        if ($sender->balance < $amount) {
            return back()->withErrors(['error' => 'not enough balance']);
        }
        DB::transaction(function () use ($sender, $receiver, $amount, $note) {
            $sender->decrement('balance', $amount);
            $receiver->increment('balance', $amount);
            transaction::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'amount' => $amount,
                'type' => 'transfer',
                'note' => $note,
            ]);
        });
        return redirect()->route('transactions')->with('success', 'Transfer completed successfully.');
    }
}
