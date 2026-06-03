<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\PackingItem;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackingItemController extends Controller
{
    public function store(Request $request, Trip $trip)
    {
        $data = $request->validate([
            'text'        => 'required|string|max:255',
            'category'    => 'nullable|string|max:50',
            'assigned_to' => 'nullable|integer|exists:users,id',
        ]);

        PackingItem::create([
            'trip_id'     => $trip->id,
            'text'        => $data['text'],
            'category'    => $data['category'] ?? 'Overig',
            'user_id'     => Auth::id(),
            'assigned_to' => $data['assigned_to'] ?? null,
            'done'        => false,
        ]);

        ActivityLog::record($trip->id, '🎒', Auth::user()->name . ' voegde "' . $data['text'] . '" toe aan de paklijst');

        return redirect()
            ->route('trips.show', [$trip, 'tab' => 'paklijst'])
            ->with('success', '"' . $data['text'] . '" toegevoegd aan de paklijst.');
    }

    public function toggle(PackingItem $item)
    {
        $item->update(['done' => !$item->done]);
        return back();
    }

    public function assign(Request $request, PackingItem $item)
    {
        $data = $request->validate(['assigned_to' => 'nullable|integer|exists:users,id']);
        $item->update(['assigned_to' => $data['assigned_to'] ?: null]);
        return back();
    }

    public function destroy(PackingItem $item)
    {
        $trip = $item->trip;
        $item->delete();
        return redirect()->route('trips.show', [$trip, 'tab' => 'paklijst']);
    }
}
