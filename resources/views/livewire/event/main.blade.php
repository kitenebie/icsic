<!-- Single root container for Livewire component -->
<div>
    <style>
        @keyframes highlightPulse {
            0% {
                box-shadow: 0 0 0 0 rgba(251, 191, 36, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(251, 191, 36, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(251, 191, 36, 0);
            }
        }

        @keyframes pulse {
            0% {
                transform: translateY(-50%) scale(0.8);
                opacity: 1;
            }
            50% {
                transform: translateY(-50%) scale(1.2);
                opacity: 0.7;
            }
            100% {
                transform: translateY(-50%) scale(0.8);
                opacity: 1;
            }
        }

        .highlighted-event {
            z-index: 10;
            transform: scale(1.05);
            transition: all 0.3s ease;
        }
    </style>
    <!-- Create Event Button -->
    <x-filament::modal width="3xl" style="z-index: 999 !important;">
        <x-slot name="trigger">
            <x-filament::button wire:click="createModalShow"
                style="background-color:#f5e8e1; color: #2e180f; display: flex; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: background-color 0.2s; width: fit-content;"
                class="dark:bg-gray-700 dark:text-brown-400 dark:hover:bg-gray-600"
                onmouseover="this.style.backgroundColor='#d1aa90'" onmouseout="this.style.backgroundColor='#f5e8e1'">
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

    <!-- Edit Event Modal -->
    <x-filament::modal width="3xl" id="open-modal-edit" style="z-index: 999 !important;">
        <x-slot name="heading">
            Edit Event
        </x-slot>

        <form wire:submit="update">
            {{ $this->form }}
            <br>
            <x-filament::button type="submit" size="xl" icon="heroicon-m-calendar-date-range">
                Update Event
            </x-filament::button>
        </form>
    </x-filament::modal>
    <br>
    <!-- Calendar Container -->
    <div style="background-color: white; border-radius: 8px; box-shadow: 0 4px 12px -2px #fdf8f6, 0 2px 4px -1px rgba(0, 0, 0, 0.05); overflow: hidden; transition: all 0.3s ease; margin-top: 4px;"
        class="dark:bg-gray-900 dark:border dark:border-gray-700 dark:shadow-xl dark:shadow-gray-900/30">

        <!-- Calendar Header -->
        <div style="background: linear-gradient(135deg, #965737 0%, #7c4328 100%); color: white; padding: 16px 20px; position: relative;"
            class="dark:bg-gradient-to-r dark:from-gray-800 dark:to-brown-900 dark:shadow-lg">
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

                        <!-- Month/Year Selector -->
                        <div style="position: relative;">
                            <button id="monthYearSelector" style="padding: 6px 12px; background-color: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; font-weight: 500; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 6px;"
                                onmouseover="this.style.backgroundColor='rgba(255,255,255,0.3)'"
                                onmouseout="this.style.backgroundColor='rgba(255,255,255,0.2)'">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span id="selectorDisplay">Select Month & Year</span>
                                <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Panel -->
                            <div id="monthYearDropdown" style="position: absolute; top: 100%; left: 0; margin-top: 8px; width: 280px; background: white; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 10px 25px -5px #fdf8f6, 0 10px 10px -5px rgba(0, 0, 0, 0.04); z-index: 1000; display: none;"
                                class="dark:bg-gray-800 dark:border-gray-600">
                                <!-- Header with Year Navigation -->
                                <div style="padding: 16px; border-bottom: 1px solid #e5e7eb; background: #f9fafb;"
                                    class="dark:bg-gray-700 dark:border-gray-600">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                                        <button id="yearDown" style="padding: 4px; background-color: transparent; border: none; border-radius: 50%; color: #6b7280; cursor: pointer; transition: background-color 0.2s;"
                                            class="dark:text-gray-400"
                                            onmouseover="this.style.backgroundColor='#e5e7eb'"
                                            onmouseout="this.style.backgroundColor='transparent'">
                                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <h3 id="dropdownYear" style="font-size: 16px; font-weight: 600; color: #111827; margin: 0;"
                                            class="dark:text-white">{{ $year }}</h3>
                                        <button id="yearUp" style="padding: 4px; background-color: transparent; border: none; border-radius: 50%; color: #6b7280; cursor: pointer; transition: background-color 0.2s;"
                                            class="dark:text-gray-400"
                                            onmouseover="this.style.backgroundColor='#e5e7eb'"
                                            onmouseout="this.style.backgroundColor='transparent'">
                                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div style="font-size: 12px; color: #6b7280; text-align: center;"
                                        class="dark:text-gray-400">
                                        Click on a month to navigate
                                    </div>
                                </div>

                                <!-- Month Grid -->
                                <div style="padding: 16px;">
                                    <div id="monthGrid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;">
                                        <!-- Months will be populated by JavaScript -->
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div style="padding: 12px; border-top: 1px solid #e5e7eb; background: #f9fafb; border-radius: 0 0 8px 8px;"
                                    class="dark:bg-gray-700 dark:border-gray-600">
                                    <button id="currentMonthBtn" style="width: 100%; padding: 8px 16px; background-color: #965737; color: white; border: none; border-radius: 6px; font-size: 12px; font-weight: 500; cursor: pointer; transition: background-color 0.2s;"
                                        class="dark:bg-brown-700 dark:hover:bg-brown-600"
                                        onmouseover="this.style.backgroundColor='#15803d'"
                                        onmouseout="this.style.backgroundColor='#b37b5d'">
                                        Go to Current Month
                                    </button>
                                </div>
                            </div>
                        </div>

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
                                style="width: 160px; padding: 8px 12px; padding-right: 36px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; background-color: white; color: #111827; outline: none; {{ $exactMatchFound ? 'border-color: #965737; box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.2);' : '' }}"
                                class="dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent dark:focus:ring-green-400 md:w-48 lg:w-56"
                                id="search-input">
                            <svg style="width: 14px; height: 14px; color: {{ $exactMatchFound ? '#965737' : '#9ca3af' }}; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);"
                                class="dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            @if($exactMatchFound)
                                <div style="position: absolute; right: -20px; top: 50%; transform: translateY(-50%); width: 8px; height: 8px; background-color: #965737; border-radius: 50%; animation: pulse 2s infinite;"></div>
                            @endif
                        </div>

                        <!-- Multiple Matches Selector -->
                        @if($multipleMatches && count($availableMatches) > 1)
                            <div style="position: absolute; top: 100%; left: 0; right: 0; margin-top: 4px; background: white; border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 4px 12px #f5e8e1; z-index: 1000; max-height: 200px; overflow-y: auto;"
                                class="dark:bg-gray-800 dark:border-gray-600">
                                <div style="padding: 8px; background: #f9fafb; border-bottom: 1px solid #e5e7eb; font-size: 12px; color: #6b7280;"
                                    class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                    Multiple events found - select one:
                                </div>
                                @foreach($availableMatches as $match)
                                    <button wire:click="selectEventFromMultipleMatches({{ $match['id'] }})"
                                        style="width: 100%; text-align: left; padding: 8px 12px; border: none; background: transparent; cursor: pointer; font-size: 12px; color: #374151; border-bottom: 1px solid #f3f4f6; transition: background-color 0.2s;"
                                        class="dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-700 hover:bg-gray-50"
                                        onmouseover="this.style.backgroundColor='#f9fafb'"
                                        onmouseout="this.style.backgroundColor='transparent'">
                                        <div style="font-weight: 500;">{{ $match['name'] }}</div>
                                        <div style="color: #6b7280; font-size: 11px;" class="dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($match['date'])->format('F j, Y') }} • {{ $match['category'] }}
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        @endif

                        <!-- Today Button -->
                        <button wire:click="goToToday"
                            style="padding: 8px 16px; background-color: white; color: #965737; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; transition: background-color 0.2s;"
                            class="dark:bg-gray-700 dark:text-brown-400 dark:hover:bg-gray-600"
                            onmouseover="this.style.backgroundColor='#f0fdf4'"
                            onmouseout="this.style.backgroundColor='white'">
                            Today
                        </button>

                        <!-- Refresh Button -->
                        <button wire:click="refreshCalendar"
                            style="padding: 8px; background-color: white; color: #965737; border: none; border-radius: 8px; cursor: pointer; transition: background-color 0.2s; display: flex; align-items: center; justify-content: center;"
                            class="dark:bg-gray-700 dark:text-brown-400 dark:hover:bg-gray-600"
                            onmouseover="this.style.backgroundColor='#f0fdf4'"
                            onmouseout="this.style.backgroundColor='white'"
                            title="Refresh Calendar">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </button>

                        <!-- View Toggle -->
                        <div style="display: none; background-color: rgba(255,255,255,0.2); border-radius: 8px; padding: 4px;"
                            class="dark:bg-gray-600">
                            <button wire:click="switchView('month')"
                                style="padding: 4px 12px; border: none; border-radius: 6px; font-weight: 500; cursor: pointer; transition: all 0.2s; {{ $viewMode === 'month' ? 'background-color: white; color: #965737;' : 'color: white; background-color: transparent;' }}"
                                class="{{ $viewMode === 'month' ? 'dark:bg-gray-800 dark:text-green-400' : 'dark:text-gray-300' }}"
                                onmouseover="{{ $viewMode !== 'month' ? 'this.style.backgroundColor=\"rgba(255,255,255,0.2)\"' : '' }}"
                                onmouseout="{{ $viewMode !== 'month' ? 'this.style.backgroundColor=\"transparent\"' : '' }}">
                                Month
                            </button>
                            <button wire:click="switchView('week')"
                                style="padding: 4px 12px; border: none; border-radius: 6px; font-weight: 500; cursor: pointer; transition: all 0.2s; {{ $viewMode === 'week' ? 'background-color: white; color: #965737;' : 'color: white; background-color: transparent;' }}"
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
            <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 1px; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); border-radius: 8px; overflow: hidden; min-width: 500px; max-width: 100%; box-shadow: inset 0 1px 3px #fdf8f6; position: relative;"
                class="dark:bg-gradient-to-br dark:from-gray-700 dark:to-gray-800 dark:shadow-2xl dark:shadow-gray-900/50">
                @php
                    // Google Calendar style color mapping function
                    function getEventColor($category)
                    {
                        $colors = [
                            "Exams & Quizzes" => "#965737", // brown-500
                            "Science Fair" => "#ffbf65", // cream-500
                            "Math Olympiad" => "#7c4328", // brown-600
                            "Spelling Bee" => "#e6a94f", // cream-600
                            "Debate/Essay Contests" => "#62341f", // brown-700
                            "Parent-Teacher Conferences" => "#b8853e", // cream-700
                            "Report Card Distribution" => "#4a2718", // brown-800
                            "Clubs (e.g., Journalism, Robotics)" => "#8a6330", // cream-800
                            "Student Council Elections" => "#2e180f", // brown-900
                            "Leadership Training" => "#5f4522", // cream-900
                            "Educational Field Trips" => "#b37b5d", // brown-400
                            "Intramurals" => "#ffd18f", // cream-400
                            "Sports Fest" => "#d1aa90", // brown-300
                            "Tryouts and Practice Sessions" => "#ffe2b9", // cream-300
                            "Cheerleading Competitions" => "#e7cfc0", // brown-200
                            "P.E. Demonstrations" => "#ffefdb", // cream-200
                            "Foundation Day" => "#f5e8e1", // brown-100
                            "Linggo ng Wika" => "#fff7ed", // cream-100
                            "Buwan ng Sining" => "#fdf8f6", // brown-50
                            "Christmas Program" => "#fffdfa", // cream-50
                            "School Play or Musical" => "#965737", // brown-500
                            "Art Exhibits" => "#ffbf65", // cream-500
                            "Cultural Shows" => "#7c4328", // brown-600
                            "Mass or Worship Services" => "#e6a94f", // cream-600
                            "Retreats & Recollections" => "#62341f", // brown-700
                            "Religious Holidays" => "#b8853e", // cream-700
                            "Moral Instruction Sessions" => "#4a2718", // brown-800
                            "Medical/Dental Missions" => "#8a6330", // cream-800
                            "Mental Health Week" => "#2e180f", // brown-900
                            "Anti-Bullying Campaigns" => "#5f4522", // cream-900
                            "Nutrition Month" => "#b37b5d", // brown-400
                            "Blood Donation Drives" => "#ffd18f", // cream-400
                            "Tree Planting" => "#d1aa90", // brown-300
                            "Community Clean-Up Drives" => "#ffe2b9", // cream-300
                            "Charity Events" => "#e7cfc0", // brown-200
                            "School Caravan" => "#ffefdb", // cream-200
                            "Brigada Eskwela" => "#f5e8e1", // brown-100
                            "General Assembly" => "#fff7ed", // cream-100
                            "Faculty Development" => "#fdf8f6", // brown-50
                            "Student/Parent Orientation" => "#fffdfa", // cream-50
                            "Enrollment Days" => "#965737", // brown-500
                            "Accreditation Visits" => "#ffbf65", // cream-500
                            "Awarding Ceremonies" => "#7c4328", // brown-600
                            "Recognition Day" => "#e6a94f", // cream-600
                            "Graduation/Moving-Up" => "#62341f", // brown-700
                            "Inter-School Competitions" => "#b8853e", // cream-700
                            "Other" => "#965737" // brown-500 as default
                        ];
                        return $colors[$category] ?? '#4285f4';
                    }

                    // Track which multi-day events have been rendered to avoid duplicates
                    $renderedMultiDayEvents = [];
                @endphp

                @foreach ($calendarDays as $dayIndex => $day)
                    @if ($day)
                        @php
                            $currentDate = \Carbon\Carbon::parse($day['date']);
                            $currentDayOfWeek = $dayIndex % 7;
                        @endphp

                        <div wire:click="selectDate('{{ $day['date'] }}')"
                            style="background: linear-gradient(135deg, #ffffff 0%, #fefefe 100%); min-height: 120px; padding: 8px; cursor: pointer; transition: all 0.3s ease; border-radius: 6px; position: relative; {{ $day['is_today'] ? 'background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); box-shadow: 0 3px 8px rgba(150, 87, 55, 0.3);' : '' }} {{ $day['is_selected'] ? 'box-shadow: 0 0 0 2px #965737, 0 3px 8px rgba(150, 87, 55, 0.4);' : '' }}"
                            class="dark:bg-gradient-to-br dark:from-gray-700 dark:to-gray-800 dark:text-white {{ $day['is_today'] ? 'dark:bg-gradient-to-br dark:from-green-800 dark:to-green-900 dark:shadow-2xl dark:shadow-green-900/50' : '' }} dark:hover:shadow-lg dark:hover:shadow-gray-900/30"
                            onmouseover="this.style.transform='translateY(1px)'; this.style.boxShadow='{{ $day['is_selected'] ? '0 0 0 2px #b37b5d, ' : '' }}0 6px 16px #f5e8e1'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='{{ $day['is_selected'] ? '0 0 0 2px #b37b5d' : ($day['is_today'] ? '0 3px 8px #e7cfc0' : 'none') }}'">

                            <div style="font-size: 14px; font-weight: 600; color: #111827; margin-bottom: 6px; text-shadow: 0 1px 2px #fdf8f6;"
                                class="dark:text-gray-100">
                                {{ $day['day'] }}
                            </div>

                            <!-- Events for this day -->
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                @php
                                    $topOffset = 24;
                                    $multiDayEventsForCell = [];
                                @endphp

                                @foreach ($day['events'] as $event)
                                    @php
                                        $isMultiDay = $event->event_end && $event->event_date != $event->event_end;
                                        $startDate = \Carbon\Carbon::parse($event->event_date);
                                        $endDate = $event->event_end
                                            ? \Carbon\Carbon::parse($event->event_end)
                                            : $startDate;

                                        // Check if this is the first day this event appears in the current week row
                                        $isFirstDayInWeek =
                                            $currentDate->isSameDay($startDate) ||
                                            ($currentDayOfWeek == 0 && $currentDate->between($startDate, $endDate));
                                    @endphp

                                    @if ($isMultiDay)
                                        @if ($isFirstDayInWeek && !in_array($event->id . '-' . floor($dayIndex / 7), $renderedMultiDayEvents))
                                            @php
                                                // Calculate span width for this week row
                                                $remainingDaysInRow = 7 - $currentDayOfWeek;
                                                $remainingEventDays = $currentDate->diffInDays($endDate) + 1;
                                                $spanWidth = min($remainingEventDays, $remainingDaysInRow);

                                                $eventColor = getEventColor($event->event_category);
                                                $totalDays = $startDate->diffInDays($endDate) + 1;

                                                // Mark this event as rendered for this week row
                                                $renderedMultiDayEvents[] = $event->id . '-' . floor($dayIndex / 7);
                                            @endphp

                                            <!-- Multi-day event spanning bar -->
                                            <div style="z-index: {{ $modalOpen ? 0 : 100 }}; background: {{ $eventColor }}; color: white; font-size: 10px; padding: 4px 8px; border-radius: 6px; font-weight: 600; border: 2px solid rgba(255, 255, 255, 0.3); position: absolute; top: {{ $topOffset }}px; left: -8px; width: calc({{ $spanWidth }} * 100% + {{ ($spanWidth - 1) * 2 }}px); box-shadow: 0 3px 6px rgba(0, 0, 0, 0.3); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                                title="{{ $event->event_name }} ({{ $startDate->format('M j') }} - {{ $endDate->format('M j') }}, {{ $totalDays }} days)">
                                                {{ $event->event_name }} ({{ $totalDays }} days)
                                            </div>

                                            @php
                                                $topOffset += 32;
                                                $multiDayEventsForCell[] = $event;
                                            @endphp
                                        @endif
                                    @endif
                                @endforeach

                                <!-- Spacer for multi-day events -->
                                @if (count($multiDayEventsForCell) > 0)
                                    <div style="height: {{ count($multiDayEventsForCell) * 32 }}px;"></div>
                                @endif

                                <!-- Single day events -->
                                @foreach ($day['events'] as $event)
                                    @php
                                        $isMultiDay = $event->event_end && $event->event_date != $event->event_end;
                                    @endphp
                                    @if (!$isMultiDay)
                                        @php
                                            $isHighlighted = $highlightedEventId && $event->id == $highlightedEventId;
                                            $highlightStyle = $isHighlighted ?
                                                'background: linear-gradient(135deg, #d1aa90 0%, #b37b5d 100%); color: #4a2718; border: 2px solid #965737; box-shadow: 0 0 0 2px rgba(209, 170, 144, 0.3), 0 4px 12px rgba(209, 170, 144, 0.4); animation: highlightPulse 2s infinite;' :
                                                'background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); color: #4a2718; border: 1px solid rgba(150, 87, 55, 0.2);';
                                        @endphp
                                        <div style="{{ $highlightStyle }}"
                                            class="dark:bg-gradient-to-r dark:from-green-800 dark:to-green-900 dark:text-green-200 dark:border-green-700 dark:shadow-lg dark:shadow-green-900/20 {{ $isHighlighted ? 'highlighted-event' : '' }}"
                                            title="{{ $event->event_name }}"
                                            data-event-id="{{ $event->id }}">
                                            {{ Str::limit($event->event_name, 12) }}
                                            @if($isHighlighted)
                                                <span style="margin-left: 2px;">⭐</span>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
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
                                    style="width: 16px; height: 16px; accent-color: #965737; cursor: pointer;">
                                <span>Select All</span>
                            </label>

                            @if (count($selectedEvents) > 0)
                                <button wire:click="deleteSelectedEvents"
                                    style="padding: 8px 16px; background-color: #b37b5d; color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 500; cursor: pointer; transition: background-color 0.2s;"
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
                            <div style="background: linear-gradient(135deg, #ffffff 0%, #fefefe 100%); padding: 16px; border-radius: 8px; box-shadow: 0 2px 8px #fdf8f6, 0 1px 3px rgba(0, 0, 0, 0.05); border: 1px solid rgba(229, 231, 235, 0.8); transition: all 0.3s ease; position: relative; overflow: hidden;"
                                class="dark:bg-gradient-to-br dark:from-gray-700 dark:to-gray-800 dark:border-gray-600 dark:shadow-2xl dark:shadow-gray-900/30"
                                onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 16px #f5e8e1'"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px #fdf8f6, 0 1px 3px rgba(0, 0, 0, 0.05)'">
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
                                                        style="width: 16px; height: 16px; accent-color: #965737; cursor: pointer;">
                                                    <h4 style="font-weight: 600; color: #111827; margin: 0;"
                                                        class="dark:text-white">{{ $event->event_name }}</h4>
                                                </div>
                                                <!-- Edit Button -->
                                                <button wire:click="editEvent({{ $event->id }})"
                                                    style="padding: 6px 12px; background-color: #965737; color: white; border: none; border-radius: 6px; font-size: 12px; font-weight: 500; cursor: pointer; transition: background-color 0.2s; display: flex; align-items: center; gap: 4px;"
                                                    class="dark:bg-brown-700 dark:hover:bg-brown-600"
                                                    onmouseover="this.style.backgroundColor='#964F2CFF'"
                                                    onmouseout="this.style.backgroundColor='#965737'">
                                                    <svg style="width: 14px; height: 14px;" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                    Edit
                                                </button>
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
                            <svg style="width: 64px; height: 64px; margin: 0 auto 20px; color: #d1d5db; filter: drop-shadow(0 4px 8px #fdf8f6);"
                                class="dark:text-gray-600 dark:filter dark:drop-shadow-[0_4px_8px_rgba(0,0,0,0.3)]"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 32px; height: 32px; background: linear-gradient(135deg, #965737 0%, #7c4328 100%); border-radius: 50%; opacity: 0.1;"
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

    <!-- JavaScript for keyboard navigation, modal state management, and enhanced search -->
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

        // Enhanced search functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll to highlighted event when search finds exact match
            @if($highlightedEventId)
                setTimeout(function() {
                    const highlightedElement = document.querySelector('.highlighted-event');
                    if (highlightedElement) {
                        highlightedElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center',
                            inline: 'nearest'
                        });

                        // Add temporary focus animation
                        highlightedElement.style.animation = 'highlightPulse 2s ease-in-out';
                    }
                }, 100);
            @endif
        });

        // Listen for Livewire events to trigger smooth scrolling
        document.addEventListener('livewire:updated', function() {
            @if($highlightedEventId)
                setTimeout(function() {
                    const highlightedElement = document.querySelector('.highlighted-event');
                    if (highlightedElement) {
                        highlightedElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center',
                            inline: 'nearest'
                        });
                    }
                }, 100);
            @endif
        });

        // Listen for modal events to manage z-index
        document.addEventListener('DOMContentLoaded', function() {
            // Listen for create modal open/close events
            const createModal = document.querySelector('[x-filament\\\\:modal]');
            if (createModal) {
                // Listen for modal open event
                createModal.addEventListener('click', function(e) {
                    if (e.target.matches('[x-filament\\\\:button]') || e.target.closest('[x-filament\\\\:button]')) {
                        // Delay to ensure modal is fully opened
                        setTimeout(() => {
                            @this.set('modalOpen', true);
                        }, 100);
                    }
                });

                // Listen for modal close events (clicking outside or close button)
                createModal.addEventListener('mousedown', function(e) {
                    if (e.target === createModal || e.target.matches('[wire\\\\:click\\\\*=\"close\"]') || e.target.closest('[wire\\\\:click\\\\*=\"close\"]')) {
                        @this.set('modalOpen', false);
                    }
                });
            }

            // Listen for edit modal events
            const editModal = document.getElementById('open-modal-edit');
            if (editModal) {
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                            const isVisible = editModal.style.display !== 'none';
                            @this.set('modalOpen', isVisible);
                        }
                    });
                });

                observer.observe(editModal, {
                    attributes: true,
                    attributeFilter: ['style']
                });
            }
        });
    </script>

    <!-- Month/Year Selector JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monthYearSelector = document.getElementById('monthYearSelector');
            const monthYearDropdown = document.getElementById('monthYearDropdown');
            const dropdownYear = document.getElementById('dropdownYear');
            const monthGrid = document.getElementById('monthGrid');
            const yearUp = document.getElementById('yearUp');
            const yearDown = document.getElementById('yearDown');
            const currentMonthBtn = document.getElementById('currentMonthBtn');
            const selectorDisplay = document.getElementById('selectorDisplay');

            let currentYear = {{ $year }};
            let currentMonth = {{ date('n') - 1 }}; // JavaScript months are 0-based

            const months = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            // Initialize the selector
            function initMonthYearSelector() {
                updateDropdownYear();
                updateSelectorDisplay();
                renderMonthGrid();
            }

            // Update the year in dropdown
            function updateDropdownYear() {
                dropdownYear.textContent = currentYear;
            }

            // Update the selector button display
            function updateSelectorDisplay() {
                selectorDisplay.textContent = `${months[currentMonth]} ${currentYear}`;
            }

            // Render month grid
            function renderMonthGrid() {
                monthGrid.innerHTML = '';
                months.forEach((month, index) => {
                    const monthButton = document.createElement('button');
                    monthButton.style.cssText = `
                        padding: 12px; font-size: 12px; font-weight: 500; border-radius: 6px; transition: all 0.2s; border: none; cursor: pointer; text-align: center; ${
                            index === currentMonth
                                ? 'background-color: #965737; color: white;'
                                : 'background-color: #f3f4f6; color: #374151;'
                        }
                    `;
                    monthButton.textContent = month.substring(0, 3); // Show abbreviated month names
                    monthButton.addEventListener('click', function() {
                        currentMonth = index;
                        updateSelectorDisplay();
                        monthYearDropdown.style.display = 'none';

                        // Update the Livewire component
                        const newDate = new Date(currentYear, currentMonth, 1);
                        @this.call('setMonthYear', currentYear, currentMonth + 1);
                    });

                    // Add hover effects
                    monthButton.addEventListener('mouseover', function() {
                        if (index !== currentMonth) {
                            this.style.backgroundColor = '#e5e7eb';
                        }
                    });
                    monthButton.addEventListener('mouseout', function() {
                        if (index !== currentMonth) {
                            this.style.backgroundColor = '#f3f4f6';
                        }
                    });

                    monthGrid.appendChild(monthButton);
                });
            }

            // Year navigation
            yearUp.addEventListener('click', function() {
                currentYear++;
                updateDropdownYear();
                renderMonthGrid();
            });

            yearDown.addEventListener('click', function() {
                currentYear--;
                updateDropdownYear();
                renderMonthGrid();
            });

            // Toggle dropdown
            monthYearSelector.addEventListener('click', function(e) {
                e.stopPropagation();
                renderMonthGrid();
                monthYearDropdown.style.display = monthYearDropdown.style.display === 'none' ? 'block' : 'none';
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!monthYearSelector.contains(e.target) && !monthYearDropdown.contains(e.target)) {
                    monthYearDropdown.style.display = 'none';
                }
            });

            // Go to current month
            currentMonthBtn.addEventListener('click', function() {
                const now = new Date();
                currentYear = now.getFullYear();
                currentMonth = now.getMonth();
                updateDropdownYear();
                updateSelectorDisplay();
                renderMonthGrid();

                // Update the Livewire component
                @this.call('setMonthYear', currentYear, currentMonth + 1);

                monthYearDropdown.style.display = 'none';
            });

            // Initialize the selector
            initMonthYearSelector();
        });
        //render every 1second to update the time
        setInterval(() => {
            renderMonthGrid();
        }, 1000);
    </script>
</div>
