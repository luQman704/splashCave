<?php

namespace App\Models;

use App\Relationship\traits\PostRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory, PostRelationship;

    protected $fillable = [
        'title',
        'message',
        'category',
        'price'
    ];


}
