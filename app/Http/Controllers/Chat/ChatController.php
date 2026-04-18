<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Message\MessageRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

    public function index(User $user)
    {
        $messages = $this->getChatMessages($user);
        return view('chat.show', compact('user', 'messages'));
    }
    public function store(MessageRequest $request, User $user)
    {
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'product_id' => $data->product_id ?? null,
            'message' => $request->message,
        ]);

        if ($message) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error'], 500);
    }

    public function fetchMessages(User $user)
    {
        $messages = $this->getChatMessages($user);
        return view('partials.messages', compact('messages'));
    }

    private function getChatMessages(User $user)
    {
        return Message::where(function ($q) use ($user) {
            $q->where('sender_id', Auth::id())
                ->where('receiver_id', $user->id);
        })
            ->orWhere(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                    ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function inbox()
    {
        $conversations = Message::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($message) {
                return $message->sender_id == Auth::id() ? $message->receiver : $message->sender;
            })
            ->unique('id');

        return view('chat.inbox', compact('conversations'));
    }
}
