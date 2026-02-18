<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Chat extends Component
{
    public $users;
    public $selectedUser;
    public $newMessage;
    public $messages;
    public $loginId;
    public $limit = 15;

    public function mount()
    {
        $this->users = User::whereNot('id', Auth::id())->get();
        $this->selectedUser = $this->users->first();
        $this->loadMessages();
        $this->loginId = Auth::id();
    }

    public function selectUser($id)
    {
        $this->selectedUser = User::find($id);
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = Message::query()
            ->where(function ($q) {
                $q->where('sender_id', Auth::id())
                    ->where('receiver_id', $this->selectedUser->id);
            })
            ->orWhere(function ($q) {
                $q->where('receiver_id', Auth::id())
                    ->where('sender_id', $this->selectedUser->id);
            })->latest()->take($this->limit)->get()->reverse();
    }

    public function loadMore()
    {
        $this->limit += 30;
        $this->loadMessages();
    }

    public function submit()
    {
        if (!trim ($this->newMessage)) return;

        $NewMessageData = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedUser->id,
            'message' => $this->newMessage,
        ]);

        $this->messages->push($NewMessageData);

        $messageText = $this->newMessage;
        $this->newMessage = '';

        broadcast(new MessageSent($NewMessageData))->toOthers();
    }

    protected $listeners = [
        'messageReceived' => 'newChatMessageNotification'
    ];

    public function newChatMessageNotification($message)
    {
        if (! isset($message['sender_id'])) return;

        if (! $this->selectedUser) return;

        if ($message['sender_id'] == $this->selectedUser->id) {
            $newMessages = Message::find($message['id']);
            if ($newMessages) {
                $this->messages->push($newMessages);
            }
        }
    }

    public function render()
    {
        return view('livewire.chat')->layout('components.layout');
    }
}
