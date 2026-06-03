<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\TripInvitation;
use App\Models\TripMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TripMemberController extends Controller
{
    public function store(Request $request, Trip $trip)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'role'  => 'nullable|in:bewerker,kijker',
        ]);

        $role = $data['role'] ?? 'bewerker';
        $user = User::where('email', $data['email'])->first();

        if ($user) {
            // User already has an account — add them directly
            TripMember::updateOrCreate(
                ['trip_id' => $trip->id, 'user_id' => $user->id],
                ['role' => $role]
            );
            return back()->with('success', $user->name . ' is toegevoegd aan de reis.');
        }

        // No account yet — create an invitation
        $existing = TripInvitation::where('trip_id', $trip->id)
            ->where('email', $data['email'])
            ->whereNull('accepted_at')
            ->first();

        if ($existing) {
            return back()->withErrors(['email' => 'Er staat al een openstaande uitnodiging voor dit e-mailadres.']);
        }

        TripInvitation::create([
            'trip_id'    => $trip->id,
            'email'      => $data['email'],
            'role'       => $role,
            'token'      => Str::random(48),
            'invited_by' => Auth::id(),
            'expires_at' => now()->addDays(14),
        ]);

        return back()->with('success', 'Uitnodiging aangemaakt voor ' . $data['email'] . '. Stuur hen de link hieronder.');
    }

    public function updateRole(Request $request, Trip $trip, TripMember $member)
    {
        $data = $request->validate(['role' => 'required|in:eigenaar,bewerker,kijker']);
        $member->update(['role' => $data['role']]);
        return back();
    }

    public function destroy(Trip $trip, TripMember $member)
    {
        if ($member->role !== 'eigenaar') {
            $member->delete();
        }
        return back();
    }
}
