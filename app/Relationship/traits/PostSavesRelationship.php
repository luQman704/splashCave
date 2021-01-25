<?php


namespace App\Relationship\traits;


use App\Models\post;
use App\Models\PostImages;
use App\Models\User;

trait PostSavesRelationship
{



    public function post()
    {
        return $this->hasOne(Post::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
