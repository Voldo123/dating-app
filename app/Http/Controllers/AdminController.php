<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Like;
use App\Models\UserMatch;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_matches' => UserMatch::count(),
            'total_likes' => Like::count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
        ];

        $recent_users = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users'));
    }

    public function users()
    {
        $users = User::withCount(['sentLikes', 'receivedLikes'])
                    ->get()
                    ->map(function ($user) {
                        $user->matches_count = $user->matchesCount();
                        return $user;
                    })
                    ->sortByDesc('created_at');

        return view('admin.users', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users-edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:user,admin',
            'age' => 'nullable|integer|min:18|max:100',
            'gender' => 'nullable|in:Мужчина,Женщина',
            'city' => 'nullable|string|max:100',
            'about' => 'nullable|string|max:500',
            'telegram' => 'nullable|string|max:100',
        ]);

        $user->update($request->all());

        return redirect()->route('admin.users')->with('success', 'Пользователь обновлен');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Нельзя удалить собственный аккаунт');
        }

        $user->delete();

        return back()->with('success', 'Пользователь удален');
    }

    public function tags()
    {
        $tags = Tag::all();
        return view('admin.tags', compact('tags'));
    }

    public function storeTag(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags'
        ]);

        Tag::create([
            'name' => $request->name
        ]);

        return back()->with('success', 'Тег успешно добавлен');
    }

    public function deleteTag($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return back()->with('success', 'Тег успешно удален');
    }
}