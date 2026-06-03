<div class="section-head">
  <div>
    <div class="section-kicker">{{ $trip->places->count() }} suggesties</div>
    <h2 class="section-title">Plekken &amp; restaurants</h2>
  </div>
  <form method="POST" action="{{ route('places.store', $trip) }}" class="inline-form">
    @csrf
    <input name="name" class="field" style="width:200px;padding:10px 14px;font-size:13px" placeholder="Tip een plek..." required/>
    <input name="note" class="field" style="width:150px;padding:10px 14px;font-size:13px" placeholder="Opmerking (opt.)"/>
    <select name="kind" class="field" style="width:120px;padding:10px 14px;font-size:13px">
      <option>Restaurant</option><option>Bar</option><option>Markt</option><option>Bakkerij</option><option selected>Plek</option>
    </select>
    <button type="submit" class="btn-primary"><x-icon name="plus" :s="14"/> Voorstellen</button>
  </form>
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
      </div>
      <form method="POST" action="{{ route('places.like', $place) }}" style="display:inline">
        @csrf
        <button type="submit" class="place-liked {{ $place->liked > 0 ? 'active' : '' }}" title="Stem omhoog" style="background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:4px;padding:4px 8px;border-radius:6px;font-size:13px;font-weight:600;color:var(--vp-fg-sub)">
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
    ])
  </div>
</div>
