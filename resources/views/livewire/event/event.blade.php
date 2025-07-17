<div>
    <div
        class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen flex flex-col items-center justify-start p-4 transition">
        <div class="w-full max-w-4xl bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 relative transition">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <button id="prev"
                    class="text-gray-500 dark:text-gray-300 hover:text-black dark:hover:text-white text-2xl">&larr;</button>
                <h2 id="monthYear" class="text-xl font-semibold">April 2025</h2>
                <button id="next"
                    class="text-gray-500 dark:text-gray-300 hover:text-black dark:hover:text-white text-2xl">&rarr;</button>
            </div>

            <!-- Weekday Labels -->
            <div class="grid grid-cols-7 text-center text-gray-500 dark:text-gray-400 mb-2 font-medium">
                <div>Sun</div>
                <div>Mon</div>
                <div>Tue</div>
                <div>Wed</div>
                <div>Thu</div>
                <div>Fri</div>
                <div>Sat</div>
            </div>

            <!-- Calendar Dates -->
            <div id="calendar" class="grid grid-cols-7 gap-2 text-center text-sm">
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
                        <h3 class="font-bold text-[#0a1f3f] text-lg mb-1">{{ $event->event_name }}</h3>
                        <div class="text-[#4a5568] mb-4 text-sm leading-relaxed">
                            {!! \Illuminate\Support\Str::markdown($event->event_discription) !!}
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
                            div.className =
                                `p-2 rounded-lg border cursor-pointer relative transition ${
                        isToday ? "bg-green-500 text-white font-bold animate-pulse" : "hover:bg-gray-200 dark:hover:bg-gray-700"
                    } ${hasEvent ? "bg-yellow-100 dark:bg-yellow-800 border border-yellow-400 dark:border-yellow-600" : ""}`;

                            div.textContent = i;

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
                                        `<div class="mb-4 bg-white dark:bg-gray-800 rounded-lg shadow p-4 border border-gray-200 dark:border-gray-700 text-left">
                                        <strong class="block text-base text-[#0a1f3f] mb-1">${e.raw.event_name}</strong>
                                        <span class="block text-xs text-gray-500 mb-1">${e.raw.event_category} &mdash; ${e.raw.event_location}</span>
                                        <span class="block text-xs text-gray-500 mb-1">${e.raw.event_date} | ${e.raw.event_time}${e.raw.event_duration ? ' – ' + e.raw.event_duration : ''}</span>
                                        <p class="text-sm mt-1 text-[#4a5568]">{!! \Illuminate\Support\Str::markdown($event->event_discription) !!}</p>
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
