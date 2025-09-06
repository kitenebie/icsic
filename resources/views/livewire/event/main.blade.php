<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <!-- Calendar Header -->
    <div class="bg-blue-600 text-white p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button wire:click="previousMonth"
                        class="p-2 hover:bg-blue-700 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <h1 class="text-2xl font-bold">{{ $monthName }} {{ $year }}</h1>

                <button wire:click="nextMonth"
                        class="p-2 hover:bg-blue-700 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Today Button -->
                <button wire:click="goToToday"
                        class="px-4 py-2 bg-white text-blue-600 rounded-lg hover:bg-gray-100 transition-colors font-medium">
                    Today
                </button>

                <!-- View Toggle -->
                <div class="flex bg-white bg-opacity-20 rounded-lg p-1">
                    <button wire:click="switchView('month')"
                            class="px-3 py-1 rounded-md transition-colors {{ $viewMode === 'month' ? 'bg-white text-blue-600' : 'text-white hover:bg-white hover:bg-opacity-20' }}">
                        Month
                    </button>
                    <button wire:click="switchView('week')"
                            class="px-3 py-1 rounded-md transition-colors {{ $viewMode === 'week' ? 'bg-white text-blue-600' : 'text-white hover:bg-white hover:bg-opacity-20' }}">
                        Week
                    </button>
                </div>

                <!-- Create Event Button -->
                <x-filament::modal width="3xl">
                    <x-slot name="trigger">
                        <x-filament::button class="bg-white text-blue-600 hover:bg-gray-100">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Event
                        </x-filament::button>
                    </x-slot>
                    <x-slot name="heading">
                        Create New Event
                    </x-slot>

                    <form wire:submit="create">
                        {{ $this->form }}
                        <br>
                        <x-filament::button type="submit" size="xl" icon="heroicon-m-calendar-date-range">
                            Save Event
                        </x-filament::button>
                    </form>
                </x-filament::modal>
            </div>
        </div>
    </div>

    <!-- Calendar Grid -->
    <div class="p-6">
        <!-- Days of Week Header -->
        <div class="grid grid-cols-7 gap-px mb-2">
            @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                <div class="p-3 text-center font-semibold text-gray-600 bg-gray-50">
                    {{ $day }}
                </div>
            @endforeach
        </div>

        <!-- Calendar Days -->
        <div class="grid grid-cols-7 gap-px bg-gray-200 rounded-lg overflow-hidden">
            @foreach($calendarDays as $day)
                @if($day)
                    <div wire:click="selectDate('{{ $day['date'] }}')"
                         class="bg-white min-h-[120px] p-2 cursor-pointer hover:bg-blue-50 transition-colors {{ $day['is_today'] ? 'bg-blue-100' : '' }} {{ $day['is_selected'] ? 'ring-2 ring-blue-500' : '' }}">
                        <div class="text-sm font-medium text-gray-900 mb-1">
                            {{ $day['day'] }}
                        </div>

                        <!-- Events for this day -->
                        <div class="space-y-1">
                            @foreach($day['events']->take(3) as $event)
                                <div class="bg-blue-100 text-blue-800 text-xs p-1 rounded truncate"
                                     title="{{ $event->event_name }}">
                                    {{ Str::limit($event->event_name, 15) }}
                                </div>
                            @endforeach

                            @if($day['events']->count() > 3)
                                <div class="text-xs text-gray-500">
                                    +{{ $day['events']->count() - 3 }} more
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="bg-gray-50 min-h-[120px]"></div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Selected Date Details -->
    @if($selectedDate)
        <div class="border-t border-gray-200 p-6 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                Events for {{ \Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}
            </h3>

            @if($selectedDateEvents->count() > 0)
                <div class="space-y-4">
                    @foreach($selectedDateEvents as $event)
                        <div class="bg-white p-4 rounded-lg shadow-sm border">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ $event->event_name }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">{{ $event->event_category }}</p>
                                    <div class="flex items-center mt-2 text-xs text-gray-500 space-x-4">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $event->event_time }} ({{ $event->event_duration }})
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $event->event_location }}
                                        </span>
                                    </div>
                                </div>

                                @if($event->event_images && count($event->event_images) > 0)
                                    <div class="ml-4">
                                        <img src="{{ asset('storage/' . $event->event_images[0]) }}"
                                             alt="Event image"
                                             class="w-16 h-16 object-cover rounded-lg">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p>No events for this date</p>
                </div>
            @endif
        </div>
    @endif
</div>
