<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://www.gstatic.com https://www.gstatic.com/firebasejs https://irosincentralschool.com; style-src 'self' 'unsafe-inline' https://fonts.bunny.net; style-src-elem 'self' 'unsafe-inline' https://fonts.bunny.net; script-src-elem 'self' 'unsafe-inline' https://cdn.jsdelivr.net; img-src 'self' data: https: blob:; font-src 'self' https://fonts.bunny.net; connect-src 'self' https://cdn.jsdelivr.net https://irosincentralschool.com; media-src 'self' blob:;">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
<link rel="stylesheet" href="/build/assets/app-DoDyzDhk.css">
<script src="/build/assets/app.js" type="module"></script>
{{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
<x-script.app />
@fluxAppearance
@livewireStyles()
<!-- index.html -->
