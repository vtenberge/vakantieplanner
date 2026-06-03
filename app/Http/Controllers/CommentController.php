<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Trip;
use App\Models\TripComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Trip $trip)
    {
        $data = $request->validate(['body' => 'required|string|max:1000']);

        TripComment::create([
            'trip_id' => $trip->id,
            'user_id' => Auth::id(),
            'body'    => $data['body'],
        ]);

        ActivityLog::record($trip->id, '💬', Auth::user()->name . ' stuurde een bericht');

        return redirect()->route('trips.show', [$trip, 'tab' => 'chat']);
    }

    public function destroy(TripComment $comment)
    {
        $trip = $comment->trip;
        abort_if($comment->user_id !== Auth::id(), 403);
        $comment->delete();
        return redirect()->route('trips.show', [$trip, 'tab' => 'chat']);
    }
}
