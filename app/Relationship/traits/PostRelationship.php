<?php


namespace App\Relationship\traits;


use App\Models\post;
use App\Models\PostImages;
use App\Models\User;

trait PostRelationship
{



    public function postImages()
    {
        return $this->hasMany(PostImages::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
