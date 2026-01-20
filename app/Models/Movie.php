<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    // позволява да се задават данни в тези колони наведнъж
    protected $fillable = ['title', 'director', 'year', 'genre', 'description', 'poster', 'rating'];

    // връзка с потребителите
    public function users()
    {
        return $this->belongsToMany(User::class, 'movie_user')
                    ->withPivot('type')
                    ->withTimestamps();
    }

    // проверява дали този филм е в конкретен списък на потребителя
    public function isInList($user, $type)
    {
        if (!$user) return false;

        return $this->users()
                    ->where('user_id', $user->id)
                    ->where('type', $type)
                    ->exists(); // връща true или false
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest(); // latest() ги подрежда от най-новите
    }

    public function getAvgRatingAttribute()
    {
        // смята average на колоната 'rating'
        $avg = $this->reviews()->avg('rating');

        // ако има оценка, я форматира до 1 знак, ако не връща null
        return $avg ? number_format($avg, 1) : null;
    }
}
