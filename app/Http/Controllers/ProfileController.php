<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's public profile.
     */
    public function show(User $user = null): View
    {
        // If no user provided, and no logged in user, error or redirect.
        // If no user provided, assume logged in user.
        if (!$user) {
            $user = Auth::user();
            if (!$user) {
                abort(404);
            }
        }

        $user->load(['profile', 'experiences', 'education']);

        return view('profile.show', [
            'user' => $user,
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Display the user's profile details edit form.
     */
    public function editDetails(Request $request): View
    {
        $user = $request->user();
        $user->load(['profile', 'experiences', 'education']);
        return view('profile.edit-details', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile details.
     */
    public function updateDetails(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Update Profile Info
        $data = $request->only(['headline', 'about', 'location', 'website']);

        if ($request->hasFile('banner')) {
            $path = $request->file('banner')->store('banners', 'public');
            $data['banner_path'] = $path;
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar_path'] = $path;
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        // Handle Experience (Simplistic: Add one if provided, logic needs refinement for editing existing)

        if ($request->filled('new_experience_title')) {
            $user->experiences()->create([
                'title' => $request->new_experience_title,
                'company' => $request->new_experience_company,
                'start_date' => $request->new_experience_start_date,
                'location' => $request->new_experience_location ?? 'Remote',
                'description' => $request->new_experience_description ?? '',
            ]);
        }
        
        return Redirect::route('profile.show', $user)->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
