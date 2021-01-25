<?php

namespace App\Relationship\traits;


use App\Models\User;

trait SmsRelationship {


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
