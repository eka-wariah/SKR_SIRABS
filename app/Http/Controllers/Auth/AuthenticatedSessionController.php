<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        if (Auth::user()->hasRole('rw_leader')){
            return redirect()->to('rw_leader');
        }

        if (Auth::user()->hasRole('treasurer')){
            return redirect()->to('treasurer');
        }

        if (Auth::user()->hasRole('wastebank_officer')){
            return redirect()->to('wastebank_officer');
        }

        if (Auth::user()->hasRole('citizen')){
            return redirect()->to('citizen');
        }

        return redirect()->intended(route('dashboard', absolute: false));

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
