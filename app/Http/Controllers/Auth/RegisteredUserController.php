<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\area_scope;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $areaScopes = area_scope::all(); 
        return view('auth.register', compact('areaScopes'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'usr_scope_id' => ['required', 'exists:area_scopes,asc_id']
        ], [
                'usr_scope_id.required' => 'RT wajib diisi.',
                'usr_scope_id.exists' => 'RT tidak valid.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usr_scope_id' => $request->usr_scope_id,
        ]);
        $user->assignRole('citizen');
        //dd($request->all());

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('citizen.dashboard', absolute: false));
    }
}
