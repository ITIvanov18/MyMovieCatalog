<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    // позволява да се задават данни в тези колони наведнъж
    protected $fillable = ['title', 'director', 'year', 'genre', 'description', 'poster', 'rating'];
}
