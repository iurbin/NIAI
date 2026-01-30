<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    //
    protected $fillable = [
        'label', 'value', 'increase', 'icon', 'item_type'
    ];
    public function nota(): BelongsTo
    {
        return $this->belongsTo(Nota::class);
    }
}
