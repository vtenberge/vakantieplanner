<x-layout title="Mijn reizen — Vakantieplanner">
<div class="app-shell">
  <x-sidebar active="trips" :trips="$trips"/>

  <main class="main-area">
    <div class="main-scroll" style="padding:30px 40px 40px">
      <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:30px">
        <div>
          <div class="page-header-text">{{ $trips->count() }} reizen</div>
          <h1 class="page-title">Mijn reizen</h1>
        </div>
        <button onclick="document.getElementById('new-trip-modal').style.display='flex'" class="btn-primary">
          <x-icon name="plus" :s="14"/> Nieuwe reis
        </button>
      </div>

      <div style="display:flex;gap:8px;margin-bottom:24px">
        <span class="pill active">Aankomend</span>
        <span class="pill">Ideeën</span>
        <span class="pill">Afgelopen</span>
        <span class="pill">Alle</span>
      </div>

      <div class="trip-grid">
        @foreach($trips as $trip)
        <a href="{{ route('trips.show', $trip) }}" class="trip-card">
          <div class="trip-card-cover" style="background:{{ $trip->cover }}">
            <div style="position:absolute;inset:0;background:linear-gradient(180deg,transparent 30%,rgba(0,0,0,.4) 100%)"></div>
            <div class="trip-card-country">{{ $trip->country }}</div>
            <div class="trip-card-title">{{ $trip->title }}</div>
          </div>
          <div class="trip-card-body">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px">
              <div>
                <div class="trip-card-dates">{{ $trip->dates }}</div>
                <div class="trip-card-meta">{{ $trip->nights }} nachten · {{ $trip->subtitle }}</div>
              </div>
              <div class="trip-card-days">
                nog<strong>{{ $trip->days_away }}</strong>dagen
              </div>
            </div>
            <div class="trip-card-footer">
              <div class="avatar-stack">
                @foreach($trip->tripMembers->take(5) as $member)
                <x-avatar :name="$member->user->name" :size="22"/>
                @endforeach
              </div>
              <div style="font-size:11px;color:var(--vp-fg-mut)">{{ $trip->tripMembers->count() }} reisgenoten</div>
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </main>
</div>

{{-- New trip modal --}}
<div id="new-trip-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:100;align-items:center;justify-content:center">
  <div style="background:var(--vp-bg);border-radius:var(--vp-radius-lg);padding:32px;width:480px;border:1px solid var(--vp-line)">
    <h2 style="font-family:var(--vp-display);font-size:28px;font-weight:400;margin:0 0 24px">Nieuwe reis</h2>
    <form method="POST" action="{{ route('trips.store') }}" style="display:flex;flex-direction:column;gap:14px">
      @csrf
      <div>
        <label class="field-label">Bestemming *</label>
        <input name="title" class="field" placeholder="Lissabon" required/>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
        <div>
          <label class="field-label">Land</label>
          <input name="country" class="field" placeholder="Portugal"/>
        </div>
        <div>
          <label class="field-label">Nachten</label>
          <input name="nights" type="number" class="field" placeholder="7" min="0"/>
        </div>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
        <div>
          <label class="field-label">Vertrekdatum</label>
          <input name="starts_on" type="date" class="field"/>
        </div>
        <div>
          <label class="field-label">Terugkomstdatum</label>
          <input name="ends_on" type="date" class="field"/>
        </div>
      </div>
      <div>
        <label class="field-label">Budget (€)</label>
        <input name="budget" type="number" class="field" placeholder="1200" min="0"/>
      </div>
      <div style="display:flex;gap:10px;margin-top:8px">
        <button type="submit" class="btn-primary" style="flex:1;justify-content:center;padding:13px">Reis aanmaken</button>
        <button type="button" onclick="document.getElementById('new-trip-modal').style.display='none'" class="btn-ghost" style="flex:1;justify-content:center;padding:13px">Annuleren</button>
      </div>
    </form>
  </div>
</div>
</x-layout>
