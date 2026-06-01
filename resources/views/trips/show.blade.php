<x-layout :title="$trip->title . ' — Vakantieplanner'">
@php
$tabs = [
  ['id' => 'dagen',    'label' => 'Dagen'],
  ['id' => 'paklijst','label' => 'Paklijst'],
  ['id' => 'plekken', 'label' => 'Plekken'],
  ['id' => 'boeking', 'label' => 'Boekingen'],
  ['id' => 'budget',  'label' => 'Budget'],
  ['id' => 'kaart',   'label' => 'Kaart'],
  ['id' => 'leden',   'label' => 'Leden'],
];

$allTrips = \App\Models\Trip::where('owner_id', auth()->id())
  ->orWhereHas('tripMembers', fn($q) => $q->where('user_id', auth()->id()))
  ->with('tripMembers.user')->orderBy('starts_on')->get();

$totalBookings = $trip->bookings->sum('cost');
$totalBudget   = $trip->budgetItems->sum('amount');
$memberCount   = $trip->tripMembers->count();
$perPerson     = $memberCount > 0 ? round($totalBudget / $memberCount) : 0;
@endphp

<div class="app-shell">
  <x-sidebar :trips="$allTrips" :currentTrip="$trip"/>

  <main class="main-area">
    {{-- Hero --}}
    <div class="trip-hero" style="background:{{ $trip->cover }}">
      <div class="trip-hero-overlay"></div>
      <div class="trip-hero-inner">
        <div class="trip-hero-breadcrumb">
          <a href="{{ route('trips.index') }}" class="trip-hero-back">
            <x-icon name="back" :s="14"/> Mijn reizen
          </a>
          <span style="opacity:.5">/</span>
          <span>{{ $trip->title }}</span>
          <div style="margin-left:auto" class="trip-hero-actions">
            <button class="btn-hero"><x-icon name="share" :s="14"/></button>
            <button class="btn-hero"><x-icon name="user" :s="14"/> Uitnodigen</button>
          </div>
        </div>
        <div class="trip-hero-meta">
          <div>
            <div class="trip-hero-eyebrow">{{ $trip->country }} · {{ strtoupper($trip->id) }}-26</div>
            <h1 class="trip-hero-title">{{ $trip->title }}</h1>
            <div class="trip-hero-info">{{ $trip->dates }} · {{ $trip->nights }} nachten · {{ $memberCount }} reisgenoten</div>
          </div>
          <div class="trip-hero-stats">
            <div class="trip-stat">
              <div class="trip-stat-label">Nog</div>
              <div class="trip-stat-value">{{ $trip->days_away }}</div>
              <div class="trip-stat-unit">dgn</div>
            </div>
            <div class="trip-stat">
              <div class="trip-stat-label">Budget</div>
              <div class="trip-stat-value">€{{ $trip->budget }}</div>
              <div class="trip-stat-unit">€{{ $totalBudget }} uit</div>
            </div>
            <div class="trip-stat">
              <div class="trip-stat-label">Plekken</div>
              <div class="trip-stat-value">{{ $trip->places->count() }}</div>
              <div class="trip-stat-unit">gepind</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Tabs --}}
    <nav class="tabs">
      @foreach($tabs as $t)
      <a href="{{ route('trips.show', [$trip, 'tab' => $t['id']]) }}" class="tab-btn {{ $tab === $t['id'] ? 'active' : '' }}">
        {{ $t['label'] }}
      </a>
      @endforeach
    </nav>

    {{-- Tab content --}}
    <div class="main-scroll" style="padding:28px 36px 40px">
      @if(session('success'))
      <div class="flash-success">{{ session('success') }}</div>
      @endif

      @if($tab === 'dagen')
        @include('trips.tabs.dagen')
      @elseif($tab === 'paklijst')
        @include('trips.tabs.paklijst')
      @elseif($tab === 'plekken')
        @include('trips.tabs.plekken')
      @elseif($tab === 'boeking')
        @include('trips.tabs.boeking')
      @elseif($tab === 'budget')
        @include('trips.tabs.budget')
      @elseif($tab === 'kaart')
        @include('trips.tabs.kaart')
      @elseif($tab === 'leden')
        @include('trips.tabs.leden')
      @endif
    </div>
  </main>
</div>
</x-layout>
