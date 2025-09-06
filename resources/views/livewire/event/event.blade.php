<div>
    <div class="bg-white min-h-screen">
        <!-- Google Calendar Style Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <div class="flex items-center space-x-4">
                <h1 class="text-2xl font-normal text-gray-900">Calendar</h1>
                <div class="flex items-center space-x-2">
                    <button id="prev" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button id="next" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    <h2 id="monthYear" class="text-xl font-medium text-gray-900 ml-4">April 2025</h2>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                    Today
                </button>
                <div class="flex rounded-md shadow-sm">
                    <button class="px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50">
                        Month
                    </button>
                    <button class="px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-r-md hover:bg-gray-50">
                        Week
                    </button>
                </div>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div class="p-6">
            <!-- Weekday Labels -->
            <div class="grid grid-cols-7 mb-2">
                <div class="p-3 text-sm font-medium text-gray-500 text-center">Sun</div>
                <div class="p-3 text-sm font-medium text-gray-500 text-center">Mon</div>
                <div class="p-3 text-sm font-medium text-gray-500 text-center">Tue</div>
                <div class="p-3 text-sm font-medium text-gray-500 text-center">Wed</div>
                <div class="p-3 text-sm font-medium text-gray-500 text-center">Thu</div>
                <div class="p-3 text-sm font-medium text-gray-500 text-center">Fri</div>
                <div class="p-3 text-sm font-medium text-gray-500 text-center">Sat</div>
            </div>

            <!-- Calendar Dates -->
            <div id="calendar" class="grid grid-cols-7 border-t border-gray-200">
                <!-- Filled by JS -->
            </div>
        </div>

        <div id="modal" class="fixed inset-0 hidden bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div
                class="bg-white dark:bg-gray-800 p-6 max-h-screen rounded-xl shadow-lg w-full max-w-sm text-gray-800 dark:text-gray-100">
                <h3 class="text-lg font-semibold mb-2" id="modalTitle">Event</h3>
                <p id="modalBody" class="text-gray-700 pr-4 dark:text-gray-300 max-h-[500px] max-w-screen overflow-y-auto"></p>
                <button onclick="closeModal()"
                    class="mt-4 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Close</button>
            </div>
        </div>
        <section class="max-w-7xl mt-6 mx-auto px-6 pb-12">
            <h2 class="text-center font-bold text-lg sm:text-xl mb-2">Events</h2>
            <p class="text-center text-gray-600 text-xs sm:text-sm mb-8 max-w-md mx-auto">
                Stay updated with the latest happenings at Irosin Central School.
            </p>
            <div id="event-loading" class="flex justify-center items-center py-8" style="display: none;">
                <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
            </div>

            <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($events ?? [] as $event)
                    <div id="event-{{ \Carbon\Carbon::parse($event->event_date)->format('Y') }}{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}"
                        class="bg-white hidden rounded-xl p-6 shadow-md border">
                        <div class="flex justify-between items-start mb-4">
                            <div class="bg-[#d9f0e1] rounded-md text-[#2f7a4e] font-semibold text-center w-14">
                                <div class="text-xl leading-none pt-1 font-bold">
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('d') }}
                                </div>
                                <div class="text-sm pb-1">
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('M') }}
                                </div>
                            </div>
                            <div
                                class="bg-[#0b6b2f] text-white text-xs rounded-full px-3 py-1 font-semibold self-start">
                                {{ $event->event_category }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <h3 class="font-bold text-[#0a1f3f] text-lg mb-2">{{ $event->event_name }}</h3>

                            @if($event->event_images && count($event->event_images) > 0)
                                <div class="grid grid-cols-{{ min(count($event->event_images), 3) }} gap-2 mb-3">
                                    @foreach(array_slice($event->event_images, 0, 3) as $image)
                                        <img src="{{ asset('storage/' . $image) }}"
                                             alt="{{ $event->event_name }}"
                                             class="w-full h-20 rounded-lg object-cover border border-gray-200">
                                    @endforeach
                                    @if(count($event->event_images) > 3)
                                        <div class="w-full h-20 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center text-sm text-gray-500">
                                            +{{ count($event->event_images) - 3 }} more
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <div class="text-[#4a5568] mb-4 text-sm leading-relaxed">
                                {!! \Illuminate\Support\Str::markdown($event->event_discription) !!}
                            </div>
                        </div>
                        <div class="flex items-center text-[#6b7280] text-xs space-x-2 mb-1">
                            <i class="far fa-clock"></i>
                            <span>{{ $event->event_time }}{{ $event->event_duration ? ' – ' . $event->event_duration : '' }}</span>
                        </div>
                        <div class="flex items-center text-[#6b7280] text-xs space-x-2">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $event->event_location }}</span>
                        </div>
                    </div>
                @empty
                    <p></p>
                    @livewire('event.not-found')
                    <p></p>
                @endforelse
            </div>
        </section>
        @if ($events != null && count($events) > 0)
            <script>
                window.addEventListener('load', () => {

                    executeAll();
                });

                function executeAll() {

                    let events = @json($events ?? []);
                    // Transform $events for calendar use
                    events = (events ?? []).map(e => {
                        const date = new Date(e.event_date);
                        return {
                            label: `${e.event_name} (${e.event_category}) at ${e.event_location} - ${e.event_time} (${e.event_duration})`,
                            description: e.event_discription,
                            year: date.getFullYear(),
                            month: date.getMonth() + 1,
                            day: date.getDate(),
                            raw: e
                        };
                    });
                    console.log(events);
                    const calendar = document.getElementById("calendar");

                    // Google Calendar style color mapping
                    function getEventColor(category) {
                        const colors = {
                            "Exams & Quizzes": "#ea4335",
                            "Science Fair": "#34a853",
                            "Math Olympiad": "#4285f4",
                            "Spelling Bee": "#fbbc04",
                            "Debate/Essay Contests": "#ea4335",
                            "Parent-Teacher Conferences": "#34a853",
                            "Report Card Distribution": "#4285f4",
                            "Clubs (e.g., Journalism, Robotics)": "#fbbc04",
                            "Student Council Elections": "#ea4335",
                            "Leadership Training": "#34a853",
                            "Educational Field Trips": "#4285f4",
                            "Intramurals": "#fbbc04",
                            "Sports Fest": "#ea4335",
                            "Tryouts and Practice Sessions": "#34a853",
                            "Cheerleading Competitions": "#4285f4",
                            "P.E. Demonstrations": "#fbbc04",
                            "Foundation Day": "#ea4335",
                            "Linggo ng Wika": "#34a853",
                            "Buwan ng Sining": "#4285f4",
                            "Christmas Program": "#fbbc04",
                            "School Play or Musical": "#ea4335",
                            "Art Exhibits": "#34a853",
                            "Cultural Shows": "#4285f4",
                            "Mass or Worship Services": "#fbbc04",
                            "Retreats & Recollections": "#ea4335",
                            "Religious Holidays": "#34a853",
                            "Moral Instruction Sessions": "#4285f4",
                            "Medical/Dental Missions": "#fbbc04",
                            "Mental Health Week": "#ea4335",
                            "Anti-Bullying Campaigns": "#34a853",
                            "Nutrition Month": "#4285f4",
                            "Blood Donation Drives": "#fbbc04",
                            "Tree Planting": "#ea4335",
                            "Community Clean-Up Drives": "#34a853",
                            "Charity Events": "#4285f4",
                            "School Caravan": "#fbbc04",
                            "Brigada Eskwela": "#ea4335",
                            "General Assembly": "#34a853",
                            "Faculty Development": "#4285f4",
                            "Student/Parent Orientation": "#fbbc04",
                            "Enrollment Days": "#ea4335",
                            "Accreditation Visits": "#34a853",
                            "Awarding Ceremonies": "#4285f4",
                            "Recognition Day": "#fbbc04",
                            "Graduation/Moving-Up": "#ea4335",
                            "Inter-School Competitions": "#34a853",
                            "Other": "#4285f4"
                        };
                        return colors[category] || "#4285f4";
                    }
                    const monthYear = document.getElementById("monthYear");
                    const prev = document.getElementById("prev");
                    const next = document.getElementById("next");

                    const modal = document.getElementById("modal");
                    const modalTitle = document.getElementById("modalTitle");
                    const modalBody = document.getElementById("modalBody");

                    const toggleTheme = document.getElementById("toggleTheme");
                    const html = document.documentElement;

                    let currentDate = new Date();
                    const C_id =
                        `event-${currentDate.getFullYear()}${currentDate.toLocaleString('default', { month: 'short' })}`;
                    const cards = document.querySelectorAll(`#${C_id}`);
                    cards.forEach(card => {
                        card.classList.remove('hidden');
                    });

                    function openModal(title, body) {
                        modalTitle.textContent = title;
                        modalBody.innerHTML = body;
                        modal.classList.remove("hidden");
                    }

                    window.closeModal = function() {
                        modal.classList.add("hidden");
                    };

                    function renderCalendar(date) {
                        calendar.innerHTML = "";
                        const year = date.getFullYear();
                        const month = date.getMonth();

                        const firstDay = new Date(year, month, 1);
                        const lastDay = new Date(year, month + 1, 0);
                        const startDay = firstDay.getDay();
                        const totalDays = lastDay.getDate();
                        // Count events per day for the current month/year
                        const eventCountByDay = {};
                        events.forEach(e => {
                            if (e.year === year && e.month - 1 === month) {
                                eventCountByDay[e.day] = (eventCountByDay[e.day] || 0) + 1;
                            }
                        });
                        const today = new Date();
                        today.setHours(0, 0, 0, 0);
                        const isCurrentMonth = today.getFullYear() === year && today.getMonth() === month;

                        monthYear.textContent = date.toLocaleString("default", {
                            month: "long",
                            year: "numeric",
                        });

                        for (let i = 0; i < startDay; i++) {
                            calendar.innerHTML += `<div></div>`;
                        }

                        for (let i = 1; i <= totalDays; i++) {
                            const hasEvent = events.find(e => e.day === i && e.month - 1 === month && e.year === year);
                            const isToday = isCurrentMonth && i === today.getDate();

                            const count = events.filter(e => e.day === i && e.month - 1 === month && e.year === year).length;
                            if (hasEvent) {
                                console.log(`Day ${i}: ${count} event(s)`);
                            }
                            const div = document.createElement("div");
                            div.className = `min-h-[120px] p-2 border-r border-b border-gray-200 hover:bg-gray-50 transition-colors relative ${
                                isToday ? 'bg-blue-50' : ''
                            }`;

                            // Date number
                            const dateDiv = document.createElement("div");
                            dateDiv.className = `text-sm font-medium mb-1 ${
                                isToday ? 'text-blue-600 font-semibold' : 'text-gray-900'
                            }`;
                            dateDiv.textContent = i;
                            div.appendChild(dateDiv);

                            // Add event indicators (Google Calendar style)
                            if (hasEvent) {
                                const dayEvents = events.filter(e => e.day === i && e.month - 1 === month && e.year === year);

                                // Show up to 3 event indicators
                                const eventsToShow = dayEvents.slice(0, 3);
                                eventsToShow.forEach((event, index) => {
                                    const eventDiv = document.createElement("div");
                                    eventDiv.className = "text-xs p-1 mb-1 rounded text-white truncate";
                                    eventDiv.style.backgroundColor = getEventColor(event.raw.event_category);
                                    eventDiv.textContent = event.raw.event_name;
                                    eventDiv.title = event.raw.event_name;
                                    div.appendChild(eventDiv);
                                });

                                // If more events, show "+N more"
                                if (dayEvents.length > 3) {
                                    const moreDiv = document.createElement("div");
                                    moreDiv.className = "text-xs text-gray-500 mt-1";
                                    moreDiv.textContent = `+${dayEvents.length - 3} more`;
                                    div.appendChild(moreDiv);
                                }
                            }

                            if (hasEvent) {
                                div.classList.add("font-semibold", "text-green-900", "dark:text-green-200");
                                // div.addEventListener("click", () => {
                                //     openModal("Event Details", hasEvent.label);
                                // });
                                const badge = document.createElement("span");
                                badge.className =
                                    "absolute top-[-3px] right-[-3px] sm:text-[12px]  sm:top-[-10px] sm:right-[-10px]  bg-green-500 text-white text-xs font-bold px-2 py-0.5 rounded-full";
                                badge.textContent = count;
                                div.appendChild(badge);

                                div.addEventListener("click", () => {
                                    // Show all events for this day in the modal
                                    const dayEvents = events.filter(e => e.day === i && e.month - 1 === month && e.year ===
                                        year);
                                    const title =
                                        `Events on ${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                                    const body = dayEvents.map(e =>
                                        `<div class="mb-4 bg-white rounded-lg shadow p-4 border border-gray-200 text-left">
                                        <div class="mb-3">
                                            <strong class="block text-base text-gray-900 mb-2">${e.raw.event_name}</strong>

                                            ${e.raw.event_images && e.raw.event_images.length > 0 ? `
                                                <div class="grid grid-cols-${Math.min(e.raw.event_images.length, 3)} gap-2 mb-3">
                                                    ${e.raw.event_images.slice(0, 3).map(img =>
                                                        `<img src="/storage/${img}" alt="${e.raw.event_name}" class="w-full h-16 rounded object-cover border border-gray-200">`
                                                    ).join('')}
                                                    ${e.raw.event_images.length > 3 ? `<div class="w-full h-16 rounded bg-gray-100 border border-gray-200 flex items-center justify-center text-sm text-gray-500">+${e.raw.event_images.length - 3} more</div>` : ''}
                                                </div>
                                            ` : ''}

                                            <div class="text-sm text-gray-600">
                                                <span class="block text-xs text-gray-500 mb-1">${e.raw.event_category} &mdash; ${e.raw.event_location}</span>
                                                <span class="block text-xs text-gray-500 mb-2">${e.raw.event_date} | ${e.raw.event_time}${e.raw.event_duration ? ' – ' + e.raw.event_duration : ''}</span>
                                                <p class="text-sm text-gray-700">${e.raw.event_discription.replace(/\n/g, '<br>')}</p>
                                            </div>
                                        </div>
                                    </div>`
                                    ).join('');
                                    openModal(title, body);
                                });
                                const dot = document.createElement("span");
                                dot.className =
                                    "absolute bottom-1 left-1/2 transform -translate-x-1/2 h-1.5 w-1.5 rounded hover:bg-green-400 bg-green-500";
                                div.appendChild(dot);
                            }

                            calendar.appendChild(div);
                        }
                    }

                    function renderEventList() {
                        const list = document.getElementById("eventList");
                        list.innerHTML = "<h3 class='text-lg font-semibold mb-2'>All Events</h3>";

                        const today = new Date();
                        today.setHours(0, 0, 0, 0);

                        const sortedEvents = [...events].sort((a, b) => {
                            const da = new Date(a.year, a.month - 1, a.day);
                            const db = new Date(b.year, b.month - 1, b.day);
                            return da - db;
                        });

                        sortedEvents.forEach(event => {
                            const eventDate = new Date(event.year, event.month - 1, event.day);
                            const isPast = eventDate < today;

                            const div = document.createElement("div");
                            div.className = `p-4 rounded-lg shadow text-sm transition ${
                    isPast
                        ? "bg-red-100 dark:bg-red-800 border border-red-300 dark:border-red-600 text-red-800 dark:text-red-200"
                        : "bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-600 text-green-800 dark:text-green-200"
                }`;

                            div.innerHTML = `
                    <div><strong>${event.label}</strong></div>
                    <div>${eventDate.toDateString()}</div>
                `;

                            list.appendChild(div);
                        });
                    }

                    // Navigation
                    prev.addEventListener("click", () => {
                        const C_id1 =
                            `event-${currentDate.getFullYear()}${currentDate.toLocaleString('default', { month: 'short' })}`;
                        const cards = document.querySelectorAll(`#${C_id1}`);
                        cards.forEach(card => {
                            card.classList.add('hidden');
                        });
                        currentDate.setMonth(currentDate.getMonth() - 1);
                        const C_id2 =
                            `event-${currentDate.getFullYear()}${currentDate.toLocaleString('default', { month: 'short' })}`;
                        const cards2 = document.querySelectorAll(`#${C_id2}`);
                        cards2.forEach(card => {
                            card.classList.remove('hidden');
                        });
                        renderCalendar(currentDate);
                    });

                    next.addEventListener("click", () => {
                        const C_id1 =
                            `event-${currentDate.getFullYear()}${currentDate.toLocaleString('default', { month: 'short' })}`;
                        // Example: Select event cards by id for the current date (if needed)
                        const cards = document.querySelectorAll(`#${C_id1}`);
                        cards.forEach(card => {
                            card.classList.add('hidden');
                        });
                        currentDate.setMonth(currentDate.getMonth() + 1);
                        const C_id2 =
                            `event-${currentDate.getFullYear()}${currentDate.toLocaleString('default', { month: 'short' })}`;
                        const cards2 = document.querySelectorAll(`#${C_id2}`);
                        cards2.forEach(card => {
                            card.classList.remove('hidden');
                        });
                        renderCalendar(currentDate);
                    });

                    renderCalendar(currentDate);
                }
            </script>
        @else
            <script>
                window.addEventListener('load', () => {
                    setupCalendar();
                });

                function setupCalendar() {
                    const calendar = document.getElementById("calendar");
                    const monthYear = document.getElementById("monthYear");
                    const prev = document.getElementById("prev");
                    const next = document.getElementById("next");

                    let currentDate = new Date();

                    function renderCalendar(date) {
                        calendar.innerHTML = "";
                        const year = date.getFullYear();
                        const month = date.getMonth();

                        const firstDay = new Date(year, month, 1).getDay();
                        const totalDays = new Date(year, month + 1, 0).getDate();

                        monthYear.textContent = date.toLocaleString("default", {
                            month: "long",
                            year: "numeric",
                        });

                        // Empty cells for alignment
                        for (let i = 0; i < firstDay; i++) {
                            calendar.innerHTML += `<div></div>`;
                        }

                        // Day cells
                        for (let i = 1; i <= totalDays; i++) {
                            const div = document.createElement("div");
                            div.className = "p-2 rounded-lg text-center border hover:bg-gray-200 transition";
                            div.textContent = i;
                            calendar.appendChild(div);
                        }
                    }

                    prev.addEventListener("click", () => {
                        currentDate.setMonth(currentDate.getMonth() - 1);
                        renderCalendar(currentDate);
                    });

                    next.addEventListener("click", () => {
                        currentDate.setMonth(currentDate.getMonth() + 1);
                        renderCalendar(currentDate);
                    });

                    renderCalendar(currentDate);
                }
            </script>
        @endif
    </div>
</div>
