<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    // позволява да се задават данни в тези колони наведнъж
    protected $fillable = ['title', 'year', 'genre', 'description', 'poster', 'rating'];
}
