<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\TripDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DayController extends Controller
{
    public function store(Request $request, Trip $trip)
    {
        $member = $trip->tripMembers()->where('user_id', Auth::id())->first();
        if (!$member || !in_array($member->role, ['eigenaar', 'bewerker'])) abort(403);

        $data = $request->validate([
            'date_label' => 'nullable|string|max:50',
            'label'      => 'nullable|string|max:100',
            'weather'    => 'nullable|string|max:50',
        ]);

        $nextNumber = ($trip->days()->max('day_number') ?? 0) + 1;

        TripDay::create([
            'trip_id'    => $trip->id,
            'day_number' => $nextNumber,
            'date_label' => $data['date_label'] ?? 'Dag ' . $nextNumber,
            'label'      => $data['label'] ?? '',
            'weather'    => $data['weather'] ?? '',
        ]);

        return redirect()
            ->route('trips.show', [$trip, 'tab' => 'dagen'])
            ->with('success', 'Dag ' . $nextNumber . ' toegevoegd.');
    }

    public function destroy(TripDay $day)
    {
        $tripId = $day->trip_id;
        $trip = Trip::findOrFail($tripId);
        $member = $trip->tripMembers()->where('user_id', Auth::id())->first();
        if (!$member || !in_array($member->role, ['eigenaar', 'bewerker'])) abort(403);

        $day->delete();

        // Renumber remaining days
        $trip->days()->orderBy('day_number')->each(function ($d, $i) {
            $d->update(['day_number' => $i + 1]);
        });

        return redirect()->route('trips.show', [$trip, 'tab' => 'dagen']);
    }
}
