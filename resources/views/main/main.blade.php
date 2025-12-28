<x-layouts.custome.header>
    <section class="relative bg-brown-700 text-white px-6 py-20 sm:py-28 md:py-32 lg:py-40 bg-cover bg-center"
        style="background-image: url('/home.png'); min-height: 600px;">

        <!-- Dark overlay -->
        <div class="absolute inset-0 bg-black/40"></div>

        <!-- Bottom fade -->
        <div class="absolute inset-x-0 bottom-0 h-48 bg-gradient-to-t from-black/50 to-transparent"></div>

        <div
            class="relative max-w-7xl mx-auto flex flex-col-reverse md:flex-row items-center justify-between gap-10 md:gap-20">
            <div class="max-w-xl">
                <h1 class="text-4xl sm:text-3xl md:text-4xl font-extrabold leading-tight">
                    Welcome to
                    <span class="font-extrabold"> Irosin Central School </span>
                </h1>
                <p class="mt-3 text-lg sm:text-base max-w-md">
                    Nurturing minds, building character, and shaping the future leaders
                    of tomorrow.
                </p>
                @if (!auth()->check())
                    <div class="mt-6 flex space-x-3">
                        <a href="/register"
                            class="bg-brown-500 text-white text-lg px-4 py-8 sm:text-sm font-semibold sm:px-4 sm:py-2 rounded-md hover:bg-brown-700">
                            Create an account
                        </a>
                        <a href="{{ route('faq') }}"
                            class="bg-brown-500 text-white text-lg sm:text-sm font-semibold px-4 py-2 rounded-md hover:bg-brown-700">
                            Frequently Asked Questions
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <style>
        .hero-section {
            background-image: url('/home.png');
            background-size: cover;
            background-position: center;
        }
    </style>

    @livewire('main.news')
    @livewire('main.event')
</x-layouts.custome.header>
