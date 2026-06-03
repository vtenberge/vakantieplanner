<x-layout title="Uitnodiging — Vakantieplanner">
<div class="login-shell">
  <div class="login-left">
    <div style="font-size:11px;letter-spacing:2.5px;text-transform:uppercase;color:var(--vp-fg-mut)">
      Vakantieplanner
    </div>

    <div>
      <div style="font-size:12px;letter-spacing:1.5px;text-transform:uppercase;color:var(--vp-accent);margin-bottom:10px">Uitnodiging</div>
      <h1 class="login-tagline" style="font-size:56px;margin-bottom:12px">
        Je bent uitgenodigd voor<br/><em>{{ $invite->trip->title }}</em>
      </h1>
      <p class="login-subtitle" style="margin-bottom:28px">
        {{ $invite->invitedBy->name }} nodigt je uit als <strong>{{ $invite->role }}</strong>
        @if($invite->trip->dates) · {{ $invite->trip->dates }}@endif
        @if($invite->expires_at) · Link geldig tot {{ $invite->expires_at->format('d M') }}@endif
      </p>

      @if(Auth::check())
        {{-- Already logged in — just one click --}}
        <form method="POST" action="{{ route('invitations.accept', $token) }}">
          @csrf
          <button type="submit" class="btn-primary btn-primary-lg">
            Reis accepteren <x-icon name="arrow" :s="14"/>
          </button>
        </form>
        <p style="font-size:13px;color:var(--vp-fg-mut);margin-top:16px">
          Ingelogd als <strong>{{ Auth::user()->name }}</strong>.
          <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit()" style="color:var(--vp-fg-sub)">Uitloggen</a>
        </p>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none">@csrf</form>
      @else
        {{-- Not logged in — show register + login --}}
        <div style="display:flex;gap:12px;margin-bottom:24px">
          <a href="{{ route('register', ['invite' => $token]) }}" class="btn-primary btn-primary-lg">
            Account aanmaken <x-icon name="arrow" :s="14"/>
          </a>
          <a href="{{ route('login') }}" class="btn-ghost" style="padding:14px 24px;font-size:14px" onclick="sessionStorage.setItem('invite','{{ $token }}')">
            Al een account? Inloggen
          </a>
        </div>
        <p style="font-size:13px;color:var(--vp-fg-mut)">
          Na het aanmaken of inloggen word je direct toegevoegd aan de reis.
        </p>
      @endif
    </div>

    <div class="login-footer-text">
      <span>Vakantieplanner · Samen reizen</span>
    </div>
  </div>

  <div class="login-right" style="background:{{ $invite->trip->cover }}">
    <div style="position:absolute;inset:0;background:linear-gradient(160deg,rgba(0,0,0,.3) 0%,rgba(0,0,0,.7) 100%)"></div>
    <div style="position:relative;z-index:1;padding:40px;display:flex;flex-direction:column;justify-content:flex-end;height:100%">
      <div style="font-size:11px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:8px">
        {{ $invite->trip->country }}
      </div>
      <div style="font-family:var(--vp-display);font-size:48px;color:#fff;line-height:1;margin-bottom:12px">
        {{ $invite->trip->title }}
      </div>
      @if($invite->trip->dates)
      <div style="font-size:14px;color:rgba(255,255,255,.7)">{{ $invite->trip->dates }}</div>
      @endif
    </div>
  </div>
</div>
</x-layout>
