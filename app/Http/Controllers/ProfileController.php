<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function show($id)
{
    $user = User::findOrFail($id);
    return view('profile.show', compact('user'));
}

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'age' => 'required|integer|min:18|max:100',
            'gender' => 'required|in:Мужчина,Женщина',
            'city' => 'required|string|max:255',
            'about' => 'nullable|string',
            'telegram' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // макс 2MB
        ]);

        // Если загружено новое фото — удаляем старое и сохраняем новое
        if ($request->hasFile('photo')) {
            // Удаляем старое фото, если оно есть
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            // Сохраняем новое фото
            $path = $request->file('photo')->store('avatars', 'public');
            $validated['photo'] = $path;
        }

        $user->update($validated);

        return redirect()->route('profile.show', $user->id)->with('success', 'Профиль обновлён!');
    }
}