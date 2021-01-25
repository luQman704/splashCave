<?php

namespace App\Models;

use App\Relationship\traits\UserRelationship;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, UserRelationship;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'company_name',
        'user_name',
        'avatar',
        'location'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function subscribe($userId)
    {
        return $this->subscribeTo()->attach($userId);
    }

    public function unSubscribe($userId)
    {
        $this->subscribeTo()->detach($userId);
        return $this;
    }

    public function isFollowing($userId)
    {
        return (boolean) $this->subscribeTo()->where('subscribers_id', $userId)->first(['id']);
    }
}
