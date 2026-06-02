<div class="section-head">
  <div>
    <div class="section-kicker">Totaal € {{ $totalBookings }}</div>
    <h2 class="section-title">Boekingen</h2>
  </div>
  <button onclick="document.getElementById('booking-modal').style.display='flex'" class="btn-primary">
    <x-icon name="plus" :s="14"/> Boeking toevoegen
  </button>
</div>

<div class="table-wrap">
  <div class="table-head bookings-cols">
    <div>Type</div><div>Boeking</div><div>Datum</div><div>Boekingscode</div>
    <div style="text-align:right">Bedrag</div><div></div>
  </div>
  @forelse($trip->bookings as $booking)
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
  @empty
  <div style="padding:32px;text-align:center;color:var(--vp-fg-mut);font-size:14px">
    Nog geen boekingen — voeg je eerste toe.
  </div>
  @endforelse
</div>

{{-- Booking modal --}}
<div id="booking-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:100;align-items:center;justify-content:center">
  <div style="background:var(--vp-bg);border-radius:var(--vp-radius-lg);padding:32px;width:500px;border:1px solid var(--vp-line)">
    <h2 style="font-family:var(--vp-display);font-size:26px;font-weight:400;margin:0 0 22px">Boeking toevoegen</h2>
    <form method="POST" action="{{ route('bookings.store', $trip) }}" style="display:flex;flex-direction:column;gap:12px">
      @csrf
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
        <div>
          <label class="field-label">Type *</label>
          <select name="type" class="field" required>
            <option value="">Kies type…</option>
            <option>Vlucht heen</option>
            <option>Vlucht terug</option>
            <option>Appartement</option>
            <option>Hotel</option>
            <option>Auto huur</option>
            <option>Trein</option>
            <option>Activiteit</option>
            <option>Overig</option>
          </select>
        </div>
        <div>
          <label class="field-label">Bedrag (€) *</label>
          <input name="cost" type="number" class="field" placeholder="184" min="0" required/>
        </div>
      </div>
      <div>
        <label class="field-label">Naam / omschrijving *</label>
        <input name="title" class="field" placeholder="KL1693 · AMS → LIS" required/>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
        <div>
          <label class="field-label">Datum</label>
          <input name="date_label" class="field" placeholder="12 jul · 11:55"/>
        </div>
        <div>
          <label class="field-label">Boekingscode</label>
          <input name="booking_code" class="field" placeholder="X8K2P9"/>
        </div>
      </div>
      <div style="display:flex;gap:10px;margin-top:8px">
        <button type="submit" class="btn-primary" style="flex:1;justify-content:center;padding:13px">Opslaan</button>
        <button type="button" onclick="document.getElementById('booking-modal').style.display='none'" class="btn-ghost" style="flex:1;justify-content:center;padding:13px">Annuleren</button>
      </div>
    </form>
  </div>
</div>
