<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function getMessages($receiver_id, Request $request)
    {
        $auth_id = Auth::id();
        $last_message_id = $request->query('last_id');

        $query = Message::where(function ($q) use ($auth_id, $receiver_id) {
            $q->where('sender_id', $auth_id)->where('receiver_id', $receiver_id);
        })
            ->orWhere(function ($q) use ($auth_id, $receiver_id) {
                $q->where('receiver_id', $auth_id)->where('sender_id', $receiver_id);
            });

        if ($last_message_id) {
            $query->where('id', '<', $last_message_id);
        }

        $messages = $query->latest()
            ->take(30)
            ->get()
            ->reverse();

        return response()->json($messages, 201);
    }

    public function sendMessage(Request $request)
    {
        $msg = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($msg))->toOthers();

        return response()->json($msg, 201);
    }
}
