<?php

namespace App\Relationship\traits;

use App\Models\Contacts;
use App\Models\post;
use App\Models\PostSaves;
use App\Models\Sms;
use App\Models\userSavedCompanies;
use App\Models\userSubscription;

trait UserRelationship {


    public function posts()
    {
        return $this->hasMany(post::class);
    }

    public function postSaves()
    {
        return $this->hasMany(PostSaves::class);
    }

    public function userSubscriptions()
    {
        return $this->hasMany(userSubscription::class);
    }

    public function subscribers()
    {
        return $this->belongsToMany(self::class, 'subscribers', 'subscribers_id', 'user_id')
            ->withTimestamps();
    }

    public function subscribeTo()
    {
        return $this->belongsToMany(self::class, 'subscribers', 'user_id', 'subscribers_id')
            ->withTimestamps();
    }

    public function userSaves()
    {
        return $this->hasMany(userSavedCompanies::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contacts::class);
    }

    public function sms()
    {
        return $this->hasMany(Sms::class);
    }

}
