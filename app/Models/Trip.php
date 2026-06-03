<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    protected $casts = [
        'starts_on' => 'date',
        'ends_on'   => 'date',
    ];

    protected $fillable = [
        'owner_id', 'title', 'subtitle', 'country', 'dates',
        'starts_on', 'ends_on', 'nights', 'budget', 'cover',
        'map_lat', 'map_lng', 'map_zoom',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'trip_members')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function tripMembers(): HasMany
    {
        return $this->hasMany(TripMember::class);
    }

    public function days(): HasMany
    {
        return $this->hasMany(TripDay::class)->orderBy('day_number');
    }

    public function packingItems(): HasMany
    {
        return $this->hasMany(PackingItem::class);
    }

    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class)->orderBy('created_at');
    }

    public function budgetItems(): HasMany
    {
        return $this->hasMany(BudgetItem::class);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(TripInvitation::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TripComment::class)->latest();
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class)->latest();
    }

    public function getDaysAwayAttribute(): int
    {
        if (!$this->starts_on) return 0;
        return max(0, (int) now()->diffInDays($this->starts_on, false));
    }

    public function getSpentAttribute(): int
    {
        return $this->budgetItems()->sum('amount');
    }
}
