<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = ['trip_id', 'type', 'title', 'date_label', 'booking_code', 'cost', 'added_by'];

    public function trip(): BelongsTo { return $this->belongsTo(Trip::class); }
    public function addedBy(): BelongsTo { return $this->belongsTo(User::class, 'added_by'); }
}
