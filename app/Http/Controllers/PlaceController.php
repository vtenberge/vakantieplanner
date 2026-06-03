<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Place;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaceController extends Controller
{
    public function store(Request $request, Trip $trip)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'kind' => 'nullable|string|max:50',
            'note' => 'nullable|string|max:255',
            'lat'  => 'nullable|numeric|between:-90,90',
            'lng'  => 'nullable|numeric|between:-180,180',
        ]);

        Place::create([
            'trip_id' => $trip->id,
            'name'    => $data['name'],
            'kind'    => $data['kind'] ?? 'Plek',
            'note'    => $data['note'] ?? '',
            'liked'   => 0,
            'lat'     => $data['lat'] ?? null,
            'lng'     => $data['lng'] ?? null,
        ]);

        ActivityLog::record($trip->id, '📍', Auth::user()->name . ' voegde plek "' . $data['name'] . '" toe');

        return redirect()
            ->route('trips.show', [$trip, 'tab' => 'plekken'])
            ->with('success', '"' . $data['name'] . '" toegevoegd aan plekken.');
    }

    public function updateLocation(Request $request, Place $place)
    {
        $data = $request->validate([
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
        ]);
        $place->update($data);
        return response()->json(['ok' => true]);
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
