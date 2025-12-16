<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagingController extends Controller
{
    /**
     * Display a listing of conversations.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get all conversations for the user, ordered by latest message
        $conversations = $user->conversations()
            ->with(['users', 'messages' => function($query) {
                $query->latest()->limit(1);
            }])
            ->get()
            ->sortByDesc(function($conversation) {
                return $conversation->latestMessage?->created_at ?? $conversation->created_at;
            });

        return view('messaging.index', compact('conversations'));
    }

    /**
     * Show the chat for a specific conversation.
     */
    public function show(Conversation $conversation)
    {
        // specific conversation view
        $this->authorize('view', $conversation);
        
        $user = Auth::user();

        // Mark messages as read
        $conversation->messages()
            ->where('user_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $conversations = $user->conversations()
        ->with(['users', 'messages' => function($query) {
            $query->latest()->limit(1);
        }])
        ->get()
        ->sortByDesc(function($conversation) {
            return $conversation->latestMessage?->created_at ?? $conversation->created_at;
        });

        $messages = $conversation->messages()->with('user')->oldest()->get();

        return view('messaging.show', compact('conversation', 'conversations', 'messages'));
    }

    /**
     * Start a new conversation or redirect to existing.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);

        $userId = Auth::id();
        $receiverId = $request->receiver_id;

        if ($userId == $receiverId) {
            return back()->with('error', 'You cannot message yourself.');
        }

        // Check if conversation already exists
        // This is a bit complex with many-to-many, simplified approach:
        // Find conversations where both users are participants
        $conversation = Conversation::whereHas('users', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->whereHas('users', function ($q) use ($receiverId) {
            $q->where('user_id', $receiverId);
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create();
            $conversation->users()->attach([$userId, $receiverId]);
        }

        return redirect()->route('messaging.show', $conversation);
    }

    /**
     * Send a message in a conversation.
     */
    public function reply(Request $request, Conversation $conversation)
    {
        $this->authorize('view', $conversation);
        
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $conversation->messages()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        $conversation->touch(); // Update updated_at of conversation

        return redirect()->route('messaging.show', $conversation);
    }
}
