<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<!-- Fonts (proxied) -->
<link rel="preconnect" href="{{ url('/') }}">
<link href="/fonts/instrument-sans.css" rel="stylesheet" />

<!-- Local CSS & JS -->
<link rel="stylesheet" href="/build/assets/app-DoDyzDhk.css" crossorigin />
<script src="/build/assets/app.js" type="module" crossorigin></script>

{{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
<x-script.app />
@fluxAppearance
@livewireStyles()
