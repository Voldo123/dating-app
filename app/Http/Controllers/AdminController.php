<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Like;
use App\Models\UserMatch;
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
        // Используем кастомный метод для подсчета мэтчей
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
    $user = User::findOrFail($id); // Исправлено с findOrFall на findOrFail
    return view('admin.users-edit', compact('user'));
}

public function updateUser(Request $request, $id)
{
    // Временная отладка
    \Log::info('AdminController updateUser called', [
        'user_id' => $id,
        'request_data' => $request->all(),
        'auth_user' => auth()->id()
    ]);

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

    \Log::info('User updated successfully', ['user_id' => $user->id]);

    return redirect()->route('admin.users')->with('success', 'Пользователь обновлен');
}
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        // Не даем удалить себя
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Нельзя удалить собственный аккаунт');
        }

        $user->delete();

        return back()->with('success', 'Пользователь удален');
    }

    public function statistics()
    {
        $userStats = [
            'by_gender' => User::select('gender', DB::raw('count(*) as count'))
                            ->groupBy('gender')
                            ->get(),
            'by_city' => User::select('city', DB::raw('count(*) as count'))
                          ->whereNotNull('city')
                          ->groupBy('city')
                          ->orderBy('count', 'desc')
                          ->limit(10)
                          ->get(),
        ];

        $activityStats = [
            'likes_today' => Like::whereDate('created_at', today())->count(),
            'matches_today' => UserMatch::whereDate('created_at', today())->count(),
            'total_likes' => Like::count(),
            'total_matches' => UserMatch::count(),
        ];

        return view('admin.statistics', compact('userStats', 'activityStats'));
    }

    public function tags()
    {
        return view('admin.tags');
    }

    public function storeTag(Request $request)
    {
        // Здесь будет логика добавления тегов
        return back()->with('success', 'Тег добавлен');
    }

    public function deleteTag($id)
    {
        // Здесь будет логика удаления тегов
        return back()->with('success', 'Тег удален');
    }
}