<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Like;
use App\Models\UserMatch;

class FeedController extends Controller
{
    public function index()
{
    $user = Auth::user();
    
    // Исключаем уже пролайканных пользователей и себя
    $likedUserIds = $user->sentLikes()->pluck('target_user_id');
    $userIdsToExclude = $likedUserIds->push($user->id)->toArray();

    $users = User::whereNotIn('id', $userIdsToExclude)
                ->where('id', '!=', $user->id)
                ->with('tags') // 👈 Добавляем загрузку тегов
                ->inRandomOrder() // 👈 Перемешиваем для разнообразия
                ->get();

    return view('feed.index', compact('users'));
}

    public function like($id)
    {
        $targetUser = User::findOrFail($id);

        // Проверяем, не лайкали ли уже
        $existingLike = Like::where('user_id', Auth::id())
                            ->where('target_user_id', $id)
                            ->first();

        if (!$existingLike) {
            // Создаем лайк
            Like::create([
                'user_id' => Auth::id(),
                'target_user_id' => $id,
                'type' => 'like'
            ]);

            
            $mutualLike = Like::where('user_id', $id)
                             ->where('target_user_id', Auth::id())
                             ->where('type', 'like')
                             ->exists();

            
            if ($mutualLike) {
                
                $existingMatch = UserMatch::where(function($query) use ($id) {
                    $query->where('user1_id', Auth::id())
                          ->where('user2_id', $id);
                })->orWhere(function($query) use ($id) {
                    $query->where('user1_id', $id)
                          ->where('user2_id', Auth::id());
                })->exists();

                if (!$existingMatch) {
                    UserMatch::create([
                        'user1_id' => min(Auth::id(), $id),
                        'user2_id' => max(Auth::id(), $id)
                    ]);
                }
            }
        }

        return back()->with('success', 'Лайк отправлен!');
    }

    public function dislike($id)
{
    $existingLike = Like::where('user_id', Auth::id())
                        ->where('target_user_id', $id)
                        ->first();

    if (!$existingLike) {
        Like::create([
            'user_id' => Auth::id(),
            'target_user_id' => $id,  
            'type' => 'dislike'
        ]);
    }

    return back()->with('info', 'Дизлайк отправлен');
}
}