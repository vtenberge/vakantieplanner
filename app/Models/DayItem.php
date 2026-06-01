<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DayItem extends Model
{
    protected $fillable = ['trip_day_id', 'time', 'title', 'kind', 'added_by'];

    public function day(): BelongsTo { return $this->belongsTo(TripDay::class, 'trip_day_id'); }
    public function addedBy(): BelongsTo { return $this->belongsTo(User::class, 'added_by'); }
}
