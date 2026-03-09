<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TransRequest;
use App\Models\transaction;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;

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
            ->get(); //
        return response()->json([
            'success' => true,
            'transactions' => TransactionResource::collection($transactions)
        ], 200);
    }

    public function show(transaction $transaction)
    {
        $this->authorize('view', $transaction);
        return response()->json([
            'success' => true,
            'transaction' => new TransactionResource($transaction)
        ], 200);
    }

    public function store(TransRequest $request)
    {

        if ($request->receiver_id == $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot transfer to yourself'
            ], 400);
        }

        $sender = $request->user();
        $receiver = User::find($request->receiver_id);
        $amount = $request->amount;
        $note = $request->note;
        $newTransaction = null;

        if ($sender->balance < $amount) {
            return response()->json([
                'success' => false,
                'message' => 'not enough balance'
            ], 400);
        }
        DB::transaction(function () use ($sender, $receiver, $amount, $note, &$newTransaction) {
            $sender->decrement('balance', $amount);
            $receiver->increment('balance', $amount);
                $newTransaction = transaction::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'amount' => $amount,
                'type' => 'transfer',
                'note' => $note,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Transaction successful',
            'transaction' => new TransactionResource($newTransaction)
        ], 200);
    }
}
