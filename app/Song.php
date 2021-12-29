<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $table = 'songs';

    protected $fillable = [
        'id',
        'song_title',
        'song_artist',
        'album_title',
        'album_artist',
        'genre',
        'year',
        'image',
    ];
}
