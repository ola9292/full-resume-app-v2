<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
   public function create()
    {
        \Log::info('User authenticated: ' . (auth()->check() ? 'YES' : 'NO'));
    if (auth()->check()) {
        \Log::info('Authenticated user: ' . auth()->user()->email);
    }

        return Inertia::render('Auth/Login');

    }
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function register()
    {
        return inertia('Auth/Register');
    }
    public function saveUser(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        User::create($data);

        return to_route('login');

        // return redirect('/login');
    }
    public function destroy()
    {
        Auth::logout();

        return redirect('/');
    }

    public function testMethod()
    {
        return Inertia::render('Resume/Index', [
            'test' => 'from auth controller',
            'gemini_api_key' => config('services.gemini.api_key')
        ]);
    }

}
