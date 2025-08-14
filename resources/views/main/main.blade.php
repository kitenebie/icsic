<x-layouts.custome.header>
    <!-- Hero Section -->
    <section class="bg-green-700 text-white px-6 py-12 sm:py-16 md:py-20 lg:py-24">
        <div class="max-w-7xl mx-auto flex flex-col-reverse md:flex-row items-center justify-between gap-10 md:gap-20">
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
            <div class="bg-white rounded-lg p-6 shadow-lg max-w-[320px] sm:max-w-[360px] md:max-w-[400px] w-full">
                <div class="bg-gray-300 rounded-md p-6">
                    <img alt="Green and white stylized school icon graphic on gray background"
                        class="w-full h-auto rounded" height="180"
                        src="/school-logo.png"
                        width="320" />
                </div>
            </div>
        </div>
    </section>

    @livewire('main.news')
    @if(auth()->check() && auth()->user()->role != 'pending')
        @livewire('main.event')
    @endif
</x-layouts.custome.header>
