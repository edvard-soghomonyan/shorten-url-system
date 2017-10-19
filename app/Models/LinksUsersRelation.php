<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinksUsersRelation extends Model
{
    protected $fillable = ['link_id', 'user_id'];

    public $timestamps = false;
}
