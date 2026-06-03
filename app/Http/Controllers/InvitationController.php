<?php

namespace App\Http\Controllers;

use App\Models\TripInvitation;
use App\Models\TripMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    public function show(string $token)
    {
        $invite = TripInvitation::where('token', $token)->with('trip')->firstOrFail();

        if (!$invite->isPending()) {
            return view('invitations.expired', compact('invite'));
        }

        return view('invitations.show', compact('invite', 'token'));
    }

    public function accept(Request $request, string $token)
    {
        $invite = TripInvitation::where('token', $token)->with('trip')->firstOrFail();

        if (!$invite->isPending()) {
            return redirect()->route('trips.index')->with('info', 'Deze uitnodiging is al gebruikt of verlopen.');
        }

        if (!Auth::check()) {
            // Store token in session and redirect to register/login
            session(['invite_token' => $token]);
            return redirect()->route('register', ['invite' => $token]);
        }

        $this->addMember($invite);

        return redirect()
            ->route('trips.show', $invite->trip)
            ->with('success', 'Welkom bij "' . $invite->trip->title . '"! 🎉');
    }

    public function destroy(TripInvitation $invitation)
    {
        $tripId = $invitation->trip_id;
        $invitation->delete();
        return redirect()->route('trips.show', [$tripId, 'tab' => 'leden']);
    }

    private function addMember(TripInvitation $invite): void
    {
        TripMember::updateOrCreate(
            ['trip_id' => $invite->trip_id, 'user_id' => Auth::id()],
            ['role' => $invite->role]
        );
        $invite->update(['accepted_at' => now()]);
    }
}
