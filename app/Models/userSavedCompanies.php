<?php

namespace App\Models;

use App\Relationship\traits\UserSavesRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userSavedCompanies extends Model
{
    use HasFactory, UserSavesRelationship;

    protected $fillable = [
        'saved_user_id'
    ];
}
