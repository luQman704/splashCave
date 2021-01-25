<?php

namespace App\Models;

use App\Relationship\traits\ContactsRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory, ContactsRelationship;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'number'
    ];
}
