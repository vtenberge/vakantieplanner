@php
  $done  = $trip->packingItems->where('done', true)->count();
  $total = $trip->packingItems->count();
  $cats  = $trip->packingItems->pluck('category')->unique()->values();
  $pct   = $total > 0 ? round(($done/$total)*100) : 0;
@endphp

<div class="section-head">
  <div>
    <div class="section-kicker">{{ $done }} / {{ $total }} ingepakt</div>
    <h2 class="section-title">Paklijst</h2>
  </div>
  <form method="POST" action="{{ route('packing.store', $trip) }}" class="inline-form">
    @csrf
    <input name="text" class="field" style="width:220px;padding:10px 14px;font-size:13px" placeholder="Voeg item toe..." required/>
    <select name="category" class="field" style="width:140px;padding:10px 14px;font-size:13px">
      @foreach($cats as $cat)<option>{{ $cat }}</option>@endforeach
      <option value="Overig">Overig</option>
    </select>
    <button type="submit" class="btn-primary"><x-icon name="plus" :s="14"/> Toevoegen</button>
  </form>
</div>

<div class="progress-bar"><div class="progress-fill" style="width:{{ $pct }}%"></div></div>

<div class="pack-grid">
  @foreach($cats as $cat)
  @php
    $catItems   = $trip->packingItems->where('category', $cat);
    $catDone    = $catItems->where('done', true)->count();
    $catTotal   = $catItems->count();
  @endphp
  <div class="pack-cat">
    <div class="pack-cat-head">
      <div class="pack-cat-title">{{ $cat }}</div>
      <div class="pack-cat-count">{{ $catDone }}/{{ $catTotal }}</div>
    </div>
    @foreach($catItems as $item)
    <form method="POST" action="{{ route('packing.toggle', $item) }}" style="display:contents">
      @csrf @method('PATCH')
      <button type="submit" class="pack-item" style="width:100%;background:none;border:none;padding:0;text-align:left">
        <div class="pack-checkbox {{ $item->done ? 'done' : '' }}">
          @if($item->done)<x-icon name="check" :s="12"/>@endif
        </div>
        <div class="pack-item-text {{ $item->done ? 'done' : '' }}">{{ $item->text }}</div>
        @if($item->user)
        <x-avatar :name="$item->user->name" :size="18"/>
        @endif
      </button>
    </form>
    @endforeach
  </div>
  @endforeach
</div>
