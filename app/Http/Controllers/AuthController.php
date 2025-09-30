<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect()->route('profile.edit');
    }

    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request)
{
    if (Auth::attempt($request->only('email', 'password'))) {
        return redirect()->route('profile.show', Auth::id()); // ✅ Передаём ID
    }
    return back()->withErrors(['email' => 'Неверные данные']);
}

    public function logout() {
        Auth::logout();
        return redirect()->route('login.show');
    }
}
