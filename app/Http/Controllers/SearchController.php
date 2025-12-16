<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the search request.
     */
    public function index(Request $request)
    {
        $query = $request->input('q');
        $type = $request->input('type', 'people'); // Default to people

        if (!$query) {
             return view('search.results', [
                'users' => collect(),
                'jobs' => collect(),
                'posts' => collect(),
                'type' => $type
            ]);
        }

        $users = collect();
        $jobs = collect();
        $posts = collect();

        if ($type === 'people' || $type === 'all') {
             $users = User::where('name', 'like', "%{$query}%")
                ->orWhereHas('profile', function ($q) use ($query) {
                    $q->where('headline', 'like', "%{$query}%")
                      ->orWhere('location', 'like', "%{$query}%");
                })
                ->with('profile')
                ->get();
        }

        if ($type === 'jobs' || $type === 'all') {
            $jobs = Job::where('title', 'like', "%{$query}%")
                ->orWhere('company', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->latest()
                ->get();
        }

        if ($type === 'posts' || $type === 'all') {
             $posts = Post::where('content', 'like', "%{$query}%")
                ->with('user.profile', 'likes', 'comments')
                ->latest()
                ->get();
        }

        return view('search.results', compact('users', 'jobs', 'posts', 'type', 'query'));
    }
}
