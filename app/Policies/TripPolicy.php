<?php

namespace App\Policies;

use App\Models\Trip;
use App\Models\User;

class TripPolicy
{
    public function view(User $user, Trip $trip): bool
    {
        return $trip->owner_id === $user->id
            || $trip->tripMembers()->where('user_id', $user->id)->exists();
    }

    public function update(User $user, Trip $trip): bool
    {
        $member = $trip->tripMembers()->where('user_id', $user->id)->first();
        return $trip->owner_id === $user->id
            || ($member && in_array($member->role, ['eigenaar', 'bewerker']));
    }
}
