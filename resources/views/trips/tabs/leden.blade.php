<div class="section-head">
  <div>
    <div class="section-kicker">{{ $trip->tripMembers->count() }} reisgenoten</div>
    <h2 class="section-title">Leden &amp; rollen</h2>
  </div>
</div>

<div class="members-layout">
  <div class="table-wrap">
    @foreach($trip->tripMembers as $member)
    <div class="member-row">
      <x-avatar :name="$member->user->name" :size="42"/>
      <div style="flex:1">
        <div style="font-size:15px;font-weight:600">{{ $member->user->name }}</div>
        <div style="font-size:12px;color:var(--vp-fg-mut)">{{ $member->user->email }}</div>
      </div>
      <form method="POST" action="{{ route('members.update', [$trip, $member]) }}">
        @csrf @method('PATCH')
        <select name="role" onchange="this.form.submit()" class="field" style="padding:8px 12px;font-size:13px;width:auto;cursor:pointer">
          @foreach(['eigenaar','bewerker','kijker'] as $role)
          <option value="{{ $role }}" {{ $member->role === $role ? 'selected' : '' }}>
            {{ ucfirst($role) }}
          </option>
          @endforeach
        </select>
      </form>
      @if($member->role !== 'eigenaar')
      <form method="POST" action="{{ route('members.destroy', [$trip, $member]) }}">
        @csrf @method('DELETE')
        <button type="submit" class="btn-icon"><x-icon name="more" :s="14"/></button>
      </form>
      @else
      <button class="btn-icon" disabled><x-icon name="more" :s="14"/></button>
      @endif
    </div>
    @endforeach
  </div>

  <div style="border:1px solid var(--vp-line);border-radius:var(--vp-radius-lg);padding:18px;background:var(--vp-bg-sub)">
    <div class="kicker-label" style="margin-bottom:10px">Uitnodigen</div>
    <form method="POST" action="{{ route('members.store', $trip) }}" style="display:flex;flex-direction:column;gap:8px">
      @csrf
      <input name="email" type="email" class="field" placeholder="naam@email.nl" required/>
      <select name="role" class="field">
        <option value="bewerker">Bewerker</option>
        <option value="kijker">Kijker</option>
      </select>
      <button type="submit" class="btn-primary" style="justify-content:center;padding:12px;margin-top:4px">
        Uitnodiging versturen
      </button>
    </form>

    <div style="margin-top:14px;padding:12px 14px;background:var(--vp-bg);border:1px dashed var(--vp-line-strong);border-radius:var(--vp-radius)">
      <div class="kicker-label" style="margin-bottom:4px">Of deel de link</div>
      <div style="display:flex;justify-content:space-between;align-items:center">
        <div class="monospace" style="font-size:12px;color:var(--vp-fg-sub)">vakantie.app/{{ $trip->id }}?k=A2F8</div>
        <button class="btn-ghost" style="padding:6px 10px;font-size:12px" onclick="navigator.clipboard?.writeText(this.previousElementSibling.textContent)">Kopieer</button>
      </div>
    </div>
  </div>
</div>
