<svg xmlns="http://www.w3.org/2000/svg"
  class="icon icon-tabler icon-tabler-{{ $icon }} {{ $class ?? '' }}"
  width="{{ $width ?? 24 }}"
  height="{{ $height ?? 24 }}"
  viewBox="0 0 24 24"
  stroke-width="{{ $stroke_width ?? 2 }}"
  stroke="{{ $stroke ?? 'currentColor' }}"
  fill="{{ $fill ?? 'none' }}"
  stroke-linecap="round"
  stroke-linejoin="round"
  {{ $attributes }}
  >

  <use xlink:href="/tabler/libs/icons/_.svg#{{$icon}}"></use>
</svg>