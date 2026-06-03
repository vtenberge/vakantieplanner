<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Trip;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function store(Request $request, Trip $trip)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'kind' => 'nullable|string|max:50',
            'note' => 'nullable|string|max:255',
        ]);

        Place::create([
            'trip_id' => $trip->id,
            'name'    => $data['name'],
            'kind'    => $data['kind'] ?? 'Plek',
            'note'    => $data['note'] ?? '',
            'liked'   => 0,
        ]);

        return redirect()
            ->route('trips.show', [$trip, 'tab' => 'plekken'])
            ->with('success', '"' . $data['name'] . '" toegevoegd aan plekken.');
    }

    public function like(Place $place)
    {
        $place->increment('liked');
        return redirect()->route('trips.show', [$place->trip_id, 'tab' => 'plekken']);
    }

    public function destroy(Place $place)
    {
        $tripId = $place->trip_id;
        $place->delete();
        return redirect()->route('trips.show', [$tripId, 'tab' => 'plekken']);
    }
}
