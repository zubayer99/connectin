<?php

namespace App\Http\Controllers;

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
        
        if (!$query) {
            return redirect()->route('dashboard');
        }

        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhereHas('profile', function($q) use ($query) {
                $q->where('headline', 'LIKE', "%{$query}%")
                  ->orWhere('location', 'LIKE', "%{$query}%");
            })
            ->with('profile')
            ->paginate(10);

        return view('search.results', compact('users', 'query'));
    }
}
