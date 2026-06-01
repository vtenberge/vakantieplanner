<div class="section-head">
  <div>
    <div class="section-kicker">Totaal € {{ $totalBookings }}</div>
    <h2 class="section-title">Boekingen</h2>
  </div>
  <button class="btn-primary"><x-icon name="plus" :s="14"/> Boeking toevoegen</button>
</div>

<div class="table-wrap">
  <div class="table-head bookings-cols">
    <div>Type</div><div>Boeking</div><div>Datum</div><div>Boekingscode</div>
    <div style="text-align:right">Bedrag</div><div></div>
  </div>
  @foreach($trip->bookings as $booking)
  <div class="table-row bookings-cols">
    <div style="font-size:11px;color:var(--vp-fg-mut);text-transform:uppercase;letter-spacing:1.2px">{{ $booking->type }}</div>
    <div style="font-weight:600">{{ $booking->title }}</div>
    <div style="color:var(--vp-fg-sub)">{{ $booking->date_label }}</div>
    <div class="monospace" style="font-size:12px;color:var(--vp-fg-sub)">{{ $booking->booking_code }}</div>
    <div style="text-align:right;font-weight:600">€ {{ $booking->cost }}</div>
    <div style="display:flex;justify-content:flex-end">
      @if($booking->addedBy)
      <x-avatar :name="$booking->addedBy->name" :size="22"/>
      @endif
    </div>
  </div>
  @endforeach
</div>
