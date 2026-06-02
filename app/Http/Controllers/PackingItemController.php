<?php

namespace App\Http\Controllers;

use App\Models\PackingItem;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackingItemController extends Controller
{
    public function store(Request $request, Trip $trip)
    {
        $data = $request->validate([
            'text'     => 'required|string|max:255',
            'category' => 'nullable|string|max:50',
        ]);

        PackingItem::create([
            'trip_id'  => $trip->id,
            'text'     => $data['text'],
            'category' => $data['category'] ?? 'Overig',
            'user_id'  => Auth::id(),
            'done'     => false,
        ]);

        return redirect()
            ->route('trips.show', [$trip, 'tab' => 'paklijst'])
            ->with('success', '"' . $data['text'] . '" toegevoegd aan de paklijst.');
    }

    public function toggle(PackingItem $item)
    {
        $item->update(['done' => !$item->done]);
        return back();
    }
}
