<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TripInvitation;
use App\Models\TripMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) return redirect()->route('trips.index');
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Accept pending invite if token is in session
            if ($token = session()->pull('invite_token')) {
                return redirect()->route('invitations.accept', $token);
            }

            return redirect()->intended(route('trips.index'));
        }

        return back()->withErrors(['email' => 'Ongeldig e-mailadres of wachtwoord.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function showRegister(Request $request)
    {
        if (Auth::check()) return redirect()->route('trips.index');

        $invite = null;
        if ($token = $request->query('invite')) {
            $invite = TripInvitation::where('token', $token)->with('trip')->first();
        }

        return view('auth.register', compact('invite'));
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'invite'   => 'nullable|string',
        ]);

        $user = \App\Models\User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        // Accept invite if token was passed
        if (!empty($data['invite'])) {
            $invite = TripInvitation::where('token', $data['invite'])
                ->whereNull('accepted_at')
                ->with('trip')
                ->first();

            if ($invite && $invite->isPending()) {
                TripMember::updateOrCreate(
                    ['trip_id' => $invite->trip_id, 'user_id' => $user->id],
                    ['role' => $invite->role]
                );
                $invite->update(['accepted_at' => now()]);

                return redirect()
                    ->route('trips.show', $invite->trip)
                    ->with('success', 'Account aangemaakt en welkom bij "' . $invite->trip->title . '"! 🎉');
            }
        }

        return redirect()->route('trips.index');
    }
}
