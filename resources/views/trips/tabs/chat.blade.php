<div class="section-head">
  <div>
    <div class="section-kicker">{{ $trip->comments->count() }} berichten</div>
    <h2 class="section-title">Groepschat</h2>
  </div>
</div>

<div class="chat-thread">
  @forelse($trip->comments->sortBy('created_at') as $comment)
  @php $isOwn = $comment->user_id === auth()->id(); @endphp
  <div class="chat-msg {{ $isOwn ? 'chat-msg--own' : '' }}">
    @if(!$isOwn)
    <x-avatar :name="$comment->user->name" :size="32"/>
    @endif
    <div class="chat-bubble-wrap">
      @if(!$isOwn)
      <div class="chat-author">{{ $comment->user->name }}</div>
      @endif
      <div class="chat-bubble">{{ $comment->body }}</div>
      <div class="chat-time">{{ $comment->created_at->diffForHumans() }}</div>
    </div>
    @if($isOwn)
    <form method="POST" action="{{ route('comments.destroy', $comment) }}" style="align-self:center">
      @csrf @method('DELETE')
      <button type="submit" class="btn-icon" style="opacity:.3;padding:2px" title="Verwijderen"><x-icon name="more" :s="11"/></button>
    </form>
    @endif
  </div>
  @empty
  <div style="padding:40px;text-align:center;color:var(--vp-fg-mut);font-size:14px">
    Nog geen berichten — stuur het eerste!
  </div>
  @endforelse
</div>

<form method="POST" action="{{ route('comments.store', $trip) }}" class="chat-input-wrap">
  @csrf
  <input name="body" class="field chat-input" placeholder="Schrijf een bericht..." autocomplete="off" required/>
  <button type="submit" class="btn-primary">Versturen</button>
</form>

<style>
.chat-thread {
  display: flex;
  flex-direction: column;
  gap: 16px;
  margin-bottom: 24px;
  max-width: 680px;
}
.chat-msg {
  display: flex;
  align-items: flex-start;
  gap: 10px;
}
.chat-msg--own {
  flex-direction: row-reverse;
}
.chat-bubble-wrap {
  display: flex;
  flex-direction: column;
  gap: 3px;
  max-width: 480px;
}
.chat-author {
  font-size: 11px;
  font-weight: 600;
  color: var(--vp-fg-mut);
  padding-left: 2px;
  text-transform: uppercase;
  letter-spacing: .6px;
}
.chat-bubble {
  background: var(--vp-bg-sub);
  border: 1px solid var(--vp-line);
  border-radius: 12px;
  border-top-left-radius: 4px;
  padding: 10px 14px;
  font-size: 14px;
  line-height: 1.5;
  white-space: pre-wrap;
  word-break: break-word;
}
.chat-msg--own .chat-bubble {
  background: var(--vp-fg);
  color: var(--vp-bg);
  border-color: transparent;
  border-top-left-radius: 12px;
  border-top-right-radius: 4px;
}
.chat-time {
  font-size: 11px;
  color: var(--vp-fg-mut);
  padding-left: 2px;
}
.chat-msg--own .chat-time { text-align: right; padding-right: 2px; }
.chat-input-wrap {
  display: flex;
  gap: 10px;
  max-width: 680px;
  position: sticky;
  bottom: 0;
  background: var(--vp-bg);
  padding: 16px 0 4px;
}
.chat-input { flex: 1; padding: 12px 16px; font-size: 14px; }
</style>
