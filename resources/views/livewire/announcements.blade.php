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

            <!-- Create Announcement Button -->
            <x-filament::modal width="2xl" slide-over :close-by-clicking-away="false">
                <x-slot name="trigger">
                    <x-filament::button class="bg-white text-blue-600 hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        New Announcement
                    </x-filament::button>
                </x-slot>
                <div>
                    <x-slot name="heading">
                        Create New Announcement
                    </x-slot>
                    <form wire:submit="create">
                        {{ $this->form }}
                        <br><br>
                        <x-filament::button class="flex-row items-center justify-center gap-2 w-full" type="submit" wire:target="create"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>Post Announcement</span>
                            <span wire:loading>
                                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </x-filament::button>
                    </form>
                </div>
            </x-filament::modal>
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

                        <!-- Announcements for this day -->
                        <div class="space-y-1">
                            @foreach($day['announcements']->take(3) as $announcement)
                                <div class="bg-blue-100 text-blue-800 text-xs p-1 rounded truncate"
                                     title="{{ $announcement->title }}">
                                    {{ Str::limit($announcement->title, 15) }}
                                </div>
                            @endforeach

                            @if($day['announcements']->count() > 3)
                                <div class="text-xs text-gray-500">
                                    +{{ $day['announcements']->count() - 3 }} more
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
                Announcements for {{ \Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}
            </h3>

            @if($selectedDateAnnouncements->count() > 0)
                <div class="space-y-4">
                    @foreach($selectedDateAnnouncements as $announcement)
                        <div class="bg-white p-4 rounded-lg shadow-sm border">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ $announcement->title }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ Str::limit(strip_tags($announcement->content), 100) }}
                                    </p>
                                    <div class="flex items-center mt-2 text-xs text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $announcement->created_at->format('g:i A') }}
                                    </div>
                                </div>

                                @if($announcement->images && count($announcement->images) > 0)
                                    <div class="ml-4">
                                        <img src="{{ asset('storage/' . $announcement->images[0]) }}"
                                             alt="Announcement image"
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
                    <p>No announcements for this date</p>
                </div>
            @endif
        </div>
    @endif

    <x-filament-actions::modals />
</div>
