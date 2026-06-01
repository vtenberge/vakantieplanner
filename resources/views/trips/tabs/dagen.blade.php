<div class="section-head">
  <div>
    <div class="section-kicker">{{ $trip->days->count() }} dagen</div>
    <h2 class="section-title">Dagschema</h2>
  </div>
  <button class="btn-ghost"><x-icon name="plus" :s="14"/> Dag toevoegen</button>
</div>

@foreach($trip->days as $day)
<div class="day-row">
  <div>
    <div class="day-number">{{ str_pad($day->day_number, 2, '0', STR_PAD_LEFT) }}</div>
    <div class="day-name">{{ $day->date_label }}</div>
    <div class="day-label">{{ $day->label }}</div>
    <div class="day-weather">{{ $day->weather }}</div>
  </div>
  <div class="day-items-grid">
    @foreach($day->items as $item)
    <div class="day-item-card">
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
    </div>
    @endforeach
  </div>
</div>
@endforeach
