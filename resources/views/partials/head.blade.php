<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" type="image/png" href="/favicon.png">
<link rel="shortcut icon" href="/favicon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
<x-script.app />
@fluxAppearance
@livewireStyles()
<!-- index.html -->
@php
    $assetPath = asset('build/assets');
    $files = collect(\Illuminate\Support\Facades\File::files($assetPath));
    $cssFiles = $files->filter(fn($f) => str_ends_with($f->getFilename(), '.css'));
    $jsFiles = $files->filter(fn($f) => str_ends_with($f->getFilename(), '.js'));
@endphp

<!-- Styles -->
@foreach ($cssFiles as $css)
    <link rel="stylesheet" href="{{ asset('build/assets/' . $css->getFilename()) }}">
@endforeach

<!-- Scripts -->
@foreach ($jsFiles as $js)
    <script src="{{ asset('build/assets/' . $js->getFilename()) }}" type="module"></script>
@endforeach
