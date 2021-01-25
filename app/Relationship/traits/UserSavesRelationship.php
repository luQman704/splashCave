<?php

namespace App\Relationship\traits;

use App\Models\post;
use App\Models\PostSaves;
use App\Models\User;

trait UserSavesRelationship {


    public function savedUser()
    {
        return $this->hasOne(User::class, 'id', 'saved_user_id');
    }


}
