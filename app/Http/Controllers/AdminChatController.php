<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\TypingStatus;
use Illuminate\Support\Carbon;



class AdminChatController extends Controller
{
    public function index()
    {
        $chats = Chat::latest()->get();

        return view('admin.live-chat', compact('chats'));
    }

    public function show($id)
    {
        $chat = Chat::with('messages')->findOrFail($id);
        $messages = $chat->messages()->orderBy('created_at')->get();

        // Tandai semua pesan dari user sebagai terbaca
        ChatMessage::where('chat_id', $chat->id)
            ->where('sender', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        ChatMessage::where('chat_id', $chat->id)
            ->where('sender', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);


        return view('admin.live-chat-detail', [
            'chat' => $chat,
            'messages' => $chat->messages
        ]);
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        ChatMessage::create([
            'chat_id' => $id,
            'sender' => 'admin',
            'message' => $request->message,
            'is_read' => false
        ]);

        return redirect()->route('admin.chat.show', $id);
    }

    public function setTypingStatus(Request $request, $chatId)
    {
        $sender = auth()->check() ? 'admin' : 'user'; // Atur sesuai pengirim
        $isTyping = $request->input('is_typing', false);

        TypingStatus::updateOrCreate(
            ['chat_id' => $chatId, 'typing_by' => $sender],
            [
                'is_typing' => $isTyping,
                'updated_at' => Carbon::now()
            ]
        );

        return response()->json(['success' => true]);
    }

    public function getTypingStatus($chatId)
    {
        $typing = TypingStatus::where('chat_id', $chatId)
            ->where('typing_by', 'admin') // Kalau mau user → ganti
            ->first();

        return response()->json([
            'is_typing' => $typing && $typing->is_typing
                && now()->diffInSeconds($typing->updated_at) < 5 // expired setelah 5 detik
        ]);
    }

    public function getMessages(Chat $chat)
    {
        $messages = $chat->messages()->orderBy('created_at')->get();

        return response()->json([
            'messages' => $messages
        ]);
    }
}
