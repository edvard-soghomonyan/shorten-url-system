<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['id', 'url'];

    public $timestamps = false;

    public function tracking()
    {
        return $this->hasOne(LinkTracking::class, 'link_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'links_users_relations');
    }
}
