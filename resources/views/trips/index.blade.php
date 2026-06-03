<x-layout title="Mijn reizen — Vakantieplanner">
<div class="app-shell">
  <x-sidebar active="trips" :trips="$trips"/>

  <main class="main-area">
    <div class="main-scroll" style="padding:30px 40px 40px">
      <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:30px">
        <div>
          <div class="page-header-text" id="trip-count">{{ $trips->count() }} reizen</div>
          <h1 class="page-title">Mijn reizen</h1>
        </div>
        <button onclick="document.getElementById('new-trip-modal').style.display='flex'" class="btn-primary">
          <x-icon name="plus" :s="14"/> Nieuwe reis
        </button>
      </div>

      <div style="display:flex;gap:8px;margin-bottom:24px">
        <button class="pill active" onclick="filterTrips('aankomend', this)">Aankomend</button>
        <button class="pill" onclick="filterTrips('ideeen', this)">Ideeën</button>
        <button class="pill" onclick="filterTrips('afgelopen', this)">Afgelopen</button>
        <button class="pill" onclick="filterTrips('alle', this)">Alle</button>
      </div>

      <div class="trip-grid" id="trip-grid">
        @foreach($trips as $trip)
        @php
          $status = 'ideeen';
          if ($trip->starts_on) {
            $status = $trip->starts_on->isFuture() ? 'aankomend' : ($trip->ends_on?->isPast() ? 'afgelopen' : 'aankomend');
          }
        @endphp
        <a href="{{ route('trips.show', $trip) }}" class="trip-card" data-status="{{ $status }}">
          <div class="trip-card-cover" style="background:{{ $trip->cover }}">
            <div style="position:absolute;inset:0;background:linear-gradient(180deg,transparent 30%,rgba(0,0,0,.4) 100%)"></div>
            <div class="trip-card-country">{{ $trip->country }}</div>
            <div class="trip-card-title">{{ $trip->title }}</div>
          </div>
          <div class="trip-card-body">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px">
              <div>
                <div class="trip-card-dates">{{ $trip->dates }}</div>
                <div class="trip-card-meta">{{ $trip->nights }} nachten{{ $trip->subtitle ? ' · ' . $trip->subtitle : '' }}</div>
              </div>
              <div class="trip-card-days">
                @if($status === 'aankomend')
                nog<strong>{{ $trip->days_away }}</strong>dagen
                @elseif($status === 'afgelopen')
                <span style="font-size:10px;opacity:.6">afgelopen</span>
                @else
                <span style="font-size:10px;opacity:.6">idee</span>
                @endif
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
      <div>
        <label class="field-label">Ondertitel</label>
        <input name="subtitle" class="field" placeholder="Zomervakantie met het gezin"/>
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

<script>
function filterTrips(filter, btn) {
  document.querySelectorAll('.pill').forEach(p => p.classList.remove('active'));
  btn.classList.add('active');

  const cards = document.querySelectorAll('#trip-grid .trip-card');
  let visible = 0;
  cards.forEach(card => {
    const status = card.dataset.status;
    const show = filter === 'alle' || status === filter;
    card.style.display = show ? '' : 'none';
    if (show) visible++;
  });
  document.getElementById('trip-count').textContent = visible + ' reizen';
}

// Start on 'aankomend'
filterTrips('aankomend', document.querySelector('.pill.active'));
</script>
</x-layout>
