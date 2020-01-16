<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title', 'image', 'description', 'publicated'
    ];

    public function authors() {
        return $this->belongsToMany(Author::class);
    }
}
