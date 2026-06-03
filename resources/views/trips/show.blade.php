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
            <button class="btn-hero" onclick="document.getElementById('edit-trip-modal').style.display='flex'"><x-icon name="share" :s="14"/> Bewerken</button>
            @if($trip->owner_id === auth()->id())
            <form method="POST" action="{{ route('trips.destroy', $trip) }}" style="display:inline" onsubmit="return confirm('Reis definitief verwijderen? Dit kan niet ongedaan worden gemaakt.')">
              @csrf @method('DELETE')
              <button type="submit" class="btn-hero" style="color:#f87171">Verwijderen</button>
            </form>
            @endif
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
{{-- Edit trip modal --}}
<div id="edit-trip-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:100;align-items:center;justify-content:center">
  <div style="background:var(--vp-bg);border-radius:var(--vp-radius-lg);padding:32px;width:480px;border:1px solid var(--vp-line)">
    <h2 style="font-family:var(--vp-display);font-size:28px;font-weight:400;margin:0 0 24px">Reis bewerken</h2>
    <form method="POST" action="{{ route('trips.update', $trip) }}" style="display:flex;flex-direction:column;gap:14px">
      @csrf @method('PATCH')
      <div>
        <label class="field-label">Bestemming *</label>
        <input name="title" class="field" value="{{ $trip->title }}" required/>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
        <div>
          <label class="field-label">Land</label>
          <input name="country" class="field" value="{{ $trip->country }}"/>
        </div>
        <div>
          <label class="field-label">Nachten</label>
          <input name="nights" type="number" class="field" value="{{ $trip->nights }}" min="0"/>
        </div>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
        <div>
          <label class="field-label">Vertrekdatum</label>
          <input name="starts_on" type="date" class="field" value="{{ $trip->starts_on?->format('Y-m-d') }}"/>
        </div>
        <div>
          <label class="field-label">Terugkomstdatum</label>
          <input name="ends_on" type="date" class="field" value="{{ $trip->ends_on?->format('Y-m-d') }}"/>
        </div>
      </div>
      <div>
        <label class="field-label">Budget (€)</label>
        <input name="budget" type="number" class="field" value="{{ $trip->budget }}" min="0"/>
      </div>
      <div style="display:flex;gap:10px;margin-top:8px">
        <button type="submit" class="btn-primary" style="flex:1;justify-content:center;padding:13px">Opslaan</button>
        <button type="button" onclick="document.getElementById('edit-trip-modal').style.display='none'" class="btn-ghost" style="flex:1;justify-content:center;padding:13px">Annuleren</button>
      </div>
    </form>
  </div>
</div>
</x-layout>
