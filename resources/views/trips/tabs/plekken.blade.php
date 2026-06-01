<div class="section-head">
  <div>
    <div class="section-kicker">{{ $trip->places->count() }} suggesties</div>
    <h2 class="section-title">Plekken &amp; restaurants</h2>
  </div>
  <form method="POST" action="{{ route('places.store', $trip) }}" class="inline-form">
    @csrf
    <input name="name" class="field" style="width:220px;padding:10px 14px;font-size:13px" placeholder="Tip een plek..." required/>
    <select name="kind" class="field" style="width:130px;padding:10px 14px;font-size:13px">
      <option>Restaurant</option><option>Bar</option><option>Markt</option><option>Bakkerij</option><option selected>Plek</option>
    </select>
    <button type="submit" class="btn-primary"><x-icon name="plus" :s="14"/> Voorstellen</button>
  </form>
</div>

<div class="places-grid">
  <div>
    @foreach($trip->places as $i => $place)
    <div class="place-row">
      <div class="place-num">{{ $i + 1 }}</div>
      <div style="flex:1;min-width:0">
        <div class="place-kind">{{ $place->kind }}</div>
        <div class="place-name">{{ $place->name }}</div>
        <div class="place-note">{{ $place->note }}</div>
      </div>
      <div class="place-liked">
        <x-icon name="star" :s="14"/>{{ $place->liked }}
      </div>
    </div>
    @endforeach
  </div>
  <div>
    @include('trips.partials.mini-map', ['label' => $trip->title, 'height' => 420])
  </div>
</div>
