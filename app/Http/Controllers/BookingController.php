<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request, Trip $trip)
    {
        $data = $request->validate([
            'type'         => 'required|string|max:50',
            'title'        => 'required|string|max:255',
            'date_label'   => 'nullable|string|max:100',
            'booking_code' => 'nullable|string|max:50',
            'cost'         => 'required|integer|min:0',
        ]);

        Booking::create([
            'trip_id'      => $trip->id,
            'type'         => $data['type'],
            'title'        => $data['title'],
            'date_label'   => $data['date_label'] ?? null,
            'booking_code' => $data['booking_code'] ?? null,
            'cost'         => $data['cost'],
            'added_by'     => Auth::id(),
        ]);

        return redirect()
            ->route('trips.show', [$trip, 'tab' => 'boeking'])
            ->with('success', 'Boeking "' . $data['title'] . '" toegevoegd.');
    }
}
