<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\area_scope;
use App\Models\households;
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
            'name' => [
                'required',
                'string',
                'min:4',
                'max:20',
                'regex:/^(?!.*[_.]{2})(?![_.])[a-zA-Z0-9._]{4,20}(?<![_.])$/',
                'unique:users,name', 
            ],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'usr_scope_id' => ['required', 'exists:area_scopes,asc_id'],
            'nik' => ['required', 'string', 'unique:users'],
            'no_kk' => ['required', 'string'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
        ], [
                'usr_scope_id.required' => 'RT wajib diisi.',
                'usr_scope_id.exists' => 'RT tidak valid.',
        ]);
        $household = households::firstOrCreate(
            ['no_kk' => $request->no_kk],
            ['alamat' => null]
        );

        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name') ?? '-'; // jika kosong, isi "-"
        if (trim($firstName) === '') {
            $firstName = 'Warga'; // atau bisa ditolak lewat validasi
        }
        $existingHousehold = households::where('no_kk', $request->no_kk)->first();
        if ($existingHousehold) {
            $existingUser = User::where('household_id', $existingHousehold->id)->first();
            if ($existingUser && $existingUser->usr_scope_id != $request->usr_scope_id) {
                return redirect()->back()
                 ->withInput()
                 ->withErrors(['no_kk' => 'Nomor KK ini sudah terdaftar di RT lain.']);
    }
}


        $user = User::create([
            'name' => $request->name,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usr_scope_id' => $request->usr_scope_id,
            'nik' => $request->nik,
            'household_id' => $household->id,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => 0,
            
        ]);
        $user->assignRole('citizen');
        // dd($request->all());

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('verification.pending', absolute: false));
    }
}
