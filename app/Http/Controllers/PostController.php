<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display the social feed (Dashboard).
     */
    public function index()
    {
        $user = Auth::user();

        // Get IDs of user and friends
        // Connections logic: sentAccepted + receivedAccepted
        $friendIds = $user->connections()->pluck('id')->push($user->id);

        $posts = Post::whereIn('user_id', $friendIds)
            ->with(['user', 'user.profile', 'likes', 'comments', 'comments.user'])
            ->latest()
            ->paginate(10);

        return view('dashboard', compact('posts'));
    }

    /**
     * Store a newly created post.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:2000',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'content' => $request->content,
            'user_id' => Auth::id(),
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('posts', 'public');
        }

        Post::create($data);

        return back()->with('status', 'Post created successfully!');
    }

    /**
     * Toggle like on a post.
     */
    public function like(Post $post)
    {
        $userId = Auth::id();
        $like = $post->likes()->where('user_id', $userId)->first();

        if ($like) {
            $like->delete();
        } else {
            $post->likes()->create(['user_id' => $userId]);
        }

        return back();
    }

    /**
     * Store a comment on a post.
     */
    public function comment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return back()->with('status', 'Comment added.');
    }

    /**
     * Delete a post.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->delete();

        return back()->with('status', 'Post deleted.');
    }
}
