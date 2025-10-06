<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Tag;

class ProfileController extends Controller
{
    public function edit()
{
    $user = Auth::user();
    $tags = Tag::all(); // 👈 Добавляем получение тегов
    return view('profile.edit', compact('user', 'tags'));
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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'array|max:3'
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $path = $request->file('photo')->store('avatars', 'public');
            $validated['photo'] = $path;
        }

        $user->update($validated);

        // 👇 Привязка тегов
        $user->tags()->sync($request->input('tags', []));

        return redirect()->route('profile.show', $user->id)->with('success', 'Профиль обновлён!');
    }
}
