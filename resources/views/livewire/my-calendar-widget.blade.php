<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Header --}}
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-800">
                📅 My Events Calendar
            </h2>
            <p class="text-sm text-gray-500">
                View all upcoming events here
            </p>
        </div>

        {{-- Calendar (Guava renders this automatically) --}}
        {{ $this->calendar }}

    </x-filament::section>
</x-filament-widgets::widget>
