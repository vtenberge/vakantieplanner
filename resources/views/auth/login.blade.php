<x-layout title="Inloggen — Vakantieplanner">
<div class="login-shell">
  <div class="login-left">
    <div style="font-size:11px;letter-spacing:2.5px;text-transform:uppercase;color:var(--vp-fg-mut);display:flex;justify-content:space-between">
      <span>Vakantieplanner</span><span>Editie 2026</span>
    </div>

    <div>
      <h1 class="login-tagline">Plan samen,<br/><em>reis lichter.</em></h1>
      <p class="login-subtitle">Eén plek voor paklijsten, boekingen, plekken en het budget. Voor jou en je reisgenoten — synchroon op web.</p>

      @if($errors->any())
        <div class="error-msg" style="margin-bottom:16px">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:10px;margin-bottom:24px">
        @csrf
        <div>
          <label class="field-label">E-mail</label>
          <input name="email" type="email" class="field" value="{{ old('email') }}" placeholder="sara@dewit.nl" required/>
        </div>
        <div>
          <label class="field-label">Wachtwoord</label>
          <input name="password" type="password" class="field" placeholder="••••••••" required/>
        </div>
        <div class="login-actions" style="margin-top:8px">
          <button type="submit" class="btn-primary btn-primary-lg">
            Inloggen <x-icon name="arrow" :s="14"/>
          </button>
          <a href="{{ route('register') }}" class="btn-ghost" style="padding:14px 24px;font-size:14px">Account aanmaken</a>
        </div>
      </form>

      <div style="font-size:12px;color:var(--vp-fg-mut)">
        Demo: <strong>sara@dewit.nl</strong> / <strong>password</strong>
      </div>
    </div>

    <div class="login-footer-text">
      <span>Werkt op web, iOS &amp; Android</span>
      <span>End-to-end versleuteld</span>
    </div>
  </div>

  <div class="login-right" style="background:linear-gradient(135deg,#a87f5e 0%,#5b3b25 60%,#241612 100%)">
    <div style="position:absolute;inset:0;background:linear-gradient(160deg,rgba(0,0,0,.2) 0%,rgba(0,0,0,.6) 100%)"></div>
    <div class="login-ticket">
      <div class="login-ticket-eyebrow"><span>Boarding pass</span><span>KL 1693</span></div>
      <div class="login-ticket-route">AMS → LIS</div>
      <div class="login-ticket-meta">12 jul 2026 · 11:55 · Gate D7</div>
      <div class="login-ticket-footer">
        <div><div class="login-ticket-field-label">Reiziger</div><div class="login-ticket-field-val">S. de Wit</div></div>
        <div><div class="login-ticket-field-label">Stoel</div><div class="login-ticket-field-val">14A</div></div>
        <div><div class="login-ticket-field-label">Groep</div><div class="login-ticket-field-val">4</div></div>
      </div>
    </div>
  </div>
</div>
</x-layout>
