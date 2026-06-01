@props(['active' => '', 'trips' => []])
@php $user = auth()->user(); @endphp
<aside class="sidebar">
  <a href="{{ route('trips.index') }}" class="sidebar-logo">
    <div class="sidebar-logo-mark"><em>v</em></div>
    <div class="sidebar-logo-text">vakantie<span>.app</span></div>
  </a>

  <div class="kicker-label" style="padding:4px 8px 8px">Navigatie</div>
  <a href="{{ route('trips.index') }}" class="sb-item {{ $active === 'trips' ? 'active' : '' }}">
    <x-icon name="list" :s="14"/>
    <span class="sb-item-text">Mijn reizen</span>
  </a>
  <a href="#" class="sb-item">
    <x-icon name="search" :s="14"/>
    <span class="sb-item-text">Verkennen</span>
  </a>
  <a href="#" class="sb-item">
    <x-icon name="bell" :s="14"/>
    <span class="sb-item-text">Updates</span>
    <span class="sb-badge">3</span>
  </a>

  @if(count($trips))
  <div class="kicker-label" style="padding:22px 8px 8px">Reizen</div>
  @foreach($trips as $trip)
  <a href="{{ route('trips.show', $trip) }}" class="sb-item {{ isset($currentTrip) && $currentTrip->id === $trip->id ? 'active' : '' }}">
    <div class="sb-swatch" style="background:{{ $trip->cover }}"></div>
    <div style="flex:1;min-width:0">
      <div class="sb-item-text">{{ $trip->title }}</div>
      <div class="sb-item-sub">{{ Str::before($trip->dates, ' —') }}</div>
    </div>
  </a>
  @endforeach
  @endif

  <div class="sidebar-spacer"></div>

  <div class="sidebar-footer">
    <x-avatar :name="$user->name" :size="30"/>
    <div style="flex:1;min-width:0">
      <div class="sidebar-footer-name">{{ $user->name }}</div>
      <div class="sidebar-footer-email">{{ $user->email }}</div>
    </div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="btn-icon" title="Uitloggen">
        <x-icon name="logout" :s="14"/>
      </button>
    </form>
  </div>
</aside>
