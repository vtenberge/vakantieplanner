<x-layout title="Uitnodiging verlopen — Vakantieplanner">
<div class="login-shell">
  <div class="login-left">
    <div style="font-size:11px;letter-spacing:2.5px;text-transform:uppercase;color:var(--vp-fg-mut)">
      Vakantieplanner
    </div>
    <div>
      <h1 class="login-tagline" style="font-size:52px">Uitnodiging<br/><em>verlopen.</em></h1>
      <p class="login-subtitle">Deze uitnodigingslink is al gebruikt of niet meer geldig. Vraag de organisator om een nieuwe link.</p>
      <div style="margin-top:24px">
        <a href="{{ route('login') }}" class="btn-primary btn-primary-lg">Naar inloggen <x-icon name="arrow" :s="14"/></a>
      </div>
    </div>
    <div class="login-footer-text"><span>Vakantieplanner</span></div>
  </div>
  <div class="login-right" style="background:linear-gradient(135deg,#b8d4e8 0%,#3a6080 60%,#1a2d40 100%)">
    <div style="position:absolute;inset:0;background:linear-gradient(160deg,rgba(0,0,0,.2) 0%,rgba(0,0,0,.6) 100%)"></div>
  </div>
</div>
</x-layout>
