<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Post;
use App\Models\SavedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedItemController extends Controller
{
    /**
     * Display a listing of the saved items.
     */
    public function index()
    {
        $savedPosts = Auth::user()->savedItems()
            ->where('saveable_type', Post::class)
            ->with(['saveable.user', 'saveable.likes', 'saveable.comments'])
            ->get()
            ->pluck('saveable');

        $savedJobs = Auth::user()->savedItems()
            ->where('saveable_type', Job::class)
            ->with('saveable')
            ->get()
            ->pluck('saveable');

        return view('saved-items.index', compact('savedPosts', 'savedJobs'));
    }

    /**
     * Toggle save status for a polymorphic item.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'type' => 'required|in:post,job',
        ]);

        $modelClass = match ($request->type) {
            'post' => Post::class,
            'job' => Job::class,
            default => null,
        };

        if (!$modelClass) {
            abort(404);
        }

        $user = Auth::user();
        
        $exists = $user->savedItems()
            ->where('saveable_id', $request->id)
            ->where('saveable_type', $modelClass)
            ->first();

        if ($exists) {
            $exists->delete();
            $message = 'Item removed from saved items.';
        } else {
            $user->savedItems()->create([
                'saveable_id' => $request->id,
                'saveable_type' => $modelClass,
            ]);
            $message = 'Item saved successfully.';
        }

        return back()->with('success', $message);
    }
}
