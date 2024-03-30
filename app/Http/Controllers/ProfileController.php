<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Profile;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $profile = $user->profile;

        return view('profile.edit', [
            'user' => $user,
            'address' => $profile ? $profile->address : null,
            'age' => $profile ? $profile->age : null,
            'phone_number' => $profile ? $profile->phone_number : null,
            'profile_image' => $profile ? $profile->profile_image : null,
        ]);
    }

    /**
     * Update the user's profile information.
     */public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $validatedData = $request->validated();

    // Get the authenticated user
    $user = $request->user();

    // Update the user's profile information
    $user->fill($validatedData);

    // If email is updated, reset email verification
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    // Save the user's profile information
    $user->save();

    $profile = $user->profile ?? new Profile();

    // Update profile information
    $profile->address = $request->address;
    $profile->age = $request->age;
    $profile->phone_number = $request->phone_number;

    // Handle profile image upload
    if ($request->hasFile('profile_image')) {
        $image = $request->file('profile_image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        // Ensure the folder exists and has write permissions
        $image->move(public_path('profile_image'), $imageName);
        $profile->profile_image = $imageName;
    }

    // Save the profile
    $user->profile()->save($profile);

    // Redirect back to the profile edit page with success message
    return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
