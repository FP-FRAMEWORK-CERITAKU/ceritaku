<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        $validated = $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ]);

        if (auth()->attempt($validated)) {
            return redirect()->route('home');
        }

        return redirect()->back()->withInput()->withErrors('Email atau password salah');
    }
}
