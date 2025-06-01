<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\area_scope;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
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

    public function edit_photo(Request $request): View
    {

        $areaScopes = area_scope::all(); 
        $user = $request->user();
    if ($user->hasRole('rw_leader')) {
        $layout = 'rw_leader.master_rw-leader';
    } elseif ($user->hasRole('treasurer')) {
        $layout = 'treasurer.master_treasurer';
    } else {
        $layout = 'layouts.app'; // default layout
    }
        return view('profile.edit2', [
            'user' => $request->user(), 
            'areaScopes' => $areaScopes,
            
        ]);
    }

    public function update_photo(Request $request)
    {
        $user = Auth::user();
    
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->usr_id, 'usr_id'),
            ],
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2400',
            'gender'        => 'nullable|in:Laki-laki,Perempuan',
            'phone'         => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:255',
            'usr_scope_id'  => 'nullable|exists:area_scopes,asc_id',
            'village'       => 'nullable|string|max:100',
            'subdistrict'   => 'nullable|string|max:100',
            'regency'       => 'nullable|string|max:100',
        ]);
    
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }
    
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }
    // dd($validated);
        $user->update($validated);
    
        return back()->with('success', 'Profil berhasil diperbarui.');
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
