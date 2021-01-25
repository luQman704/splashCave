<?php

namespace App\Relationship\traits;

use App\Models\post;
use App\Models\PostSaves;
use App\Models\User;

trait UserSubscriptionRelationship {


    public function subscribedUser()
    {
        return $this->hasOne(User::class, 'id', 'subscription_id');
    }

    public function sub()
    {
        return $this->hasOne(User::class,  'subscription_id', 'id',);
    }


}
