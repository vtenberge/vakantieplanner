<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\TripMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $trips = Trip::where('owner_id', $user->id)
            ->orWhereHas('tripMembers', fn($q) => $q->where('user_id', $user->id))
            ->with(['tripMembers.user'])
            ->orderBy('starts_on')
            ->get();

        return view('trips.index', compact('trips'));
    }

    public function show(Trip $trip)
    {
        $user = Auth::user();
        $isMember = $trip->owner_id === $user->id
            || $trip->tripMembers()->where('user_id', $user->id)->exists();
        if (!$isMember) abort(403);

        $trip->load([
            'days.items.addedBy',
            'packingItems.user',
            'places',
            'bookings.addedBy',
            'budgetItems.user',
            'tripMembers.user',
            'invitations.invitedBy',
        ]);

        $tab = request('tab', 'dagen');

        return view('trips.show', compact('trip', 'tab'));
    }

    public function update(Request $request, Trip $trip)
    {
        $user = Auth::user();
        $member = $trip->tripMembers()->where('user_id', $user->id)->first();
        if (!$member || !in_array($member->role, ['eigenaar', 'bewerker'])) abort(403);

        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'country'   => 'nullable|string|max:100',
            'dates'     => 'nullable|string|max:100',
            'starts_on' => 'nullable|date',
            'ends_on'   => 'nullable|date',
            'nights'    => 'nullable|integer|min:0',
            'budget'    => 'nullable|integer|min:0',
        ]);

        $trip->update($data);

        return redirect()
            ->route('trips.show', $trip)
            ->with('success', 'Reis bijgewerkt.');
    }

    public function destroy(Trip $trip)
    {
        if ($trip->owner_id !== Auth::id()) abort(403);
        $trip->delete();
        return redirect()->route('trips.index')->with('success', 'Reis verwijderd.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'    => 'required|string|max:255',
            'country'  => 'nullable|string|max:100',
            'dates'    => 'nullable|string|max:100',
            'starts_on'=> 'nullable|date',
            'ends_on'  => 'nullable|date',
            'nights'   => 'nullable|integer|min:0',
            'budget'   => 'nullable|integer|min:0',
        ]);

        $covers = [
            'linear-gradient(135deg,#a87f5e 0%,#5b3b25 60%,#241612 100%)',
            'linear-gradient(135deg,#cfd6c7 0%,#7c8770 60%,#2f3a30 100%)',
            'linear-gradient(135deg,#e9c5c0 0%,#8a3a3a 60%,#2a0d0d 100%)',
            'linear-gradient(135deg,#b8d4e8 0%,#3a6080 60%,#1a2d40 100%)',
        ];

        $trip = Trip::create(array_merge($data, [
            'owner_id' => Auth::id(),
            'cover'    => $covers[array_rand($covers)],
        ]));

        TripMember::create([
            'trip_id' => $trip->id,
            'user_id' => Auth::id(),
            'role'    => 'eigenaar',
        ]);

        return redirect()->route('trips.show', $trip);
    }
}
