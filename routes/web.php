<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\BudgetItemController;
use App\Http\Controllers\DayController;
use App\Http\Controllers\DayItemController;
use App\Http\Controllers\PackingItemController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\TripMemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('trips.index'));

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login',   [LoginController::class, 'login']);
    Route::get('/register', [LoginController::class, 'showRegister'])->name('register');
    Route::post('/register',[LoginController::class, 'register']);
});
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Invitations (public — token-based)
Route::get('/uitnodiging/{token}',           [InvitationController::class, 'show'])->name('invitations.show');
Route::post('/uitnodiging/{token}/accepteer',[InvitationController::class, 'accept'])->name('invitations.accept');

// App (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/reizen',              [TripController::class, 'index'])->name('trips.index');
    Route::post('/reizen',             [TripController::class, 'store'])->name('trips.store');
    Route::get('/reizen/{trip}',       [TripController::class, 'show'])->name('trips.show');
    Route::patch('/reizen/{trip}',     [TripController::class, 'update'])->name('trips.update');
    Route::delete('/reizen/{trip}',    [TripController::class, 'destroy'])->name('trips.destroy');

    Route::post('/reizen/{trip}/paklijst',          [PackingItemController::class, 'store'])->name('packing.store');
    Route::patch('/paklijst/{item}/toggle',          [PackingItemController::class, 'toggle'])->name('packing.toggle');
    Route::delete('/paklijst/{item}',                [PackingItemController::class, 'destroy'])->name('packing.destroy');

    Route::post('/reizen/{trip}/plekken',            [PlaceController::class, 'store'])->name('places.store');
    Route::post('/plekken/{place}/like',             [PlaceController::class, 'like'])->name('places.like');
    Route::delete('/plekken/{place}',                [PlaceController::class, 'destroy'])->name('places.destroy');

    Route::post('/reizen/{trip}/budget',             [BudgetItemController::class, 'store'])->name('budget.store');
    Route::delete('/budget/{item}',                  [BudgetItemController::class, 'destroy'])->name('budget.destroy');

    Route::post('/reizen/{trip}/boekingen',          [BookingController::class, 'store'])->name('bookings.store');
    Route::delete('/boekingen/{booking}',            [BookingController::class, 'destroy'])->name('bookings.destroy');

    Route::post('/reizen/{trip}/dagen',              [DayController::class, 'store'])->name('days.store');
    Route::delete('/dagen/{day}',                    [DayController::class, 'destroy'])->name('days.destroy');

    Route::post('/reizen/{trip}/dagen/{day}/items',  [DayItemController::class, 'store'])->name('dayitems.store');
    Route::delete('/dagitems/{item}',                [DayItemController::class, 'destroy'])->name('dayitems.destroy');

    Route::delete('/uitnodiging/{invitation}',        [InvitationController::class, 'destroy'])->name('invitations.destroy');

    Route::post('/reizen/{trip}/leden',              [TripMemberController::class, 'store'])->name('members.store');
    Route::patch('/reizen/{trip}/leden/{member}',    [TripMemberController::class, 'updateRole'])->name('members.update');
    Route::delete('/reizen/{trip}/leden/{member}',   [TripMemberController::class, 'destroy'])->name('members.destroy');
});
