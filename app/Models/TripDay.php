<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TripDay extends Model
{
    protected $fillable = ['trip_id', 'day_number', 'date_label', 'label', 'weather'];

    public function trip(): BelongsTo { return $this->belongsTo(Trip::class); }
    public function items(): HasMany { return $this->hasMany(DayItem::class)->orderBy('time'); }
}
