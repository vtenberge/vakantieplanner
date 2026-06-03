<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripInvitation extends Model
{
    protected $fillable = ['trip_id', 'email', 'role', 'token', 'invited_by', 'accepted_at', 'expires_at'];

    protected $casts = [
        'accepted_at' => 'datetime',
        'expires_at'  => 'datetime',
    ];

    public function trip(): BelongsTo   { return $this->belongsTo(Trip::class); }
    public function invitedBy(): BelongsTo { return $this->belongsTo(User::class, 'invited_by'); }

    public function isPending(): bool
    {
        return is_null($this->accepted_at)
            && (is_null($this->expires_at) || $this->expires_at->isFuture());
    }
}
