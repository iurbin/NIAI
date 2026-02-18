<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    //
    protected $fillable = [
        'link', 'forum_title', 'position', 'state'
    ];
    public function stats(): HasMany
    {
        return $this->hasMany(Stat::class, 'item_id');
    }
}
