<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Support\Str;

class LiveChatController extends Controller
{
    public function startChat(Request $request)
    {
        // Jika user login
        if (auth()->check()) {
            $userId = auth()->id();

            // Cek apakah sudah ada chat aktif untuk user
            $chat = Chat::where('user_id', $userId)->latest()->first();

            if (!$chat) {
                $chat = Chat::create([
                    'user_id' => $userId,
                ]);
            }

            return response()->json(['chat_id' => $chat->id]);
        }

        // Jika belum login (guest)
        if (!$request->session()->has('guest_id')) {
            $request->session()->put('guest_id', Str::uuid()->toString());
        }

        $chat = Chat::where('guest_id', $request->session()->get('guest_id'))
            ->whereNull('user_id')
            ->latest()
            ->first();

        if (!$chat) {
            $chat = Chat::create([
                'guest_id' => $request->session()->get('guest_id'),
            ]);
        }

        return response()->json(['chat_id' => $chat->id]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'message' => 'required|string',
        ]);

        $message = ChatMessage::create([
            'chat_id' => $request->chat_id,
            'sender' => 'user', // atau 'guest' kalau mau pakai enum lebih kompleks
            'message' => $request->message,
        ]);

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function getMessages($chat_id)
    {
        $messages = ChatMessage::where('chat_id', $chat_id)->get();
        return response()->json($messages);
    }
}
