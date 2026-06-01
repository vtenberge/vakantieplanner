<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BudgetItemController;
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

// App (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/reizen',         [TripController::class, 'index'])->name('trips.index');
    Route::post('/reizen',        [TripController::class, 'store'])->name('trips.store');
    Route::get('/reizen/{trip}',  [TripController::class, 'show'])->name('trips.show');

    Route::post('/reizen/{trip}/paklijst',         [PackingItemController::class, 'store'])->name('packing.store');
    Route::patch('/paklijst/{item}/toggle',         [PackingItemController::class, 'toggle'])->name('packing.toggle');

    Route::post('/reizen/{trip}/plekken',           [PlaceController::class, 'store'])->name('places.store');

    Route::post('/reizen/{trip}/budget',            [BudgetItemController::class, 'store'])->name('budget.store');

    Route::post('/reizen/{trip}/leden',             [TripMemberController::class, 'store'])->name('members.store');
    Route::patch('/reizen/{trip}/leden/{member}',   [TripMemberController::class, 'updateRole'])->name('members.update');
    Route::delete('/reizen/{trip}/leden/{member}',  [TripMemberController::class, 'destroy'])->name('members.destroy');
});
