<div class="section-head">
  <div>
    <div class="section-kicker">{{ $trip->days->count() }} dagen</div>
    <h2 class="section-title">Dagschema</h2>
  </div>
  <button class="btn-primary" onclick="document.getElementById('new-day-modal').style.display='flex'">
    <x-icon name="plus" :s="14"/> Dag toevoegen
  </button>
</div>

@foreach($trip->days as $day)
<div class="day-row" id="dag-{{ $day->id }}">
  <div style="position:relative">
    <div class="day-number">{{ str_pad($day->day_number, 2, '0', STR_PAD_LEFT) }}</div>
    <div class="day-name">{{ $day->date_label }}</div>
    <div class="day-label">{{ $day->label }}</div>
    <div class="day-weather">{{ $day->weather }}</div>
    <form method="POST" action="{{ route('days.destroy', $day) }}" style="position:absolute;top:0;right:0" onsubmit="return confirm('Dag en alle activiteiten verwijderen?')">
      @csrf @method('DELETE')
      <button type="submit" class="btn-icon" title="Dag verwijderen" style="opacity:.4;padding:4px"><x-icon name="more" :s="12"/></button>
    </form>
  </div>
  <div>
    <div class="day-items-grid">
      @foreach($day->items as $item)
      <div class="day-item-card" style="position:relative">
        <div class="day-item-icon">
          @if($item->kind === 'flight') <x-icon name="plane"/>
          @elseif($item->kind === 'food') <x-icon name="fork"/>
          @elseif($item->kind === 'transit') <x-icon name="bus"/>
          @else <x-icon name="pin"/>
          @endif
        </div>
        <div style="flex:1;min-width:0">
          <div class="day-item-time">{{ $item->time }}</div>
          <div class="day-item-title">{{ $item->title }}</div>
        </div>
        @if($item->addedBy)
        <x-avatar :name="$item->addedBy->name" :size="20"/>
        @endif
        <form method="POST" action="{{ route('dayitems.destroy', $item) }}" style="margin-left:4px">
          @csrf @method('DELETE')
          <button type="submit" class="btn-icon" style="opacity:.3;padding:2px" title="Verwijderen"><x-icon name="more" :s="11"/></button>
        </form>
      </div>
      @endforeach

      {{-- Inline add-item card --}}
      <details class="day-item-add-card">
        <summary>
          <x-icon name="plus" :s="14"/> Activiteit toevoegen
        </summary>
        <form method="POST" action="{{ route('dayitems.store', [$trip, $day]) }}" class="day-item-add-form">
          @csrf
          <div style="display:grid;grid-template-columns:70px 1fr;gap:8px;margin-bottom:8px">
            <input name="time" class="field" placeholder="14:00" style="padding:8px 10px;font-size:13px"/>
            <input name="title" class="field" placeholder="Naam van activiteit" style="padding:8px 10px;font-size:13px" required/>
          </div>
          <div style="display:flex;gap:8px;align-items:center">
            <select name="kind" class="field" style="padding:8px 10px;font-size:13px;flex:1">
              <option value="place">📍 Plek</option>
              <option value="food">🍴 Eten & drinken</option>
              <option value="transit">🚌 Vervoer</option>
              <option value="flight">✈️ Vlucht</option>
            </select>
            <button type="submit" class="btn-primary" style="white-space:nowrap">Toevoegen</button>
          </div>
        </form>
      </details>
    </div>
  </div>
</div>
@endforeach

{{-- Modal: Dag toevoegen --}}
<div id="new-day-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:100;align-items:center;justify-content:center">
  <div style="background:var(--vp-bg);border-radius:var(--vp-radius-lg);padding:32px;width:420px;border:1px solid var(--vp-line)">
    <h2 style="font-family:var(--vp-display);font-size:26px;font-weight:400;margin:0 0 20px">Dag toevoegen</h2>
    <form method="POST" action="{{ route('days.store', $trip) }}" style="display:flex;flex-direction:column;gap:12px">
      @csrf
      <div>
        <label class="field-label">Datum / label</label>
        <input name="date_label" class="field" placeholder="zo 13 jul"/>
      </div>
      <div>
        <label class="field-label">Beschrijving (optioneel)</label>
        <input name="label" class="field" placeholder="Aankomstdag · Porto"/>
      </div>
      <div>
        <label class="field-label">Weer (optioneel)</label>
        <input name="weather" class="field" placeholder="☀️ 28°C"/>
      </div>
      <div style="display:flex;gap:10px;margin-top:8px">
        <button type="submit" class="btn-primary" style="flex:1;justify-content:center;padding:12px">Dag toevoegen</button>
        <button type="button" onclick="document.getElementById('new-day-modal').style.display='none'" class="btn-ghost" style="flex:1;justify-content:center;padding:12px">Annuleren</button>
      </div>
    </form>
  </div>
</div>

<style>
.day-item-add-card {
  border: 1px dashed var(--vp-line-strong);
  border-radius: var(--vp-radius);
  background: transparent;
  overflow: hidden;
}
.day-item-add-card summary {
  display: flex; align-items: center; gap: 8px;
  padding: 12px 14px; cursor: pointer;
  font-size: 13px; color: var(--vp-fg-mut); font-family: var(--vp-body);
  list-style: none; user-select: none;
}
.day-item-add-card summary::-webkit-details-marker { display: none; }
.day-item-add-card[open] summary { border-bottom: 1px solid var(--vp-line); color: var(--vp-fg); }
.day-item-add-card[open] { border-style: solid; border-color: var(--vp-line); background: var(--vp-bg-sub); }
.day-item-add-form { padding: 14px; }
</style>
