<div class="section-head">
  <div>
    <div class="section-kicker">{{ $trip->places->count() }} suggesties</div>
    <h2 class="section-title">Plekken &amp; restaurants</h2>
  </div>
  <button class="btn-primary" onclick="document.getElementById('add-place-modal').style.display='flex'">
    <x-icon name="plus" :s="14"/> Plek voorstellen
  </button>
</div>

<div class="places-grid">
  <div>
    @forelse($trip->places->sortByDesc('liked') as $i => $place)
    <div class="place-row">
      <div class="place-num">{{ $i + 1 }}</div>
      <div style="flex:1;min-width:0">
        <div class="place-kind">{{ $place->kind }}</div>
        <div class="place-name">{{ $place->name }}</div>
        @if($place->note)<div class="place-note">{{ $place->note }}</div>@endif
        @if($place->lat && $place->lng)
        <div style="font-size:11px;color:var(--vp-accent);margin-top:2px">📍 Locatie bekend</div>
        @else
        <div style="font-size:11px;color:var(--vp-fg-mut);margin-top:2px">Geen locatie — klik op kaart om in te stellen</div>
        @endif
      </div>
      <form method="POST" action="{{ route('places.like', $place) }}" style="display:inline">
        @csrf
        <button type="submit" class="place-liked {{ $place->liked > 0 ? 'active' : '' }}" style="background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:4px;padding:4px 8px;border-radius:6px;font-size:13px;font-weight:600;color:var(--vp-fg-sub)">
          <x-icon name="star" :s="14"/>{{ $place->liked }}
        </button>
      </form>
      <form method="POST" action="{{ route('places.destroy', $place) }}" onsubmit="return confirm('Plek verwijderen?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn-icon" title="Verwijderen" style="opacity:.4;padding:4px"><x-icon name="more" :s="13"/></button>
      </form>
    </div>
    @empty
    <div style="padding:24px;text-align:center;color:var(--vp-fg-mut);font-size:14px">
      Nog geen plekken — stel er een voor!
    </div>
    @endforelse
  </div>
  <div>
    @include('trips.partials.mini-map', [
      'height'    => 420,
      'mapLat'    => $trip->map_lat ?? 38.7223,
      'mapLng'    => $trip->map_lng ?? -9.1393,
      'mapZoom'   => $trip->map_zoom ?? 13,
      'mapPlaces' => $trip->places,
      'tripId'    => $trip->id,
      'saveState' => true,
    ])
  </div>
</div>

{{-- Modal: Plek toevoegen --}}
<div id="add-place-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:100;align-items:center;justify-content:center">
  <div style="background:var(--vp-bg);border-radius:var(--vp-radius-lg);padding:32px;width:480px;border:1px solid var(--vp-line)">
    <h2 style="font-family:var(--vp-display);font-size:26px;font-weight:400;margin:0 0 20px">Plek voorstellen</h2>
    <form method="POST" action="{{ route('places.store', $trip) }}" id="place-form" style="display:flex;flex-direction:column;gap:12px">
      @csrf
      <input type="hidden" name="lat" id="place-lat"/>
      <input type="hidden" name="lng" id="place-lng"/>
      <div>
        <label class="field-label">Naam *</label>
        <input name="name" id="place-name" class="field" placeholder="Pastéis de Belém" required/>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
        <div>
          <label class="field-label">Type</label>
          <select name="kind" class="field">
            <option>Restaurant</option><option>Bar</option><option>Markt</option>
            <option>Bakkerij</option><option selected>Plek</option><option>Museum</option>
            <option>Strand</option><option>Winkel</option>
          </select>
        </div>
        <div>
          <label class="field-label">Opmerking</label>
          <input name="note" class="field" placeholder="Beroemde pastéis!"/>
        </div>
      </div>
      <div id="geocode-status" style="font-size:12px;color:var(--vp-fg-mut);min-height:18px"></div>
      <div style="display:flex;gap:10px;margin-top:4px">
        <button type="button" onclick="geocodePlace()" class="btn-ghost" style="white-space:nowrap">
          🔍 Locatie opzoeken
        </button>
        <button type="submit" class="btn-primary" style="flex:1;justify-content:center;padding:12px">Toevoegen</button>
        <button type="button" onclick="document.getElementById('add-place-modal').style.display='none'" class="btn-ghost" style="padding:12px">Annuleren</button>
      </div>
    </form>
  </div>
</div>

<script>
const TRIP_COUNTRY = '{{ addslashes($trip->country ?? '') }}';

async function geocodePlace() {
  const name = document.getElementById('place-name').value.trim();
  if (!name) { alert('Vul eerst een naam in.'); return; }
  const status = document.getElementById('geocode-status');
  status.textContent = 'Locatie opzoeken…';
  try {
    const q = encodeURIComponent(name + (TRIP_COUNTRY ? ', ' + TRIP_COUNTRY : ''));
    const res = await fetch(`https://nominatim.openstreetmap.org/search?q=${q}&format=json&limit=1`, {
      headers: { 'Accept-Language': 'nl' }
    });
    const data = await res.json();
    if (data.length) {
      document.getElementById('place-lat').value = data[0].lat;
      document.getElementById('place-lng').value = data[0].lon;
      status.innerHTML = `✅ Gevonden: <strong>${data[0].display_name.split(',').slice(0,2).join(',')}</strong>`;
      status.style.color = 'var(--vp-accent)';
    } else {
      status.textContent = '❌ Geen locatie gevonden — plek wordt zonder kaartpin toegevoegd.';
      status.style.color = 'var(--vp-fg-mut)';
    }
  } catch {
    status.textContent = '⚠️ Zoeken mislukt — controleer je verbinding.';
  }
}

// Auto-geocode on name input after short delay
let geocodeTimer;
document.getElementById('place-name').addEventListener('input', function() {
  clearTimeout(geocodeTimer);
  document.getElementById('geocode-status').textContent = '';
  document.getElementById('place-lat').value = '';
  document.getElementById('place-lng').value = '';
  if (this.value.length > 3) {
    geocodeTimer = setTimeout(geocodePlace, 1000);
  }
});
</script>
