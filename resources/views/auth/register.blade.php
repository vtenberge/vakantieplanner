<x-layout title="Registreren — Vakantieplanner">
<div class="login-shell">
  <div class="login-left">
    <div style="font-size:11px;letter-spacing:2.5px;text-transform:uppercase;color:var(--vp-fg-mut)">
      Vakantieplanner
    </div>

    <div>
      <h1 class="login-tagline" style="font-size:64px">Maak je<br/><em>account aan.</em></h1>
      <p class="login-subtitle">Plan je eerste reis samen met vrienden en familie.</p>

      @if($errors->any())
        <div class="error-msg" style="margin-bottom:16px">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('register') }}" style="display:flex;flex-direction:column;gap:10px;margin-bottom:24px">
        @csrf
        <div>
          <label class="field-label">Naam</label>
          <input name="name" class="field" value="{{ old('name') }}" placeholder="Sara de Wit" required/>
        </div>
        <div>
          <label class="field-label">E-mail</label>
          <input name="email" type="email" class="field" value="{{ old('email') }}" placeholder="sara@dewit.nl" required/>
        </div>
        <div>
          <label class="field-label">Wachtwoord</label>
          <input name="password" type="password" class="field" placeholder="Minimaal 8 tekens" required/>
        </div>
        <div>
          <label class="field-label">Wachtwoord bevestigen</label>
          <input name="password_confirmation" type="password" class="field" placeholder="Herhaal wachtwoord" required/>
        </div>
        <div class="login-actions" style="margin-top:8px">
          <button type="submit" class="btn-primary btn-primary-lg">
            Account aanmaken <x-icon name="arrow" :s="14"/>
          </button>
          <a href="{{ route('login') }}" class="btn-ghost" style="padding:14px 24px;font-size:14px">Inloggen</a>
        </div>
      </form>
    </div>

    <div class="login-footer-text">
      <span>Werkt op web, iOS &amp; Android</span>
    </div>
  </div>

  <div class="login-right" style="background:linear-gradient(135deg,#cfd6c7 0%,#7c8770 60%,#2f3a30 100%)">
    <div style="position:absolute;inset:0;background:linear-gradient(160deg,rgba(0,0,0,.2) 0%,rgba(0,0,0,.6) 100%)"></div>
  </div>
</div>
</x-layout>
