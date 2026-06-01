<div class="section-head">
  <div>
    <div class="section-kicker">Gedeelde uitgaven</div>
    <h2 class="section-title">Budget</h2>
  </div>
  <button onclick="document.getElementById('budget-modal').style.display='flex'" class="btn-primary">
    <x-icon name="plus" :s="14"/> Uitgave
  </button>
</div>

<div class="big-stats">
  <div class="big-stat">
    <div class="big-stat-label">Begroting</div>
    <div class="big-stat-value">€ {{ $trip->budget }}</div>
    <div class="big-stat-sub">voor {{ $memberCount }} personen</div>
  </div>
  <div class="big-stat" style="background:var(--vp-bg-sub)">
    <div class="big-stat-label">Uitgegeven</div>
    <div class="big-stat-value" style="color:var(--vp-accent)">€ {{ $totalBudget }}</div>
    <div class="big-stat-sub">{{ $trip->budget > 0 ? round(($totalBudget/$trip->budget)*100) : 0 }}% van budget</div>
  </div>
  <div class="big-stat">
    <div class="big-stat-label">Per persoon</div>
    <div class="big-stat-value">€ {{ $perPerson }}</div>
    <div class="big-stat-sub">gedeeld door {{ $memberCount }}</div>
  </div>
</div>

<div class="budget-layout">
  <div>
    <div class="kicker-label" style="margin-bottom:10px">Uitgaven</div>
    @foreach($trip->budgetItems as $item)
    <div class="budget-item-row">
      @if($item->user)
      <x-avatar :name="$item->user->name" :size="32"/>
      @endif
      <div style="flex:1;min-width:0">
        <div style="font-size:14px;font-weight:500">{{ $item->title }}</div>
        <div style="font-size:12px;color:var(--vp-fg-mut)">
          betaald door {{ $item->user?->name ? explode(' ', $item->user->name)[0] : '—' }} · gedeeld door {{ $memberCount }}
        </div>
      </div>
      <div style="font-size:14px;font-weight:600">€ {{ $item->amount }}</div>
    </div>
    @endforeach
  </div>

  <div>
    <div class="kicker-label" style="margin-bottom:10px">Wie staat waar?</div>
    <div class="settle-card">
      @foreach($trip->tripMembers as $i => $member)
      @php
        $paid = $trip->budgetItems->where('user_id', $member->user_id)->sum('amount');
        $owed = $perPerson - $paid;
      @endphp
      <div class="settle-row">
        <x-avatar :name="$member->user->name" :size="26"/>
        <div style="flex:1;font-size:13px;font-weight:500">{{ explode(' ', $member->user->name)[0] }}</div>
        <div style="font-size:13px;font-weight:600;color:{{ $owed > 0 ? 'var(--vp-fg-mut)' : 'var(--vp-accent)' }}">
          @if($owed > 0) krijgt € {{ $owed }}
          @elseif($owed < 0) betaalt € {{ abs($owed) }}
          @else ✓ gelijk
          @endif
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

{{-- Budget modal --}}
<div id="budget-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:100;align-items:center;justify-content:center">
  <div style="background:var(--vp-bg);border-radius:var(--vp-radius-lg);padding:32px;width:420px;border:1px solid var(--vp-line)">
    <h2 style="font-family:var(--vp-display);font-size:26px;font-weight:400;margin:0 0 20px">Uitgave toevoegen</h2>
    <form method="POST" action="{{ route('budget.store', $trip) }}" style="display:flex;flex-direction:column;gap:12px">
      @csrf
      <div>
        <label class="field-label">Omschrijving</label>
        <input name="title" class="field" placeholder="Diner" required/>
      </div>
      <div>
        <label class="field-label">Bedrag (€)</label>
        <input name="amount" type="number" class="field" placeholder="45" min="0" required/>
      </div>
      <div style="display:flex;gap:10px;margin-top:8px">
        <button type="submit" class="btn-primary" style="flex:1;justify-content:center;padding:12px">Opslaan</button>
        <button type="button" onclick="document.getElementById('budget-modal').style.display='none'" class="btn-ghost" style="flex:1;justify-content:center;padding:12px">Annuleren</button>
      </div>
    </form>
  </div>
</div>
