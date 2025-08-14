<x-layouts.custome.header>
    <section class="relative bg-green-700 text-white px-6 py-20 sm:py-28 md:py-32 lg:py-40 bg-cover bg-center"
        style="background-image: url('/home.jpg'); min-height: 600px;">

        <!-- Dark overlay -->
        <div class="absolute inset-0 bg-black/40"></div>

        <!-- Bottom fade -->
        <div class="absolute inset-x-0 bottom-0 h-48 bg-gradient-to-t from-black/50 to-transparent"></div>

        <div
            class="relative max-w-7xl mx-auto flex flex-col-reverse md:flex-row items-center justify-between gap-10 md:gap-20">
            <div class="max-w-xl">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold leading-tight">
                    Welcome to
                    <span class="font-extrabold"> Irosin Central School </span>
                </h1>
                <p class="mt-3 text-sm sm:text-base max-w-md">
                    Nurturing minds, building character, and shaping the future leaders
                    of tomorrow.
                </p>
                @if (!auth()->check())
                    <div class="mt-6 flex space-x-3">
                        <a href="/"
                            class="bg-white text-green-800 font-bold text-xs sm:text-sm px-4 py-2 rounded-md hover:bg-gray-100">
                            Create an account
                        </a>
                        <a href="#"
                            class="border border-white text-white font-semibold text-xs sm:text-sm px-4 py-2 rounded-md hover:bg-white hover:text-green-700 transition">
                            Learn More
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <style>
        .hero-section {
            background-image: url('/home.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>

    @livewire('main.news')
    @if (auth()->check() && auth()->user()->role != 'pending')
        @livewire('main.event')
    @endif
</x-layouts.custome.header>
