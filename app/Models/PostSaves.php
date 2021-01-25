<?php

namespace App\Models;

use App\Relationship\traits\PostSavesRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostSaves extends Model
{
    use HasFactory,  PostSavesRelationship;
    protected $fillable = [
        'post_id'
    ];
}
