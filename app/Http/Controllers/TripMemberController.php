<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\TripMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripMemberController extends Controller
{
    public function store(Request $request, Trip $trip)
    {
        $data = $request->validate([
            'email' => 'required|email|exists:users,email',
            'role'  => 'nullable|in:bewerker,kijker',
        ]);

        $user = User::where('email', $data['email'])->first();

        TripMember::updateOrCreate(
            ['trip_id' => $trip->id, 'user_id' => $user->id],
            ['role' => $data['role'] ?? 'kijker']
        );

        return back()->with('tab', 'leden');
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
