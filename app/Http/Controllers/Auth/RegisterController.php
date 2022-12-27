<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ]);

        $user = User::create($validated);

        if (!$user instanceof User && !$user->exists) {
            return redirect()->back()->withInput()->withErrors('Ada kesalahan saat membuat akun');
        }

        auth()->login($user);
        return redirect()->route('home');
    }
}
