<div class="section-head">
  <div>
    <div class="section-kicker">Alle wijzigingen</div>
    <h2 class="section-title">Activiteit</h2>
  </div>
</div>

<div class="activity-feed" style="max-width:600px">
  @forelse($trip->activityLogs as $log)
  <div class="activity-row">
    <div class="activity-icon">{{ $log->icon }}</div>
    <div style="flex:1;min-width:0">
      <div class="activity-desc">{{ $log->description }}</div>
      <div class="activity-time">{{ $log->created_at->diffForHumans() }}</div>
    </div>
    <x-avatar :name="$log->user->name" :size="24"/>
  </div>
  @empty
  <div style="padding:40px;text-align:center;color:var(--vp-fg-mut);font-size:14px">
    Nog geen activiteit geregistreerd.
  </div>
  @endforelse
</div>

<style>
.activity-feed { display: flex; flex-direction: column; }
.activity-row {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 0;
  border-bottom: 1px solid var(--vp-line);
}
.activity-row:last-child { border-bottom: none; }
.activity-icon { font-size: 18px; width: 32px; text-align: center; flex-shrink: 0; }
.activity-desc { font-size: 14px; line-height: 1.4; }
.activity-time { font-size: 12px; color: var(--vp-fg-mut); margin-top: 2px; }
</style>
