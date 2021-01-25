<?php

namespace App\Models;

use App\Relationship\traits\UserSavesRelationship;
use App\Relationship\traits\UserSubscriptionRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userSubscription extends Model
{
    use HasFactory, UserSubscriptionRelationship;

    protected $fillable = [
        'subscription_id'
    ];
}
