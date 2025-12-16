<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Job::query()->latest();

        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'LIKE', '%'.$request->q.'%')
                  ->orWhere('company', 'LIKE', '%'.$request->q.'%')
                  ->orWhere('description', 'LIKE', '%'.$request->q.'%');
            });
        }

        if ($request->filled('location')) {
             $query->where('location', 'LIKE', '%'.$request->location.'%');
        }
        
        $jobs = $query->paginate(10);

        return view('jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'type' => 'required|in:Full-time,Part-time,Contract,Temporary,Internship,Remote',
            'description' => 'required|string',
        ]);

        Auth::user()->jobs()->create($request->all());

        return redirect()->route('jobs.index')->with('status', 'Job posted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        return view('jobs.show', compact('job'));
    }

    public function apply(Request $request, Job $job)
    {
        if ($job->user_id === Auth::id()) {
            return back()->with('error', 'You cannot apply to your own job.');
        }

        if ($job->isAppliedBy(Auth::user())) {
            return back()->with('error', 'You have already applied to this job.');
        }

        $job->applications()->create([
            'user_id' => Auth::id(),
            // Basic Easy Apply just uses profile, no cover letter for now for simplicity
        ]);

        return back()->with('success', 'Application submitted successfully!');
    }

    public function applicants(Job $job)
    {
        if ($job->user_id !== Auth::id()) {
            abort(403);
        }

        $job->load('applications.user.profile');
        
        return view('jobs.applicants', compact('job'));
    }
}
