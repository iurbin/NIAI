<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Nota extends Model
{
    //
    protected $fillable = [
        'link', 'title', 'cover', 'extract', 'location', 'audio_url', 'type'
    ];
    public function stats(): HasMany
    {
        return $this->hasMany(Stat::class, 'item_id');
    }
}
