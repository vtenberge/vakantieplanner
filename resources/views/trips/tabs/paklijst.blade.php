@php
  $done  = $trip->packingItems->where('done', true)->count();
  $total = $trip->packingItems->count();
  $cats  = $trip->packingItems->pluck('category')->unique()->values();
  $defaultCats = collect(['Kleding', 'Toilettas', 'Documenten', 'Elektronica', 'Overig']);
  $allCats = $cats->merge($defaultCats)->unique()->values();
  $pct   = $total > 0 ? round(($done/$total)*100) : 0;
@endphp

<div class="section-head">
  <div>
    <div class="section-kicker">{{ $done }} / {{ $total }} ingepakt</div>
    <h2 class="section-title">Paklijst</h2>
  </div>
  <form method="POST" action="{{ route('packing.store', $trip) }}" class="inline-form" id="pack-add-form">
    @csrf
    <input name="text" class="field" style="width:200px;padding:10px 14px;font-size:13px" placeholder="Voeg item toe..." required/>
    <select name="category" id="pack-cat-select" class="field" style="width:130px;padding:10px 14px;font-size:13px" onchange="toggleNewCat(this)">
      @foreach($allCats as $cat)<option>{{ $cat }}</option>@endforeach
      <option value="__new__">+ Nieuwe categorie</option>
    </select>
    <input name="category_new" id="pack-cat-new" class="field" style="display:none;width:130px;padding:10px 14px;font-size:13px" placeholder="Categorie naam"/>
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
    <div class="pack-item-wrap" style="display:flex;align-items:center">
      <form method="POST" action="{{ route('packing.toggle', $item) }}" style="flex:1;display:contents">
        @csrf @method('PATCH')
        <button type="submit" class="pack-item" style="flex:1;background:none;border:none;padding:0;text-align:left">
          <div class="pack-checkbox {{ $item->done ? 'done' : '' }}">
            @if($item->done)<x-icon name="check" :s="12"/>@endif
          </div>
          <div class="pack-item-text {{ $item->done ? 'done' : '' }}">{{ $item->text }}</div>
          @if($item->user)
          <x-avatar :name="$item->user->name" :size="18"/>
          @endif
        </button>
      </form>
      <form method="POST" action="{{ route('packing.destroy', $item) }}" style="flex-shrink:0">
        @csrf @method('DELETE')
        <button type="submit" class="btn-icon" style="opacity:.3;padding:2px" title="Verwijderen"><x-icon name="more" :s="11"/></button>
      </form>
    </div>
    @endforeach
  </div>
  @endforeach
</div>

<script>
function toggleNewCat(sel) {
  const newInput = document.getElementById('pack-cat-new');
  if (sel.value === '__new__') {
    newInput.style.display = 'block';
    newInput.required = true;
    newInput.focus();
  } else {
    newInput.style.display = 'none';
    newInput.required = false;
  }
}
document.getElementById('pack-add-form').addEventListener('submit', function(e) {
  const sel = document.getElementById('pack-cat-select');
  if (sel.value === '__new__') {
    const newVal = document.getElementById('pack-cat-new').value.trim();
    if (!newVal) { e.preventDefault(); return; }
    sel.value = newVal; // controller reads 'category' from select
  }
});
</script>
