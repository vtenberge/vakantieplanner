<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    protected $fillable = ['trip_id', 'user_id', 'icon', 'description'];

    public function trip(): BelongsTo { return $this->belongsTo(Trip::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }

    public static function record(int $tripId, string $icon, string $description): void
    {
        static::create([
            'trip_id'     => $tripId,
            'user_id'     => Auth::id(),
            'icon'        => $icon,
            'description' => $description,
        ]);
    }
}
