<div style="background-color: white; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); overflow: hidden;">
    <!-- Calendar Header -->
    <div style="background-color: #2563eb; color: white; padding: 24px;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <button wire:click="previousMonth"
                        style="padding: 8px; background-color: transparent; border: none; border-radius: 8px; color: white; cursor: pointer; transition: background-color 0.2s;"
                        onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'"
                        onmouseout="this.style.backgroundColor='transparent'">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <h1 style="font-size: 24px; font-weight: bold; margin: 0;">{{ $monthName }} {{ $year }}</h1>

                <button wire:click="nextMonth"
                        style="padding: 8px; background-color: transparent; border: none; border-radius: 8px; color: white; cursor: pointer; transition: background-color 0.2s;"
                        onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'"
                        onmouseout="this.style.backgroundColor='transparent'">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <div style="display: flex; align-items: center; gap: 16px;">
                <!-- Search Input -->
                <div style="position: relative;">
                    <input type="text" wire:model.live="searchQuery" placeholder="Search announcements..."
                           style="width: 200px; padding: 8px 12px; padding-right: 40px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; focus:outline: none; focus:ring-2: focus:ring-blue-500; focus:border-transparent;">
                    <svg style="width: 16px; height: 16px; color: #9ca3af; position: absolute; right: 12px; top: 50%; transform: translateY(-50%);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <!-- Today Button -->
                <button wire:click="goToToday"
                        style="padding: 8px 16px; background-color: white; color: #2563eb; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; transition: background-color 0.2s;"
                        onmouseover="this.style.backgroundColor='#f3f4f6'"
                        onmouseout="this.style.backgroundColor='white'">
                    Today
                </button>

                <!-- View Toggle -->
                <div style="display: flex; background-color: rgba(255,255,255,0.2); border-radius: 8px; padding: 4px;">
                    <button wire:click="switchView('month')"
                            style="padding: 4px 12px; border: none; border-radius: 6px; font-weight: 500; cursor: pointer; transition: all 0.2s; {{ $viewMode === 'month' ? 'background-color: white; color: #2563eb;' : 'color: white; background-color: transparent;' }}"
                            onmouseover="{{ $viewMode !== 'month' ? 'this.style.backgroundColor=\"rgba(255,255,255,0.2)\"' : '' }}"
                            onmouseout="{{ $viewMode !== 'month' ? 'this.style.backgroundColor=\"transparent\"' : '' }}">
                        Month
                    </button>
                    <button wire:click="switchView('week')"
                            style="padding: 4px 12px; border: none; border-radius: 6px; font-weight: 500; cursor: pointer; transition: all 0.2s; {{ $viewMode === 'week' ? 'background-color: white; color: #2563eb;' : 'color: white; background-color: transparent;' }}"
                            onmouseover="{{ $viewMode !== 'week' ? 'this.style.backgroundColor=\"rgba(255,255,255,0.2)\"' : '' }}"
                            onmouseout="{{ $viewMode !== 'week' ? 'this.style.backgroundColor=\"transparent\"' : '' }}">
                        Week
                    </button>
                </div>
            </div>

            <!-- Create Announcement Button -->
            <x-filament::modal width="2xl" slide-over :close-by-clicking-away="false">
                <x-slot name="trigger">
                    <x-filament::button style="background-color: white; color: #2563eb; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: background-color 0.2s;"
                                      onmouseover="this.style.backgroundColor='#f3f4f6'"
                                      onmouseout="this.style.backgroundColor='white'">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    <div style="padding: 24px;">
        <!-- Days of Week Header -->
        <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 1px; margin-bottom: 8px;">
            @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                <div style="padding: 12px; text-align: center; font-weight: 600; color: #4b5563; background-color: #f9fafb;">
                    {{ $day }}
                </div>
            @endforeach
        </div>

        <!-- Calendar Days -->
        <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 1px; background-color: #e5e7eb; border-radius: 8px; overflow: hidden;">
            @foreach($calendarDays as $day)
                @if($day)
                    <div wire:click="selectDate('{{ $day['date'] }}')"
                         style="background-color: white; min-height: 120px; padding: 8px; cursor: pointer; transition: background-color 0.2s; {{ $day['is_today'] ? 'background-color: #dbeafe;' : '' }} {{ $day['is_selected'] ? 'box-shadow: 0 0 0 2px #3b82f6;' : '' }}"
                         onmouseover="this.style.backgroundColor='#eff6ff'"
                         onmouseout="this.style.backgroundColor='{{ $day['is_today'] ? '#dbeafe' : 'white' }}'">
                        <div style="font-size: 14px; font-weight: 500; color: #111827; margin-bottom: 4px;">
                            {{ $day['day'] }}
                        </div>

                        <!-- Announcements for this day -->
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                            @foreach($day['announcements']->take(3) as $announcement)
                                <div style="background-color: #dbeafe; color: #1e40af; font-size: 12px; padding: 4px; border-radius: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                     title="{{ $announcement->title }}">
                                    {{ Str::limit($announcement->title, 15) }}
                                </div>
                            @endforeach

                            @if($day['announcements']->count() > 3)
                                <div style="font-size: 12px; color: #6b7280;">
                                    +{{ $day['announcements']->count() - 3 }} more
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div style="background-color: #f9fafb; min-height: 120px;"></div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Selected Date Details -->
    @if($selectedDate)
        <div style="border-top: 1px solid #e5e7eb; padding: 24px; background-color: #f9fafb;">
            <h3 style="font-size: 18px; font-weight: 600; color: #111827; margin-bottom: 16px; margin-top: 0;">
                Announcements for {{ \Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}
            </h3>

            @if($selectedDateAnnouncements->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    @foreach($selectedDateAnnouncements as $announcement)
                        <div style="background-color: white; padding: 16px; border-radius: 8px; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); border: 1px solid #e5e7eb;">
                            <div style="display: flex; align-items: flex-start; justify-content: space-between;">
                                <div style="flex: 1;">
                                    <h4 style="font-weight: 600; color: #111827; margin: 0;">{{ $announcement->title }}</h4>
                                    <p style="font-size: 14px; color: #4b5563; margin: 4px 0 0 0;">
                                        {{ Str::limit(strip_tags($announcement->content), 100) }}
                                    </p>
                                    <div style="display: flex; align-items: center; margin-top: 8px; font-size: 12px; color: #6b7280;">
                                        <svg style="width: 16px; height: 16px; margin-right: 4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $announcement->created_at->format('g:i A') }}
                                    </div>
                                </div>

                                @if($announcement->images && count($announcement->images) > 0)
                                    <div style="margin-left: 16px;">
                                        <img src="{{ asset('storage/' . $announcement->images[0]) }}"
                                             alt="Announcement image"
                                             style="width: 64px; height: 64px; object-fit: cover; border-radius: 8px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 32px 0; color: #6b7280;">
                    <svg style="width: 48px; height: 48px; margin: 0 auto 16px; color: #d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p style="margin: 0;">No announcements for this date</p>
                </div>
            @endif
        </div>
    @endif

    <x-filament-actions::modals />

    <script>
        // Handle keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                // Close any open modals
            }
        });
    </script>
</div>
