<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMatch extends Model
{
    use HasFactory;

    protected $fillable = ['user1_id', 'user2_id'];

    public function user1()
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'user2_id');
    }

    // Accessor для получения партнера по мэтчу
    public function getPartnerAttribute()
    {
        $currentUserId = auth()->id();
        return $currentUserId === $this->user1_id ? $this->user2 : $this->user1;
    }

    // Проверить, является ли пользователь участником мэтча
    public function involvesUser($userId)
    {
        return $this->user1_id === $userId || $this->user2_id === $userId;
    }
}