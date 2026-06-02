<div class="section-head">
  <div>
    <div class="section-kicker">{{ $trip->places->count() }} gepind</div>
    <h2 class="section-title">Op de kaart</h2>
  </div>
</div>

<div class="map-layout">
  <div>
    @include('trips.partials.mini-map', [
      'height'    => 500,
      'mapLat'    => $trip->map_lat ?? 38.7223,
      'mapLng'    => $trip->map_lng ?? -9.1393,
      'mapZoom'   => $trip->map_zoom ?? 13,
      'mapPlaces' => $trip->places,
    ])
  </div>
  <div>
    <div class="kicker-label" style="margin-bottom:10px">Plekken</div>
    @foreach($trip->places as $i => $place)
    <div class="map-place-row">
      <div class="map-place-num">{{ $i + 1 }}</div>
      <div style="flex:1">
        <div style="font-size:13px;font-weight:500">{{ $place->name }}</div>
        <div style="font-size:11px;color:var(--vp-fg-mut)">{{ $place->kind }}</div>
      </div>
      <x-icon name="arrow" :s="14"/>
    </div>
    @endforeach
  </div>
</div>
