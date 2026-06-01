@props(['name', 'size' => 28])
@php
  $words = explode(' ', $name);
  $initials = strtoupper(substr($words[0] ?? '', 0, 1) . substr($words[1] ?? '', 0, 1));
  $hue = array_sum(array_map('ord', str_split($name))) % 360;
  $bg = "oklch(0.78 0.06 {$hue})";
  $fg = "oklch(0.28 0.06 {$hue})";
  $fs = round($size * 0.38);
@endphp
<div class="avatar" style="width:{{ $size }}px;height:{{ $size }}px;background:{{ $bg }};color:{{ $fg }};font-size:{{ $fs }}px;">
  {{ $initials }}
</div>
