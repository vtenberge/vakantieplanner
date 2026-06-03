@php
  $pendingInvites = $trip->invitations->filter(fn($i) => $i->isPending());
@endphp

<div class="section-head">
  <div>
    <div class="section-kicker">{{ $trip->tripMembers->count() }} reisgenoten · {{ $pendingInvites->count() }} openstaand</div>
    <h2 class="section-title">Leden &amp; rollen</h2>
  </div>
</div>

<div class="members-layout">
  <div>
    {{-- Accepted members --}}
    <div class="table-wrap" style="margin-bottom:20px">
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
          <button type="submit" class="btn-icon" title="Verwijderen"><x-icon name="more" :s="14"/></button>
        </form>
        @else
        <button class="btn-icon" disabled><x-icon name="more" :s="14"/></button>
        @endif
      </div>
      @endforeach
    </div>

    {{-- Pending invitations --}}
    @if($pendingInvites->count())
    <div class="kicker-label" style="margin-bottom:10px">Openstaande uitnodigingen</div>
    <div class="table-wrap">
      @foreach($pendingInvites as $invite)
      @php $inviteUrl = url('/uitnodiging/' . $invite->token); @endphp
      <div class="member-row" style="flex-wrap:wrap;gap:10px">
        <div style="width:36px;height:36px;border-radius:50%;background:var(--vp-bg-sub);border:2px dashed var(--vp-line-strong);display:flex;align-items:center;justify-content:center;flex-shrink:0">
          <x-icon name="user" :s="14" style="opacity:.4"/>
        </div>
        <div style="flex:1;min-width:0">
          <div style="font-size:14px;font-weight:500">{{ $invite->email }}</div>
          <div style="font-size:12px;color:var(--vp-fg-mut)">
            Uitgenodigd door {{ $invite->invitedBy->name }} · {{ ucfirst($invite->role) }}
            @if($invite->expires_at) · Verloopt {{ $invite->expires_at->format('d M') }}@endif
          </div>
        </div>
        <div style="display:flex;align-items:center;gap:6px">
          <button
            class="btn-ghost"
            style="padding:6px 10px;font-size:12px"
            onclick="copyInviteLink('{{ $inviteUrl }}', this)"
          >Kopieer link</button>
          <form method="POST" action="{{ route('invitations.destroy', $invite) }}" onsubmit="return confirm('Uitnodiging intrekken?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-icon" title="Intrekken" style="opacity:.4"><x-icon name="more" :s="13"/></button>
          </form>
        </div>
        <div style="width:100%;background:var(--vp-bg-sub);border:1px solid var(--vp-line);border-radius:var(--vp-radius);padding:10px 12px;display:flex;align-items:center;justify-content:space-between;gap:8px">
          <div class="monospace" style="font-size:11px;color:var(--vp-fg-sub);overflow:hidden;text-overflow:ellipsis;white-space:nowrap" id="invite-link-{{ $invite->id }}">{{ $inviteUrl }}</div>
          <button class="btn-ghost" style="padding:5px 10px;font-size:11px;flex-shrink:0" onclick="copyInviteLink('{{ $inviteUrl }}', this)">Kopieer</button>
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>

  <div style="border:1px solid var(--vp-line);border-radius:var(--vp-radius-lg);padding:18px;background:var(--vp-bg-sub)">
    <div class="kicker-label" style="margin-bottom:10px">Iemand uitnodigen</div>

    @if(session('success') && str_contains(session('success'), 'Uitnodiging'))
    <div style="padding:10px 12px;background:var(--vp-accent);color:#fff;border-radius:var(--vp-radius);font-size:13px;margin-bottom:12px">
      {{ session('success') }}
    </div>
    @endif

    @error('email')
    <div class="error-msg" style="margin-bottom:10px">{{ $message }}</div>
    @enderror

    <form method="POST" action="{{ route('members.store', $trip) }}" style="display:flex;flex-direction:column;gap:8px">
      @csrf
      <div>
        <label class="field-label">E-mailadres</label>
        <input name="email" type="email" class="field" placeholder="naam@email.nl" required/>
      </div>
      <div>
        <label class="field-label">Rol</label>
        <select name="role" class="field">
          <option value="bewerker">Bewerker — kan alles bewerken</option>
          <option value="kijker">Kijker — alleen lezen</option>
        </select>
      </div>
      <button type="submit" class="btn-primary" style="justify-content:center;padding:12px;margin-top:4px">
        <x-icon name="user" :s="14"/> Uitnodiging genereren
      </button>
    </form>

    <p style="font-size:12px;color:var(--vp-fg-mut);margin:12px 0 0;line-height:1.6">
      Als het e-mailadres al een account heeft, worden ze direct toegevoegd. Anders krijg jij een uitnodigingslink die je kunt doorsturen.
    </p>
  </div>
</div>

<script>
function copyInviteLink(url, btn) {
  navigator.clipboard?.writeText(url).then(() => {
    const orig = btn.textContent;
    btn.textContent = 'Gekopieerd ✓';
    setTimeout(() => { btn.textContent = orig; }, 2000);
  });
}
</script>
