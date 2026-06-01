@props(['name', 's' => 18])
@php
$icons = [
  'plane'  => '<path d="M10.5 3.5 11 11 3 14v2l8-1.5L11 21l2 .5.5-6L21 14v-2l-7.5-3 .5-7.5Z"/>',
  'pin'    => '<path d="M12 21s7-7.5 7-13a7 7 0 1 0-14 0c0 5.5 7 13 7 13Z"/><circle cx="12" cy="8" r="2.5"/>',
  'fork'   => '<path d="M5 3v6a2 2 0 0 0 2 2h0a2 2 0 0 0 2-2V3M7 11v10M16 3v6c0 1 .5 2 1.5 2.5L19 12v9"/>',
  'bus'    => '<rect x="5" y="4" width="14" height="14" rx="2"/><path d="M5 11h14M8 18v2M16 18v2"/><circle cx="9" cy="15" r=".7" fill="currentColor"/><circle cx="15" cy="15" r=".7" fill="currentColor"/>',
  'check'  => '<path d="m4 12 5 5L20 6"/>',
  'plus'   => '<path d="M12 5v14M5 12h14"/>',
  'back'   => '<path d="M15 5 8 12l7 7"/>',
  'more'   => '<circle cx="5" cy="12" r="1.2" fill="currentColor"/><circle cx="12" cy="12" r="1.2" fill="currentColor"/><circle cx="19" cy="12" r="1.2" fill="currentColor"/>',
  'search' => '<circle cx="11" cy="11" r="6.5"/><path d="m20 20-4.5-4.5"/>',
  'cal'    => '<rect x="3.5" y="5" width="17" height="15" rx="2"/><path d="M3.5 9.5h17M8 3v4M16 3v4"/>',
  'map'    => '<path d="m3 6 6-2 6 2 6-2v14l-6 2-6-2-6 2V6Z"/><path d="M9 4v16M15 6v16"/>',
  'list'   => '<path d="M8 6h13M8 12h13M8 18h13"/><circle cx="4" cy="6" r="1.2" fill="currentColor"/><circle cx="4" cy="12" r="1.2" fill="currentColor"/><circle cx="4" cy="18" r="1.2" fill="currentColor"/>',
  'euro'   => '<path d="M18 6.5A7 7 0 1 0 18 18M4 10h10M4 14h10"/>',
  'user'   => '<circle cx="12" cy="8" r="4"/><path d="M4 21c1-4 4.5-6 8-6s7 2 8 6"/>',
  'share'  => '<circle cx="6" cy="12" r="2.5"/><circle cx="18" cy="6" r="2.5"/><circle cx="18" cy="18" r="2.5"/><path d="m8 11 8-4M8 13l8 4"/>',
  'bell'   => '<path d="M6 16V11a6 6 0 1 1 12 0v5l1.5 2.5h-15L6 16Z"/><path d="M10 20a2 2 0 0 0 4 0"/>',
  'arrow'  => '<path d="M5 12h14M13 5l7 7-7 7"/>',
  'star'   => '<path d="m12 3 2.7 5.7 6.3.8-4.6 4.3 1.2 6.2L12 17l-5.6 3 1.2-6.2L3 9.5l6.3-.8L12 3Z" fill="currentColor"/>',
  'logout' => '<path d="M15 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10"/><path d="m16 17 5-5-5-5M21 12H8"/>',
];
$path = $icons[$name] ?? '';
@endphp
<svg viewBox="0 0 24 24" width="{{ $s }}" height="{{ $s }}" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0">{!! $path !!}</svg>
