<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Place extends Model
{
    protected $fillable = ['trip_id', 'name', 'kind', 'note', 'liked', 'lat', 'lng'];

    public function trip(): BelongsTo { return $this->belongsTo(Trip::class); }
}
