<?php

namespace App\Http\Controllers;

use App\Models\BudgetItem;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetItemController extends Controller
{
    public function store(Request $request, Trip $trip)
    {
        $data = $request->validate([
            'title'  => 'required|string|max:255',
            'amount' => 'required|integer|min:0',
            'split'  => 'nullable|string|max:50',
        ]);

        BudgetItem::create([
            'trip_id' => $trip->id,
            'title'   => $data['title'],
            'user_id' => Auth::id(),
            'amount'  => $data['amount'],
            'split'   => $data['split'] ?? 'alle',
        ]);

        return redirect()
            ->route('trips.show', [$trip, 'tab' => 'budget'])
            ->with('success', 'Uitgave "' . $data['title'] . '" van € ' . $data['amount'] . ' toegevoegd.');
    }
}
