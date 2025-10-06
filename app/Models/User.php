<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'gender',
        'city',
        'about',
        'telegram',
        'photo',   
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 👇 Добавлено: связь с тегами
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // Отношения лайков
    public function sentLikes()
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    public function receivedLikes()
    {
        return $this->hasMany(Like::class, 'target_user_id');
    }

    public function matches()
    {
        return $this->hasMany(UserMatch::class, 'user1_id')
                    ->orWhere(function($query) {
                        $query->where('user2_id', $this->id);
                    });
    }

    public function matchesAsUser1()
    {
        return $this->hasMany(UserMatch::class, 'user1_id');
    }

    public function matchesAsUser2()
    {
        return $this->hasMany(UserMatch::class, 'user2_id');
    }

    public function getAllMatches()
    {
        $matchesAsUser1 = $this->matchesAsUser1()->with('user2')->get();
        $matchesAsUser2 = $this->matchesAsUser2()->with('user1')->get();
        return $matchesAsUser1->merge($matchesAsUser2);
    }

    public function matchesCount()
    {
        return UserMatch::where('user1_id', $this->id)
                       ->orWhere('user2_id', $this->id)
                       ->count();
    }

    public function hasMutualLikeWith($userId)
    {
        $sentLike = $this->sentLikes()->where('target_user_id', $userId)->where('type', 'like')->exists();
        $receivedLike = $this->receivedLikes()->where('user_id', $userId)->where('type', 'like')->exists();
        return $sentLike && $receivedLike;
    }

    public function getMatchPartner($match)
    {
        return $match->user1_id === $this->id ? $match->user2 : $match->user1;
    }

    public function hasLiked($targetUserId)
    {
        return $this->sentLikes()->where('target_user_id', $targetUserId)->where('type', 'like')->exists();
    }

    public function hasDisliked($targetUserId)
    {
        return $this->sentLikes()->where('target_user_id', $targetUserId)->where('type', 'dislike')->exists();
    }

    public function getRatedUserIds()
    {
        return $this->sentLikes()->pluck('target_user_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function getUnviewedMatches()
    {
        return $this->matches()
                    ->where(function($query) {
                        $query->where('user1_id', $this->id)
                              ->where('user1_viewed', false)
                              ->orWhere('user2_id', $this->id)
                              ->where('user2_viewed', false);
                    })
                    ->get();
    }

    public function markMatchAsViewed($matchId)
    {
        $match = UserMatch::find($matchId);
        if (!$match) return false;

        if ($match->user1_id === $this->id) {
            $match->update(['user1_viewed' => true]);
        } elseif ($match->user2_id === $this->id) {
            $match->update(['user2_viewed' => true]);
        }

        return true;
    }
}
