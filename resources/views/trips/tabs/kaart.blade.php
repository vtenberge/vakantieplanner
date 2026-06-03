<div class="section-head">
  <div>
    <div class="section-kicker">{{ $trip->places->count() }} gepind</div>
    <h2 class="section-title">Op de kaart</h2>
  </div>
  <div id="locate-hint" style="font-size:13px;color:var(--vp-fg-mut);display:none;align-items:center;gap:8px">
    Klik op de kaart om locatie in te stellen voor <strong id="locate-name"></strong>
    <button onclick="cancelLocate()" class="btn-ghost" style="padding:6px 12px;font-size:12px">Annuleren</button>
  </div>
</div>

<div class="map-layout">
  <div id="kaart-map-wrap">
    @php
      $mapId = 'kaart-map';
    @endphp
    <div id="{{ $mapId }}" style="width:100%;height:500px;border-radius:var(--vp-radius);overflow:hidden;border:1px solid var(--vp-line);cursor:crosshair"></div>
  </div>
  <div>
    <div class="kicker-label" style="margin-bottom:10px">Plekken</div>
    @forelse($trip->places as $i => $place)
    <div class="map-place-row" id="place-row-{{ $place->id }}">
      <div class="map-place-num">{{ $i + 1 }}</div>
      <div style="flex:1">
        <div style="font-size:13px;font-weight:500">{{ $place->name }}</div>
        <div style="font-size:11px;color:var(--vp-fg-mut)">{{ $place->kind }}</div>
      </div>
      @if($place->lat && $place->lng)
      <span style="font-size:11px;color:var(--vp-accent)">📍</span>
      @endif
      <button onclick="startLocate({{ $place->id }}, '{{ addslashes($place->name) }}')"
        class="btn-icon" title="Locatie instellen op kaart" style="opacity:.5;padding:4px;font-size:13px">✏️</button>
    </div>
    @empty
    <div style="padding:24px;text-align:center;color:var(--vp-fg-mut);font-size:14px">Voeg plekken toe via het tabblad Plekken.</div>
    @endforelse
  </div>
</div>

<script>
(function(){
  const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const TRIP_ID = {{ $trip->id }};
  const SAVE_URL = '{{ route('trips.mapstate', $trip) }}';

  const map = L.map('kaart-map', { zoomControl: true, scrollWheelZoom: true })
    .setView([{{ $trip->map_lat ?? 38.7223 }}, {{ $trip->map_lng ?? -9.1393 }}], {{ $trip->map_zoom ?? 13 }});

  L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> © <a href="https://carto.com/">CARTO</a>',
    maxZoom: 19,
  }).addTo(map);

  const accentColor = getComputedStyle(document.documentElement).getPropertyValue('--vp-accent').trim() || '#e07a5f';

  function makeIcon(label) {
    return L.divIcon({
      className: '',
      html: `<div style="background:${accentColor};color:white;width:26px;height:26px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);display:flex;align-items:center;justify-content:center;border:2px solid white;box-shadow:0 2px 6px rgba(0,0,0,.3)">
        <span style="transform:rotate(45deg);font-size:11px;font-weight:700">${label}</span></div>`,
      iconSize: [26, 26],
      iconAnchor: [13, 26],
      popupAnchor: [0, -28],
    });
  }

  const markers = {};
  @foreach($trip->places as $i => $place)
  @if($place->lat && $place->lng)
  markers[{{ $place->id }}] = L.marker([{{ $place->lat }}, {{ $place->lng }}], { icon: makeIcon({{ $i + 1 }}) })
    .addTo(map)
    .bindPopup(`<strong>{{ addslashes($place->name) }}</strong><br><span style="font-size:11px;color:#888">{{ addslashes($place->kind) }}</span>`);
  @endif
  @endforeach

  // Save map state on move/zoom
  let saveTimer;
  function saveState() {
    const c = map.getCenter();
    fetch(SAVE_URL, {
      method: 'PATCH',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
      body: JSON.stringify({ map_lat: c.lat, map_lng: c.lng, map_zoom: map.getZoom() }),
    });
  }
  map.on('moveend zoomend', () => { clearTimeout(saveTimer); saveTimer = setTimeout(saveState, 800); });

  // Locating mode
  let activeLocateId = null;

  window.startLocate = function(placeId, placeName) {
    activeLocateId = placeId;
    document.getElementById('locate-hint').style.display = 'flex';
    document.getElementById('locate-name').textContent = placeName;
    map.getContainer().style.cursor = 'crosshair';
    map.getContainer().classList.add('locate-mode');
  };

  window.cancelLocate = function() {
    activeLocateId = null;
    document.getElementById('locate-hint').style.display = 'none';
    map.getContainer().style.cursor = '';
  };

  map.on('click', function(e) {
    if (!activeLocateId) return;
    const { lat, lng } = e.latlng;

    fetch(`/plekken/${activeLocateId}/locatie`, {
      method: 'PATCH',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
      body: JSON.stringify({ lat, lng }),
    }).then(r => r.json()).then(() => {
      const row = document.getElementById('place-row-' + activeLocateId);
      if (row && !row.querySelector('.loc-dot')) {
        const dot = document.createElement('span');
        dot.className = 'loc-dot';
        dot.textContent = '📍';
        dot.style.cssText = 'font-size:11px;color:var(--vp-accent)';
        row.querySelector('[style*="flex:1"]').insertAdjacentElement('afterend', dot);
      }

      // Update or add marker
      const idx = Object.keys(markers).length + 1;
      if (markers[activeLocateId]) {
        markers[activeLocateId].setLatLng([lat, lng]);
      } else {
        markers[activeLocateId] = L.marker([lat, lng], { icon: makeIcon(idx) })
          .addTo(map);
      }

      cancelLocate();
    });
  });
})();
</script>

<style>
.locate-mode { outline: 2px solid var(--vp-accent); outline-offset: -2px; }
</style>
