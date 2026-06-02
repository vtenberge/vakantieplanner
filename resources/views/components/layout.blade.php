<!doctype html>
<html lang="nl">
<head>
<meta charset="utf-8"/>
<title>{{ $title ?? 'Vakantieplanner' }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="/css/app.css"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
</head>
<body>
{{ $slot }}

@if(session('success'))
<div id="flash-toast" style="
  position:fixed;bottom:28px;right:28px;z-index:999;
  background:var(--vp-fg);color:var(--vp-bg);
  padding:14px 20px;border-radius:var(--vp-radius);
  font-size:13px;font-weight:500;font-family:var(--vp-body);
  box-shadow:0 8px 30px rgba(0,0,0,.18);
  display:flex;align-items:center;gap:10px;
  animation:slideUp .2s ease;
">
  <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m4 12 5 5L20 6"/></svg>
  {{ session('success') }}
</div>
<style>
@keyframes slideUp { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
</style>
<script>setTimeout(()=>{ const t=document.getElementById('flash-toast'); if(t){t.style.transition='opacity .3s';t.style.opacity='0';setTimeout(()=>t.remove(),300);} }, 3500);</script>
@endif

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV/XN/WLcE=" crossorigin=""></script>
</body>
</html>
