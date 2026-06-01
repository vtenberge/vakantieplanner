@php
$mapHeight = $height ?? 160;
$mapLabel  = $label ?? 'Kaart';
$pins = 5;
$pts = [];
for ($i = 0; $i < $pins; $i++) {
  $pts[] = ['x' => ($i*73+19) % 82 + 9, 'y' => ($i*131+11) % 62 + 18];
}
@endphp
<div class="mini-map" style="height:{{ $mapHeight }}px;background:#ece8df">
  <div style="position:absolute;left:0;right:0;bottom:0;height:38%;background:#d9e3e8;clip-path:polygon(0 30%,18% 18%,32% 22%,50% 12%,68% 18%,84% 10%,100% 22%,100% 100%,0 100%)"></div>
  <svg width="100%" height="100%" style="position:absolute;inset:0">
    @foreach([15,32,55,72] as $y)
    <line x1="0" y1="{{ $y }}%" x2="100%" y2="{{ $y }}%" stroke="rgba(0,0,0,.06)" stroke-width="1"/>
    @endforeach
    @foreach([14,28,46,62,80] as $x)
    <line x1="{{ $x }}%" y1="0" x2="{{ $x }}%" y2="100%" stroke="rgba(0,0,0,.06)" stroke-width="1"/>
    @endforeach
  </svg>
  @foreach($pts as $pt)
  <div style="position:absolute;left:{{ $pt['x'] }}%;top:{{ $pt['y'] }}%;transform:translate(-50%,-100%)">
    <svg width="22" height="28" viewBox="0 0 22 28">
      <path d="M11 1c5.5 0 10 4.3 10 9.8 0 7-10 16.2-10 16.2S1 17.8 1 10.8C1 5.3 5.5 1 11 1Z" fill="var(--vp-accent)" stroke="var(--vp-bg)" stroke-width="1.5"/>
      <circle cx="11" cy="10.5" r="3.2" fill="var(--vp-bg)"/>
    </svg>
  </div>
  @endforeach
  <div style="position:absolute;left:10px;top:10px;padding:4px 8px;background:var(--vp-bg);border:1px solid var(--vp-line);border-radius:6px;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--vp-fg-mut)">
    {{ $mapLabel }}
  </div>
</div>
