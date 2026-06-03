<?php

namespace App\Http\Controllers;

use App\Models\TripDay;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DayItemController extends Controller
{
    public function store(Request $request, Trip $trip, TripDay $day)
    {
        abort_if($day->trip_id !== $trip->id, 404);

        $data = $request->validate([
            'time'  => 'nullable|string|max:10',
            'title' => 'required|string|max:255',
            'kind'  => 'required|in:flight,food,transit,place',
        ]);

        $day->items()->create([
            'time'     => $data['time'] ?: null,
            'title'    => $data['title'],
            'kind'     => $data['kind'],
            'added_by' => Auth::id(),
        ]);

        return redirect()
            ->route('trips.show', [$trip, 'tab' => 'dagen'])
            ->with('success', 'Activiteit toegevoegd aan dag ' . $day->day_number . '.');
    }

    public function destroy(\App\Models\DayItem $item)
    {
        $tripId = $item->day->trip_id;
        $item->delete();
        return redirect()->route('trips.show', [$tripId, 'tab' => 'dagen']);
    }
}
