<?php

namespace App\Models;

use App\Relationship\traits\SmsRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory, SmsRelationship;

    protected $fillable = [
        'benefit',
        'message',
        'user_id',
        'numbers'
    ];
}
