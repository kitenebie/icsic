<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-cream-50 antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
    {{-- @if (env('NOT_PAID') == true) --}}
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" id="paymentOverlay"
            style="display: none;">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full mx-4">
                <h2 class="text-xl font-bold mb-4">Payment Section</h2>
                <p class="mb-4">Please complete your payment using GCash.</p>
                <img src="/gcash.jpg" alt="GCash Logo" class="w-32 h-32 mx-auto mb-4">
            </div>
        </div>

        <script>
            function closePaymentOverlay() {
                document.getElementById('paymentOverlay').style.display = 'none';
            }
        </script>
    {{-- @endif --}}
        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <div class="bg-muted relative hidden h-full flex-col p-10 text-white lg:flex dark:border-e dark:border-neutral-800">
                
                <div class="absolute inset-0">
                    <div class="absolute inset-0 bg-brown-700 opacity-50">
                    </div>
                    <img class="w-full h-full"  src="/home.png" />
                </div>
                
                <a href="{{ route('home') }}" class="relative z-20 flex items-center text-lg font-medium" wire:navigate>
                    <span class="flex h-10 w-10 items-center mr-2 justify-center rounded-md">
                        <x-app-logo-icon class="me-2 h-7 fill-current text-white" /> 
                        <p></p>
                    </span>
                    {{ config('app.name', 'Laravel') }}
                </a>

                
                @php
                    $quote = Illuminate\Foundation\Inspiring::quotes()->random();
                    $parts = explode('-', $quote, 2);
                    $message = trim($parts[0] ?? $quote);
                    $author = trim($parts[1] ?? 'Unknown');
                @endphp

                <div class="relative z-20 mt-auto">
                    <blockquote class="space-y-2">
                        <flux:heading size="lg" class="text-white">&ldquo;{{ trim($message) }}&rdquo;</flux:heading>
                        <footer><flux:heading class="text-white">{{ $author }}</flux:heading></footer>
                    </blockquote>
                </div>
            </div>
            <div class="w-full lg:p-8">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                    <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden" wire:navigate>
                        <span class="flex h-9 w-9 items-center justify-center rounded-md">
                            <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" />
                        </span>

                        <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
