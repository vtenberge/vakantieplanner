@php
$mapHeight = $height ?? 200;
$mapId     = 'map-' . uniqid();
$places    = $mapPlaces ?? collect();
$lat       = $mapLat ?? 38.7223;
$lng       = $mapLng ?? -9.1393;
$zoom      = $mapZoom ?? 13;
$doSave    = $saveState ?? false;
$tId       = $tripId ?? null;
@endphp

<div id="{{ $mapId }}" style="width:100%;height:{{ $mapHeight }}px;border-radius:var(--vp-radius);overflow:hidden;border:1px solid var(--vp-line);"></div>

<script>
(function(){
  const map = L.map('{{ $mapId }}', { zoomControl: true, scrollWheelZoom: false })
    .setView([{{ $lat }}, {{ $lng }}], {{ $zoom }});

  L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> © <a href="https://carto.com/">CARTO</a>',
    maxZoom: 19,
  }).addTo(map);

  const accentColor = getComputedStyle(document.documentElement)
    .getPropertyValue('--vp-accent').trim() || '#e07a5f';

  const pinIcon = L.divIcon({
    className: '',
    html: `<svg width="28" height="34" viewBox="0 0 28 34" xmlns="http://www.w3.org/2000/svg">
      <path d="M14 1C7.37 1 2 6.37 2 13c0 8.5 12 20 12 20S26 21.5 26 13C26 6.37 20.63 1 14 1Z"
        fill="${accentColor}" stroke="white" stroke-width="1.5"/>
      <circle cx="14" cy="13" r="4" fill="white"/>
    </svg>`,
    iconSize: [28, 34],
    iconAnchor: [14, 34],
    popupAnchor: [0, -34],
  });

  @foreach($places as $i => $place)
  @if($place->lat && $place->lng)
  L.marker([{{ $place->lat }}, {{ $place->lng }}], { icon: pinIcon })
    .addTo(map)
    .bindPopup(`<strong>{{ addslashes($place->name) }}</strong><br><span style="font-size:11px;color:#888">{{ addslashes($place->kind) }}</span>`);
  @endif
  @endforeach

  @if($doSave && $tId)
  const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  let saveTimer;
  map.on('moveend zoomend', () => {
    clearTimeout(saveTimer);
    saveTimer = setTimeout(() => {
      const c = map.getCenter();
      fetch('/reizen/{{ $tId }}/kaartstand', {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ map_lat: c.lat, map_lng: c.lng, map_zoom: map.getZoom() }),
      });
    }, 800);
  });
  @endif
})();
</script>
