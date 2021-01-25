<?php

namespace App\Relationship\traits;


use App\Models\User;

trait ContactsRelationship{


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
