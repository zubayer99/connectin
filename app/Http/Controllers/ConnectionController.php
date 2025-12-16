<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    /**
     * Display "My Network" page with stats, pending requests, and suggestions.
     */
    public function index()
    {
        $user = Auth::user();

        // Pending Requests
        $pendingRequests = $user->pendingReceivedConnections()->with(['sender', 'sender.profile'])->get();

        // Connections Count
        // Merging collections for count is fine for MVP, but for scale use database count.
        $receivedCount = $user->receivedConnections()->where('status', 'accepted')->count();
        $sentCount = $user->sentConnections()->where('status', 'accepted')->count();
        $connectionsCount = $receivedCount + $sentCount;

        // Suggestions (People you may know)
        // Simple logic: Users who are NOT me, NOT connected, and NO pending request.
        // This query can be optimized.
        $excludeIds = collect([$user->id]);
        $excludeIds = $excludeIds->merge($user->sentConnections->pluck('receiver_id'));
        $excludeIds = $excludeIds->merge($user->receivedConnections->pluck('sender_id'));

        $suggestions = User::whereNotIn('id', $excludeIds)
            ->with('profile')
            ->limit(12)
            ->get();

        return view('network.index', compact('user', 'pendingRequests', 'connectionsCount', 'suggestions'));
    }

    /**
     * Store a newly created connection request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id|different:user_id',
        ]);

        $receiverId = $request->receiver_id;
        $senderId = Auth::id();

        // Check if connection already exists
        $exists = Connection::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)->where('receiver_id', $senderId);
        })->exists();

        if ($exists) {
            return back()->with('error', 'Connection request already exists or you are already connected.');
        }

        Connection::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'status' => 'pending',
        ]);

        return back()->with('status', 'Connection request sent.');
    }

    /**
     * Update the specified connection status (Accept/Reject).
     */
    public function update(Request $request, Connection $connection)
    {
        // Only the receiver can update status (Accept/Reject)
        if ($connection->receiver_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $connection->update([
            'status' => $request->status,
        ]);

        return back()->with('status', 'Connection ' . $request->status . '.');
    }

    /**
     * Remove the specified connection.
     */
    public function destroy(Connection $connection)
    {
        // Only sender or receiver can delete
        if ($connection->sender_id !== Auth::id() && $connection->receiver_id !== Auth::id()) {
            abort(403);
        }

        $connection->delete();

        return back()->with('status', 'Connection removed.');
    }
}
