<!-- Single root container for Livewire component -->
<div>
    <!-- Create Event Button -->
    <x-filament::modal width="3xl" style="z-index: 99999;">
        <x-slot name="trigger">
            <x-filament::button
                style="background-color:#a5f8c5; color: #054721; display: flex; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: background-color 0.2s; width: fit-content;"
                class="dark:bg-gray-700 dark:text-green-400 dark:hover:bg-gray-600"
                onmouseover="this.style.backgroundColor='#62E489FF'" onmouseout="this.style.backgroundColor='#a5f8c5'">
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    <br>
    <!-- Calendar Container -->
    <div style="background-color: white; border-radius: 8px; box-shadow: 0 4px 12px -2px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.05); overflow: hidden; transition: all 0.3s ease; margin-top: 4px;"
        class="dark:bg-gray-900 dark:border dark:border-gray-700 dark:shadow-xl dark:shadow-gray-900/30">

        <!-- Calendar Header -->
        <div style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; padding: 16px 20px; position: relative;"
            class="dark:bg-gradient-to-r dark:from-gray-800 dark:to-gray-900 dark:shadow-lg">
            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZ3JhaW4iIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIj48Y2lyY2xlIGN4PSIyNSIgY3k9IjI1IiByPSIxIiBmaWxsPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMSkiLz48Y2lyY2xlIGN4PSI3NSIgY3k9Ijc1IiByPSIxIiBmaWxsPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMSkiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSJ1cmwoI2dyYWluKSIvPjwvc3ZnPg=='); opacity: 0.1;"
                class="dark:opacity-20">
            </div>
            <div style="position: relative; z-index: 1;">
                <div
                    style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
                        <button wire:click="previousMonth"
                            style="padding: 6px; background-color: transparent; border: none; border-radius: 6px; color: white; cursor: pointer; transition: background-color 0.2s;"
                            onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'"
                            onmouseout="this.style.backgroundColor='transparent'">
                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                        </button>

                        <h1 style="font-size: 18px; font-weight: bold; margin: 0; white-space: nowrap;">
                            {{ $monthName }}
                            {{ $year }}
                        </h1>

                        <button wire:click="nextMonth"
                            style="padding: 6px; background-color: transparent; border: none; border-radius: 6px; color: white; cursor: pointer; transition: background-color 0.2s;"
                            onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'"
                            onmouseout="this.style.backgroundColor='transparent'">
                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                        <!-- Search Input -->
                        <div style="position: relative;">
                            <input type="text" wire:model.live="searchQuery" placeholder="Search events..."
                                style="width: 160px; padding: 8px 12px; padding-right: 36px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; background-color: white; color: #111827; outline: none;"
                                class="dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent dark:focus:ring-green-400 md:w-48 lg:w-56">
                            <svg style="width: 14px; height: 14px; color: #9ca3af; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);"
                                class="dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>

                        <!-- Today Button -->
                        <button wire:click="goToToday"
                            style="padding: 8px 16px; background-color: white; color: #16a34a; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; transition: background-color 0.2s;"
                            class="dark:bg-gray-700 dark:text-green-400 dark:hover:bg-gray-600"
                            onmouseover="this.style.backgroundColor='#f0fdf4'"
                            onmouseout="this.style.backgroundColor='white'">
                            Today
                        </button>

                        <!-- View Toggle -->
                        <div style="display: flex; background-color: rgba(255,255,255,0.2); border-radius: 8px; padding: 4px;"
                            class="dark:bg-gray-600">
                            <button wire:click="switchView('month')"
                                style="padding: 4px 12px; border: none; border-radius: 6px; font-weight: 500; cursor: pointer; transition: all 0.2s; {{ $viewMode === 'month' ? 'background-color: white; color: #16a34a;' : 'color: white; background-color: transparent;' }}"
                                class="{{ $viewMode === 'month' ? 'dark:bg-gray-800 dark:text-green-400' : 'dark:text-gray-300' }}"
                                onmouseover="{{ $viewMode !== 'month' ? 'this.style.backgroundColor=\"rgba(255,255,255,0.2)\"' : '' }}"
                                onmouseout="{{ $viewMode !== 'month' ? 'this.style.backgroundColor=\"transparent\"' : '' }}">
                                Month
                            </button>
                            <button wire:click="switchView('week')"
                                style="padding: 4px 12px; border: none; border-radius: 6px; font-weight: 500; cursor: pointer; transition: all 0.2s; {{ $viewMode === 'week' ? 'background-color: white; color: #16a34a;' : 'color: white; background-color: transparent;' }}"
                                class="{{ $viewMode === 'week' ? 'dark:bg-gray-800 dark:text-green-400' : 'dark:text-gray-300' }}"
                                onmouseover="{{ $viewMode !== 'week' ? 'this.style.backgroundColor=\"rgba(255,255,255,0.2)\"' : '' }}"
                                onmouseout="{{ $viewMode !== 'week' ? 'this.style.backgroundColor=\"transparent\"' : '' }}">
                                Week
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div style="padding: 20px; overflow-x: auto; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);"
            class="dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900">
            <!-- Days of Week Header -->
            <div
                style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 1px; margin-bottom: 8px; min-width: 500px; max-width: 100%;">
                @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                    <div style="padding: 12px 8px; text-align: center; font-weight: 600; color: #374151; background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%); border-radius: 6px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);"
                        class="dark:bg-gradient-to-br dark:from-gray-700 dark:to-gray-800 dark:text-gray-200 dark:shadow-lg dark:shadow-gray-900/20">
                        <span style="display: none;" class="hidden md:inline">{{ $day }}</span>
                        <span style="display: inline;" class="md:hidden">{{ substr($day, 0, 1) }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Calendar Days -->
            <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 1px; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); border-radius: 8px; overflow: hidden; min-width: 500px; max-width: 100%; box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);"
                class="dark:bg-gradient-to-br dark:from-gray-700 dark:to-gray-800 dark:shadow-2xl dark:shadow-gray-900/50">
                @foreach ($calendarDays as $day)
                    @if ($day)
                        <div wire:click="selectDate('{{ $day['date'] }}')"
                            style="background: linear-gradient(135deg, #ffffff 0%, #fefefe 100%); min-height: 120px; padding: 8px; cursor: pointer; transition: all 0.3s ease; border-radius: 6px; {{ $day['is_today'] ? 'background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); box-shadow: 0 3px 8px rgba(34, 197, 94, 0.3);' : '' }} {{ $day['is_selected'] ? 'box-shadow: 0 0 0 2px #16a34a, 0 3px 8px rgba(22, 163, 74, 0.4);' : '' }}"
                            class="dark:bg-gradient-to-br dark:from-gray-700 dark:to-gray-800 dark:text-white {{ $day['is_today'] ? 'dark:bg-gradient-to-br dark:from-green-800 dark:to-green-900 dark:shadow-2xl dark:shadow-green-900/50' : '' }} dark:hover:shadow-lg dark:hover:shadow-gray-900/30"
                            onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='{{ $day['is_selected'] ? '0 0 0 2px #16a34a, ' : '' }}0 6px 16px rgba(0, 0, 0, 0.15)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='{{ $day['is_selected'] ? '0 0 0 2px #16a34a' : ($day['is_today'] ? '0 3px 8px rgba(34, 197, 94, 0.3)' : 'none') }}'">
                            <div style="font-size: 14px; font-weight: 600; color: #111827; margin-bottom: 6px; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);"
                                class="dark:text-gray-100">
                                {{ $day['day'] }}
                            </div>

                            <!-- Events for this day -->
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                @foreach ($day['events']->take(2) as $event)
                                    <div style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); color: #166534; font-size: 10px; padding: 4px 6px; border-radius: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-weight: 500; border: 1px solid rgba(34, 197, 94, 0.2);"
                                        class="dark:bg-gradient-to-r dark:from-green-800 dark:to-green-900 dark:text-green-200 dark:border-green-700 dark:shadow-lg dark:shadow-green-900/20"
                                        title="{{ $event->event_name }}">
                                        {{ Str::limit($event->event_name, 12) }}
                                    </div>
                                @endforeach

                                @if ($day['events']->count() > 2)
                                    <div style="font-size: 10px; color: #6b7280; font-weight: 500; background: rgba(107, 114, 128, 0.1); padding: 3px 6px; border-radius: 3px; text-align: center;"
                                        class="dark:text-gray-400 dark:bg-gray-600/50">
                                        +{{ $day['events']->count() - 2 }} more
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div style="background-color: #f9fafb; min-height: 120px;" class="dark:bg-gray-800"></div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Selected Date Details -->
        @if ($selectedDate)
            <div style="border-top: 1px solid #e5e7eb; padding: 24px; background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);"
                class="dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 dark:border-gray-700">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <h3 style="font-size: 16px; font-weight: 600; color: #111827; margin: 0;" class="dark:text-white">
                        Events for {{ \Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}
                    </h3>

                    <!-- Bulk Actions -->
                    @if ($selectedDateEvents->count() > 0)
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <label
                                style="display: flex; align-items: center; gap: 8px; font-size: 14px; color: #4b5563; cursor: pointer;"
                                class="dark:text-gray-300">
                                <input type="checkbox" {{ $selectAll ? 'checked' : '' }} wire:click="toggleSelectAll"
                                    style="width: 16px; height: 16px; accent-color: #16a34a; cursor: pointer;">
                                <span>Select All</span>
                            </label>

                            @if (count($selectedEvents) > 0)
                                <button wire:click="deleteSelectedEvents"
                                    style="padding: 8px 16px; background-color: #dc2626; color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 500; cursor: pointer; transition: background-color 0.2s;"
                                    class="dark:bg-red-700 dark:hover:bg-red-600"
                                    onmouseover="this.style.backgroundColor='#b91c1c'"
                                    onmouseout="this.style.backgroundColor='#dc2626'"
                                    onclick="return confirm('Are you sure you want to delete the selected events?')">
                                    <svg style="width: 16px; height: 16px; display: inline; margin-right: 6px;"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                    Delete Selected ({{ count($selectedEvents) }})
                                </button>
                            @endif
                        </div>
                    @endif
                </div>

                @if ($selectedDateEvents->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @foreach ($selectedDateEvents as $event)
                            <div style="background: linear-gradient(135deg, #ffffff 0%, #fefefe 100%); padding: 16px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.05); border: 1px solid rgba(229, 231, 235, 0.8); transition: all 0.3s ease; position: relative; overflow: hidden;"
                                class="dark:bg-gradient-to-br dark:from-gray-700 dark:to-gray-800 dark:border-gray-600 dark:shadow-2xl dark:shadow-gray-900/30"
                                onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 16px rgba(0, 0, 0, 0.15)'"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.05)'">
                                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0ic3VidGxlLXBhdHRlcm4iIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PGNpcmNsZSBjeD0iMTAiIGN5PSIxMCIgcj0iMC41IiBmaWxsPSJyZ2JhKDAsMCwwLDAuMDIpIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0idXJsKCNzdWJ0bGUtcGF0dGVybikiLz48L3N2Zz4=');
                                    opacity: 0.3;"
                                    class="dark:opacity-10">
                                </div>
                                <div style="position: relative; z-index: 1;">
                                    <div
                                        style="display: flex; align-items: flex-start; justify-content: space-between;">
                                        <div style="flex: 1;">
                                            <div
                                                style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                                                <div style="display: flex; align-items: center; gap: 12px;">
                                                    <input type="checkbox"
                                                        {{ in_array($event->id, $selectedEvents) ? 'checked' : '' }}
                                                        wire:click="toggleEventSelection({{ $event->id }})"
                                                        style="width: 16px; height: 16px; accent-color: #16a34a; cursor: pointer;">
                                                    <h4 style="font-weight: 600; color: #111827; margin: 0;"
                                                        class="dark:text-white">{{ $event->event_name }}</h4>
                                                </div>
                                                <!-- Edit Button -->
                                                <x-filament::modal width="3xl" wire:model="showEditModal"
                                                    style="z-index: 99999;">
                                                    <x-slot name="trigger">
                                                        <button wire:click="editEvent({{ $event->id }})"
                                                            style="padding: 6px 12px; background-color: #16a34a; color: white; border: none; border-radius: 6px; font-size: 12px; font-weight: 500; cursor: pointer; transition: background-color 0.2s; display: flex; align-items: center; gap: 4px;"
                                                            class="dark:bg-green-700 dark:hover:bg-green-600"
                                                            onmouseover="this.style.backgroundColor='#15803d'"
                                                            onmouseout="this.style.backgroundColor='#16a34a'">
                                                            <svg style="width: 14px; height: 14px;" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                                </path>
                                                            </svg>
                                                            Edit
                                                        </button>
                                                    </x-slot>
                                                    <x-slot name="heading">
                                                        Edit Event
                                                    </x-slot>

                                                    <form wire:submit="update({{ $event->id }})">
                                                        {{ $this->form }}
                                                        <br>
                                                        <x-filament::button type="submit" size="xl"
                                                            icon="heroicon-m-calendar-date-range">
                                                            Update Event
                                                        </x-filament::button>
                                                    </form>
                                                </x-filament::modal>
                                            </div>
                                            <p style="font-size: 14px; color: #4b5563; margin: 4px 0 0 0;"
                                                class="dark:text-gray-300">{{ $event->event_category }}</p>
                                            <div style="display: flex; align-items: center; margin-top: 8px; font-size: 12px; color: #6b7280; gap: 16px;"
                                                class="dark:text-gray-400">
                                                <span style="display: flex; align-items: center;">
                                                    <svg style="width: 16px; height: 16px; margin-right: 4px;"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $event->event_time }} ({{ $event->event_duration }})
                                                </span>
                                                <span style="display: flex; align-items: center;">
                                                    <svg style="width: 16px; height: 16px; margin-right: 4px;"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                                        </path>
                                                    </svg>
                                                    {{ $event->event_location }}
                                                </span>
                                            </div>
                                        </div>

                                        @if ($event->event_images && count($event->event_images) > 0)
                                            <div style="margin-left: 16px;">
                                                <img src="{{ asset('storage/' . $event->event_images[0]) }}"
                                                    alt="Event image"
                                                    style="width: 64px; height: 64px; object-fit: cover; border-radius: 8px; cursor: pointer; transition: opacity 0.2s;"
                                                    class="dark:border dark:border-gray-600"
                                                    onmouseover="this.style.opacity='0.8'"
                                                    onmouseout="this.style.opacity='1'"
                                                    wire:click="openImageModal({{ json_encode($event->event_images) }}, 0)">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 48px 0; color: #6b7280;" class="dark:text-gray-400">
                        <div style="position: relative; display: inline-block;">
                            <svg style="width: 64px; height: 64px; margin: 0 auto 20px; color: #d1d5db; filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));"
                                class="dark:text-gray-600 dark:filter dark:drop-shadow-[0_4px_8px_rgba(0,0,0,0.3)]"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 32px; height: 32px; background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); border-radius: 50%; opacity: 0.1;"
                                class="dark:opacity-20"></div>
                        </div>
                        <h3 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 600; color: #374151;"
                            class="dark:text-gray-300">No Events Scheduled</h3>
                        <p style="margin: 0; font-size: 14px; color: #9ca3af;" class="dark:text-gray-500">This date is
                            free. Create a new event to get started!</p>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Full-Screen Image Modal -->
    @if ($showImageModal && count($modalImages) > 0)
        <div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 99999; background-color: rgba(0, 0, 0, 0.9); display: flex; align-items: center; justify-content: center;"
            wire:keydown.escape="closeImageModal">
            <!-- Close Button -->
            <button wire:click="closeImageModal"
                style="position: absolute; top: 16px; right: 16px; z-index: 60; color: white; font-size: 30px; font-weight: bold; background: none; border: none; cursor: pointer; transition: color 0.2s;"
                onmouseover="this.style.color='#d1d5db'" onmouseout="this.style.color='white'">
                &times;
            </button>

            <!-- Main Image -->
            <div style="position: relative; max-width: 896px; max-height: 100vh; padding: 16px;">
                <img src="{{ asset('storage/' . $modalImages[$currentImageIndex]) }}" alt="Full screen image"
                    style="max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 8px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">

                <!-- Image Counter -->
                <div
                    style="position: absolute; bottom: 16px; left: 50%; transform: translateX(-50%); background-color: rgba(0, 0, 0, 0.75); color: white; padding: 6px 12px; border-radius: 9999px; font-size: 14px;">
                    {{ $currentImageIndex + 1 }} / {{ count($modalImages) }}
                </div>

                <!-- Navigation Arrows (only show if multiple images) -->
                @if (count($modalImages) > 1)
                    <!-- Previous Button -->
                    @if ($currentImageIndex > 0)
                        <button wire:click="previousImage"
                            style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); background-color: rgba(0, 0, 0, 0.5); color: white; border: none; padding: 12px; border-radius: 9999px; cursor: pointer; transition: background-color 0.2s;"
                            onmouseover="this.style.backgroundColor='rgba(0, 0, 0, 0.75)'"
                            onmouseout="this.style.backgroundColor='rgba(0, 0, 0, 0.5)'">
                            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                    @endif

                    <!-- Next Button -->
                    @if ($currentImageIndex < count($modalImages) - 1)
                        <button wire:click="nextImage"
                            style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); background-color: rgba(0, 0, 0, 0.5); color: white; border: none; padding: 12px; border-radius: 9999px; cursor: pointer; transition: background-color 0.2s;"
                            onmouseover="this.style.backgroundColor='rgba(0, 0, 0, 0.75)'"
                            onmouseout="this.style.backgroundColor='rgba(0, 0, 0, 0.5)'">
                            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    @endif

                    <!-- Thumbnail Navigation -->
                    <div
                        style="position: absolute; bottom: 64px; left: 50%; transform: translateX(-50%); display: flex; gap: 8px; background-color: rgba(0, 0, 0, 0.5); border-radius: 8px; padding: 8px;">
                        @foreach ($modalImages as $index => $image)
                            <button wire:click="$set('currentImageIndex', {{ $index }})"
                                style="width: 12px; height: 12px; border-radius: 9999px; border: none; cursor: pointer; transition: background-color 0.2s; {{ $index === $currentImageIndex ? 'background-color: white;' : 'background-color: #9ca3af;' }}"
                                onmouseover="{{ $index !== $currentImageIndex ? 'this.style.backgroundColor=\'#d1d5db\'' : '' }}"
                                onmouseout="{{ $index !== $currentImageIndex ? 'this.style.backgroundColor=\'#9ca3af\'' : '' }}">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- JavaScript for keyboard navigation -->
    <script>
        // Handle keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                @this.closeImageModal();
            }
            if (e.key === 'ArrowLeft') {
                @this.previousImage();
            }
            if (e.key === 'ArrowRight') {
                @this.nextImage();
            }
        });
    </script>
</div>
