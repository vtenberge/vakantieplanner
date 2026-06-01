<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackingItem extends Model
{
    protected $fillable = ['trip_id', 'text', 'category', 'user_id', 'done'];
    protected $casts = ['done' => 'boolean'];

    public function trip(): BelongsTo { return $this->belongsTo(Trip::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
