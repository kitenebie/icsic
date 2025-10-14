<div>
    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
        <!-- Enhanced Header -->
        <div class="bg-white shadow-lg">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900">School Calendar</h1>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button id="prev" class="p-2 hover:bg-blue-50 rounded-full transition-colors duration-200">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button id="next" class="p-2 hover:bg-blue-50 rounded-full transition-colors duration-200">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                        <h2 id="monthYear" class="text-xl font-semibold text-gray-900 ml-4">April 2025</h2>
                    </div>

                    <!-- Month/Year Selector -->
                    <div class="relative">
                        <button id="monthYearSelector"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 flex items-center space-x-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span id="selectorDisplay">Select Month & Year</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Panel -->
                        <div id="monthYearDropdown"
                            class="absolute top-full left-0 mt-2 w-80 bg-white border border-gray-200 rounded-lg shadow-lg z-50 hidden">
                            <!-- Header with Year Navigation -->
                            <div class="p-4 border-b border-gray-200">
                                <div class="flex items-center justify-between mb-4">
                                    <button id="yearDown"
                                        class="p-1 hover:bg-gray-100 rounded-full transition-colors duration-200">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <h3 id="dropdownYear" class="text-lg font-semibold text-gray-900">2025</h3>
                                    <button id="yearUp"
                                        class="p-1 hover:bg-gray-100 rounded-full transition-colors duration-200">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="text-sm text-gray-600 text-center">
                                    Click on a month to navigate
                                </div>
                            </div>

                            <!-- Month Grid -->
                            <div class="p-4">
                                <div class="grid grid-cols-3 gap-2" id="monthGrid">
                                    <!-- Months will be populated by JavaScript -->
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="p-3 border-t border-gray-200 bg-gray-50 rounded-b-lg">
                                <button id="currentMonthBtn"
                                    class="w-full py-2 px-4 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors duration-200">
                                    Go to Current Month
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    {{-- <button class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                        Today
                    </button>
                    <div class="flex rounded-lg shadow-sm border border-gray-200">
                        <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-l-lg hover:bg-blue-700 transition-colors duration-200">
                            Month
                        </button>
                        <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border-l border-gray-200 rounded-r-lg hover:bg-gray-50 transition-colors duration-200">
                            Week
                        </button>
                    </div> --}}
                </div>
            </div>
        </div>

        <!-- Enhanced Calendar Grid -->
        <div class="p-6">
            <!-- Weekday Labels -->
            <div class="grid grid-cols-7 mb-4">
                <div class="p-4 text-sm font-semibold text-gray-600 text-center bg-gray-50 rounded-t-lg">Sunday</div>
                <div class="p-4 text-sm font-semibold text-gray-600 text-center bg-gray-50 rounded-t-lg">Monday</div>
                <div class="p-4 text-sm font-semibold text-gray-600 text-center bg-gray-50 rounded-t-lg">Tuesday</div>
                <div class="p-4 text-sm font-semibold text-gray-600 text-center bg-gray-50 rounded-t-lg">Wednesday</div>
                <div class="p-4 text-sm font-semibold text-gray-600 text-center bg-gray-50 rounded-t-lg">Thursday</div>
                <div class="p-4 text-sm font-semibold text-gray-600 text-center bg-gray-50 rounded-t-lg">Friday</div>
                <div class="p-4 text-sm font-semibold text-gray-600 text-center bg-gray-50 rounded-t-lg">Saturday</div>
            </div>

            <!-- Calendar Dates -->
            <div id="calendar"
                class="grid grid-cols-7 bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <!-- Filled by JS -->
            </div>
        </div>

        <div id="modal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center p-4"
            style="z-index: 99999;">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900" id="modalTitle">Event Details</h3>
                    </div>
                    <button onclick="closeModal()"
                        class="p-2 hover:bg-gray-100 rounded-full transition-colors duration-200">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 max-h-[calc(90vh-140px)] overflow-y-auto">
                    <div id="modalBody" class="space-y-4">
                        <!-- Content will be populated by JavaScript -->
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end p-6 border-t border-gray-200 bg-gray-50">
                    <button onclick="closeModal()"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium">
                        Close
                    </button>
                </div>
            </div>
        </div>

        <!-- Facebook-style Image Preview Modal -->
        <div id="imagePreviewModal"
            class="fixed inset-0 hidden bg-black bg-opacity-90 flex items-center justify-center"
            style="z-index: 99999;">
            <div class="relative max-w-4xl max-h-screen p-4">
                <!-- Close button -->
                <button onclick="closeImagePreview()"
                    class="absolute top-4 right-4 z-10 bg-black bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-70 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Previous button -->
                <button id="prevImageBtn" onclick="changeImage(-1)"
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 z-10 bg-black bg-opacity-50 text-white rounded-full p-3 hover:bg-opacity-70 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button>

                <!-- Next button -->
                <button id="nextImageBtn" onclick="changeImage(1)"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 z-10 bg-black bg-opacity-50 text-white rounded-full p-3 hover:bg-opacity-70 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                        </path>
                    </svg>
                </button>

                <!-- Main image -->
                <img id="previewImage" src="" alt=""
                    class="max-w-full max-h-full object-contain rounded-lg">

                <!-- Image counter -->
                <div
                    class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-50 text-white px-3 py-1 rounded-full text-sm">
                    <span id="currentImageIndex">1</span> / <span id="totalImages">1</span>
                </div>

                <!-- Thumbnails -->
                <div id="imageThumbnails"
                    class="absolute bottom-16 left-1/2 transform -translate-x-1/2 flex space-x-2 max-w-full overflow-x-auto">
                    <!-- Thumbnails will be populated by JavaScript -->
                </div>
            </div>
        </div>
        <section class="max-w-7xl mt-8 mx-auto px-6 pb-12">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Upcoming Events</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Stay updated with the latest happenings at Irosin Central School.
                </p>
            </div>
            <div id="event-loading" class="flex justify-center items-center py-12" style="display: none;">
                <div class="flex items-center space-x-3">
                    <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span class="text-gray-600">Loading events...</span>
                </div>
            </div>

            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse ($events ?? [] as $event)
                    <div id="event-{{ \Carbon\Carbon::parse($event->event_date)->format('Y') }}{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}"
                        class="bg-white hidden rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden group cursor-pointer">
                        <!-- Event Images Gallery -->
                        @if ($event->event_images && count($event->event_images) > 0)
                            <div class="relative h-48 overflow-hidden">
                                <div
                                    class="grid {{ count($event->event_images) === 1 ? 'grid-cols-1' : (count($event->event_images) === 2 ? 'grid-cols-2' : 'grid-cols-2 grid-rows-2') }} h-full">
                                    @foreach (array_slice($event->event_images, 0, 4) as $index => $image)
                                        <div
                                            class="relative overflow-hidden {{ $index === 0 && count($event->event_images) > 1 ? 'row-span-2' : '' }}">
                                            <img src="{{ asset('storage/' . $image) }}" alt="{{ $event->event_name }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 image-preview-trigger"
                                                data-images="{{ json_encode($event->event_images) }}"
                                                data-current="{{ $index }}"
                                                data-title="{{ $event->event_name }}">
                                            @if ($index === 3 && count($event->event_images) > 4)
                                                <div
                                                    class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                                    <span
                                                        class="text-white font-bold text-lg">+{{ count($event->event_images) - 4 }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <div class="absolute top-3 left-3">
                                    <div class="bg-white bg-opacity-90 backdrop-blur-sm rounded-lg px-3 py-1">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('M j') }}
                                        </div>
                                        <div class="text-xs text-gray-700">
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('Y') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute top-3 right-3">
                                    <div class="bg-blue-600 text-white text-xs rounded-full px-3 py-1 font-semibold">
                                        {{ $event->event_category }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- No images fallback -->
                            <div
                                class="h-32 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                                <div class="text-center text-white">
                                    <div class="text-2xl font-bold mb-1">
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('d') }}
                                    </div>
                                    <div class="text-sm opacity-90">
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('M') }}
                                    </div>
                                    <div class="text-xs opacity-75">
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('Y') }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Event Content -->
                        <div class="p-6">
                            <h3
                                class="font-bold text-gray-900 text-xl mb-2 group-hover:text-blue-600 transition-colors">
                                {{ $event->event_name }}
                            </h3>
                            <div class="text-gray-600 mb-4 text-sm leading-relaxed line-clamp-3">
                                {!! \Illuminate\Support\Str::markdown($event->event_discription) !!}
                            </div>

                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}{{ $event->event_duration ? ' – ' . (preg_match('/^\d{2}:\d{2}:\d{2}$/', $event->event_duration) ? \Carbon\Carbon::parse($event->event_duration)->format('g:i A') : $event->event_duration) : '' }}</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>{{ $event->event_location }}</span>
                                    </div>
                                </div>
                            </div>
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

                window.executeAll = function() {

                    window.events = @json($events ?? []);
                    // Transform $events for calendar use
                    events = (events ?? []).map(e => {
                        const date = new Date(e.event_date);
                        const endDate = e.event_end ? new Date(e.event_end) : date;
                        return {
                            label: `${e.event_name} (${e.event_category}) at ${e.event_location} - ${new Date(e.event_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })} ${e.event_time} (${e.event_duration})`,
                            description: e.event_discription,
                            year: date.getFullYear(),
                            month: date.getMonth() + 1,
                            day: date.getDate(),
                            endYear: endDate.getFullYear(),
                            endMonth: endDate.getMonth() + 1,
                            endDay: endDate.getDate(),
                            isMultiDay: e.event_end && e.event_date !== e.event_end,
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

                    window.currentDate = new Date();
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

                    // Image Preview Modal Functions
                    let currentImages = [];
                    let currentImageIndex = 0;

                    window.openImagePreview = function(images, startIndex = 0) {
                        currentImages = images;
                        currentImageIndex = startIndex;
                        updateImagePreview();
                        document.getElementById('imagePreviewModal').classList.remove('hidden');
                    };

                    window.closeImagePreview = function() {
                        document.getElementById('imagePreviewModal').classList.add('hidden');
                    };

                    window.changeImage = function(direction) {
                        currentImageIndex = (currentImageIndex + direction + currentImages.length) % currentImages.length;
                        updateImagePreview();
                    };

                    function updateImagePreview() {
                        const previewImage = document.getElementById('previewImage');
                        const currentIndex = document.getElementById('currentImageIndex');
                        const totalImages = document.getElementById('totalImages');
                        const thumbnails = document.getElementById('imageThumbnails');
                        const prevBtn = document.getElementById('prevImageBtn');
                        const nextBtn = document.getElementById('nextImageBtn');

                        previewImage.src = `/storage/${currentImages[currentImageIndex]}`;
                        currentIndex.textContent = currentImageIndex + 1;
                        totalImages.textContent = currentImages.length;

                        // Update navigation buttons
                        prevBtn.style.display = currentImages.length > 1 ? 'block' : 'none';
                        nextBtn.style.display = currentImages.length > 1 ? 'block' : 'none';

                        // Update thumbnails
                        thumbnails.innerHTML = '';
                        currentImages.forEach((image, index) => {
                            const thumb = document.createElement('img');
                            thumb.src = `/storage/${image}`;
                            thumb.className = `w-12 h-12 rounded object-cover cursor-pointer border-2 ${
                                index === currentImageIndex ? 'border-blue-500' : 'border-gray-300'
                            }`;
                            thumb.onclick = () => {
                                currentImageIndex = index;
                                updateImagePreview();
                            };
                            thumbnails.appendChild(thumb);
                        });
                    }

                    // Add click handlers for image preview triggers
                    document.addEventListener('click', function(e) {
                        if (e.target.classList.contains('image-preview-trigger')) {
                            const images = JSON.parse(e.target.dataset.images);
                            const currentIndex = parseInt(e.target.dataset.current);
                            openImagePreview(images, currentIndex);
                        }
                    });

                    // Keyboard navigation for image preview
                    document.addEventListener('keydown', function(e) {
                        if (document.getElementById('imagePreviewModal').classList.contains('hidden')) return;

                        if (e.key === 'ArrowLeft') {
                            changeImage(-1);
                        } else if (e.key === 'ArrowRight') {
                            changeImage(1);
                        } else if (e.key === 'Escape') {
                            closeImagePreview();
                        }
                    });

                    function renderCalendar(date) {
                        alert(date);
                        calendar.innerHTML = "";
                        const year = date.getFullYear();
                        const month = date.getMonth();

                        const firstDay = new Date(year, month, 1);
                        const lastDay = new Date(year, month + 1, 0);
                        const startDay = firstDay.getDay();
                        const totalDays = lastDay.getDate();
                        // Count events per day for the current month/year (including multi-day events)
                        const eventCountByDay = {};
                        const multiDayEvents = [];
                        events.forEach(e => {
                            if (e.year === year && e.month - 1 === month) {
                                eventCountByDay[e.day] = (eventCountByDay[e.day] || 0) + 1;
                            }
                            // Track multi-day events that start in this month
                            if (e.isMultiDay && e.year === year && e.month - 1 === month) {
                                multiDayEvents.push(e);
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
                            div.className = `min-h-[140px] p-4 border-r border-b border-gray-200 hover:bg-blue-50 hover:shadow-md transition-all duration-200 relative ${
                                isToday ? 'bg-blue-100 shadow-inner' : 'bg-white'
                            }`;

                            // Date number
                            const dateDiv = document.createElement("div");
                            dateDiv.className = `text-lg font-bold mb-2 ${
                                isToday ? 'text-blue-700' : 'text-gray-900'
                            }`;
                            dateDiv.textContent = i;
                            div.appendChild(dateDiv);

                            // Today indicator
                            if (isToday) {
                                const todayBadge = document.createElement("div");
                                todayBadge.className = "absolute top-2 right-2 w-2 h-2 bg-blue-600 rounded-full";
                                div.appendChild(todayBadge);
                            }

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
                                    "absolute top-[-3px] right-[-3px] sm:text-[12px]  sm:top-[-10px] sm:right-[-10px]  bg-green-500 text-white text-xs font-bold px-2 py-0.5 rounded-full z-[30]";
                                badge.textContent = count;
                                div.appendChild(badge);

                                div.addEventListener("click", () => {
                                    // Show all events for this day in the modal
                                    const dayEvents = events.filter(e => e.day === i && e.month - 1 === month && e
                                        .year ===
                                        year);
                                    const eventDate = new Date(year, month, i);
                                    const title = dayEvents.length === 1 && dayEvents[0].raw.event_end && dayEvents[0]
                                        .raw.event_end !== dayEvents[0].raw.event_date ?
                                        `Events from ${eventDate.toLocaleDateString('en-US', { month: 'long', day: 'numeric' })} to ${new Date(dayEvents[0].raw.event_end).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}` :
                                        `Events on ${eventDate.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}`;
                                    const body = dayEvents.map(e => `
                                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                                            <div class="flex items-start space-x-4">
                                                <!-- Event Image -->
                                                <div class="flex-shrink-0">
                                                    ${e.raw.event_images && e.raw.event_images.length > 0 ? `
                                                                                <img src="/storage/${e.raw.event_images[0]}" alt="${e.raw.event_name}" class="w-16 h-16 rounded-lg object-cover border-2 border-white shadow-sm">
                                                                            ` : `
                                                                                <div class="w-16 h-16 bg-gradient-to-r from-blue-400 to-purple-500 rounded-lg flex items-center justify-center">
                                                                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                                                    </svg>
                                                                                </div>
                                                                            `}
                                                </div>

                                                <!-- Event Details -->
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="text-lg font-bold text-gray-900 mb-2">${e.raw.event_name}</h4>

                                                    <div class="flex items-center space-x-4 mb-3">
                                                        <div class="flex items-center space-x-1 text-sm text-gray-600">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                            </svg>
                                                            <span>${e.raw.event_category}</span>
                                                        </div>
                                                        <div class="flex items-center space-x-1 text-sm text-gray-600">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            </svg>
                                                            <span>${e.raw.event_location}</span>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center space-x-1 text-sm text-gray-600 mb-3">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        <span>${new Date(e.raw.event_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })} to ${new Date(e.raw.event_end).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })} ${e.raw.event_duration ? ' – ' + e.raw.event_duration : ''}</span>
                                                    </div>

                                                    <div class="text-sm text-gray-700 leading-relaxed">
                                                        ${e.raw.event_discription.replace(/\n/g, '<br>')}
                                                    </div>

                                                    ${e.raw.event_images && e.raw.event_images.length > 1 ? `
                                                                                <div class="mt-4 pt-4 border-t border-gray-200">
                                                                                    <div class="flex items-center space-x-2">
                                                                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                                                        </svg>
                                                                                        <span class="text-sm text-gray-600">${e.raw.event_images.length} photos</span>
                                                                                    </div>
                                                                                </div>
                                                                            ` : ''}
                                                </div>
                                            </div>
                                        </div>
                                    `).join('');
                                    openModal(title, body);
                                });
                                const dot = document.createElement("span");
                                dot.className =
                                    "absolute bottom-1 left-1/2 transform -translate-x-1/2 h-1.5 w-1.5 rounded hover:bg-green-400 bg-green-500";
                                div.appendChild(dot);
                            }

                            calendar.appendChild(div);
                        }

                        // Multi-day event spanning bars overlaying cells
                        const processedEvents = [];
                        // Track used heights for each cell to stack multiple events vertically
                        const cellHeights = new Map();

                        // Group events by cell position for width calculation
                        const eventsByCell = new Map();

                        // First pass: Group all multi-day events by their cell positions
                        events.forEach(event => {
                            if (processedEvents.includes(event.raw.id)) return;
                            if (!event.isMultiDay) return;

                            const eventStartDate = new Date(event.year, event.month - 1, event.day);
                            const eventEndDate = new Date(event.endYear, event.endMonth - 1, event.endDay);

                            // Check if this event overlaps with current month
                            const monthStart = new Date(year, month, 1);
                            const monthEnd = new Date(year, month + 1, 0);
                            const eventOverlapsMonth = eventStartDate <= monthEnd && eventEndDate >= monthStart;

                            if (!eventOverlapsMonth) return;

                            // Calculate the actual date range for this month
                            const actualStartDate = eventStartDate > monthStart ? eventStartDate : monthStart;
                            const actualEndDate = eventEndDate < monthEnd ? eventEndDate : monthEnd;

                            // Calculate grid positions for the actual date range
                            const startDayNum = actualStartDate.getDate();
                            const endDayNum = actualEndDate.getDate();

                            // Calculate position in calendar grid
                            const gridStartPos = startDay + (startDayNum - 1);
                            const gridEndPos = startDay + (endDayNum - 1);

                            // Create span for each row the event occupies in current month
                            let currentGridPos = gridStartPos;
                            let currentDate = new Date(actualStartDate);

                            while (currentGridPos <= gridEndPos && currentDate <= actualEndDate) {
                                if (!eventsByCell.has(currentGridPos)) {
                                    eventsByCell.set(currentGridPos, []);
                                }
                                eventsByCell.get(currentGridPos).push({
                                    event: event,
                                    currentGridPos: currentGridPos,
                                    actualEndDate: actualEndDate,
                                    eventStartDate: eventStartDate,
                                    eventEndDate: eventEndDate
                                });

                                // Move to next position
                                const dayOfWeek = currentGridPos % 7;
                                const remainingDaysInRow = 7 - dayOfWeek;
                                const remainingDaysInEvent = Math.ceil((actualEndDate - currentDate) / (1000 * 60 * 60 *
                                    24)) + 1;
                                const daysInThisRow = Math.min(remainingDaysInRow, remainingDaysInEvent);

                                currentGridPos += daysInThisRow;
                                currentDate.setDate(currentDate.getDate() + daysInThisRow);
                            }

                            processedEvents.push(event.raw.id);
                        });

                        // Create span bars for each event with their exact width
                        eventsByCell.forEach((cellEvents, cellIndex) => {
                            if (cellEvents.length === 0) return;

                            // Create span bars for all events in this cell with their individual widths
                            cellEvents.forEach(cellEvent => {
                                const cellElements = calendar.children;
                                if (cellEvent.currentGridPos >= cellElements.length) return;

                                const cellElement = cellElements[cellEvent.currentGridPos];
                                if (getComputedStyle(cellElement).position === 'static') {
                                    cellElement.style.position = 'relative';
                                }

                                // Calculate the exact width for this specific event
                                const dayOfWeek = cellEvent.currentGridPos % 7;
                                const remainingDaysInRow = 7 - dayOfWeek;
                                const remainingDaysInEvent = Math.ceil((cellEvent.actualEndDate - new Date(year,
                                    month, cellEvent.currentGridPos - startDay + 1)) / (1000 * 60 * 60 *
                                    24)) + 1;
                                const eventSpanWidth = Math.min(remainingDaysInRow, remainingDaysInEvent);

                                // Get current height for this cell, or initialize to base height
                                const currentHeight = cellHeights.get(cellEvent.currentGridPos) || 42;
                                // Increment height for next span bar in this cell
                                cellHeights.set(cellEvent.currentGridPos, currentHeight + 32);

                                // Multi-day event spanning bar overlaying cells
                                const spanBar = document.createElement('div');
                                const eventColor = getEventColor(cellEvent.event.raw.event_category);
                                spanBar.className = "dark:text-blue-200 dark:shadow-lg dark:shadow-blue-900/20";
                                spanBar.style.cssText = `
                                    z-index: 30;
                                    background: ${eventColor};
                                    color: white;
                                    font-size: 13px;
                                    padding: 4px 8px;
                                    border-radius: 6px;
                                    font-weight: 600;
                                    border: 2px solid rgba(255, 255, 255, 0.3);
                                    position: absolute;
                                    top: ${currentHeight + 2}px;
                                    left: -8px;
                                    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.3);
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                    white-space: nowrap;
                                    margin-bottom: 2px;
                                `;
                                spanBar.style.width =
                                    `calc(${eventSpanWidth} * 100% + ${(eventSpanWidth - 1) * 2}px)`;

                                const totalDaysThisEvent = Math.ceil((cellEvent.eventEndDate - cellEvent
                                    .eventStartDate) / (1000 * 60 * 60 * 24)) + 1;
                                spanBar.title =
                                    `${cellEvent.event.raw.event_name} (${cellEvent.event.day}/${cellEvent.event.month}/${cellEvent.event.year} - ${cellEvent.event.endDay}/${cellEvent.event.endMonth}/${cellEvent.event.endYear}, ${totalDaysThisEvent} days)`;
                                spanBar.textContent =
                                    `${cellEvent.event.raw.event_name} (${totalDaysThisEvent} days)`;

                                // Append the overlay inside the cell
                                cellElement.appendChild(spanBar);

                                // Spacer for single-day events under the bar
                                const spacer = document.createElement('div');
                                spacer.style.height = '32px';
                                cellElement.appendChild(spacer);
                            });
                        });
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

                window.setupCalendar = function() {
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

                let currentYear = new Date().getFullYear();
                let currentMonth = new Date().getMonth();

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
                        monthButton.className = `p-3 text-sm font-medium rounded-lg transition-colors duration-200 ${
                            index === currentMonth
                                ? 'bg-blue-600 text-white'
                                : 'bg-gray-50 text-gray-700 hover:bg-gray-100'
                        }`;
                        monthButton.textContent = month.substring(0, 3); // Show abbreviated month names
                        monthButton.addEventListener('click', function() {
                            alert(`You clicked on ${months[index]} (${currentYear})`);
                            currentMonth = index;
                            updateSelectorDisplay();
                            monthYearDropdown.classList.add('hidden');
                            // Update the main calendar
                            const NewDate = new Date(currentYear, months[index], 1);
                            updateMainCalendar();
                            renderCalendar(NewDate);
                        });
                        monthGrid.appendChild(monthButton);
                    });
                }

                // Update main calendar (integrate with existing calendar logic)
                function updateMainCalendar() {
                    const newDate = new Date(currentYear, currentMonth, 1);

                    // Update the main month/year display
                    if (monthYear) {
                        monthYear.textContent = newDate.toLocaleString('default', {
                            month: 'long',
                            year: 'numeric'
                        });
                    }

                    // Update event cards visibility if they exist
                    updateEventCardsVisibility(newDate);

                    // Close the dropdown after selection
                    monthYearDropdown.classList.add('hidden');

                    // Re-render the calendar if events exist
                    if (window.events && window.events.length > 0) {
                        // Re-run the entire calendar setup with new date
                        if (typeof executeAll === 'function') {
                            // Temporarily modify currentDate and re-run
                            const originalCurrentDate = window.currentDate;
                            window.currentDate = newDate;
                            executeAll();
                            // Restore original date after execution
                            if (originalCurrentDate) {
                                window.currentDate = originalCurrentDate;
                            }
                        }
                    } else {
                        // Fallback for when no events exist - use the basic calendar
                        if (typeof setupCalendar === 'function') {
                            setupCalendar();
                        }
                    }
                }

                // Update event cards visibility based on selected month/year
                function updateEventCardsVisibility(selectedDate) {
                    const selectedYear = selectedDate.getFullYear();
                    const selectedMonth = selectedDate.toLocaleString('default', {
                        month: 'short'
                    });

                    // Hide all event cards first
                    const allCards = document.querySelectorAll('[id^="event-"]');
                    allCards.forEach(card => {
                        card.classList.add('hidden');
                    });

                    // Show cards for the selected month/year
                    const targetCards = document.querySelectorAll(`#event-${selectedYear}${selectedMonth}`);
                    targetCards.forEach(card => {
                        card.classList.remove('hidden');
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
                    monthYearDropdown.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!monthYearSelector.contains(e.target) && !monthYearDropdown.contains(e.target)) {
                        monthYearDropdown.classList.add('hidden');
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
                    updateMainCalendar();
                });

                // Update existing navigation buttons to work with selector
                const originalPrev = window.prevClick || function() {};
                const originalNext = window.nextClick || function() {};

                // Override existing prev/next button functionality
                if (typeof prev !== 'undefined' && typeof next !== 'undefined') {
                    prev.addEventListener('click', function() {
                        if (currentMonth === 0) {
                            currentMonth = 11;
                            currentYear--;
                        } else {
                            currentMonth--;
                        }
                        updateDropdownYear();
                        updateSelectorDisplay();
                        renderMonthGrid();
                        updateMainCalendar();
                    });

                    next.addEventListener('click', function() {
                        if (currentMonth === 11) {
                            currentMonth = 0;
                            currentYear++;
                        } else {
                            currentMonth++;
                        }
                        updateDropdownYear();
                        updateSelectorDisplay();
                        renderMonthGrid();
                        updateMainCalendar();
                    });
                }

                // Initialize the selector
                initMonthYearSelector();

                // Sync selector with current calendar on page load
                function syncSelectorWithCalendar() {
                    const currentCalendarDate = document.getElementById('monthYear');
                    if (currentCalendarDate) {
                        const dateText = currentCalendarDate.textContent; // e.g., "April 2025"
                        const [monthName, year] = dateText.split(' ');
                        const monthIndex = months.findIndex(m => m === monthName);
                        if (monthIndex !== -1) {
                            currentMonth = monthIndex;
                            currentYear = parseInt(year);
                            updateDropdownYear();
                            updateSelectorDisplay();
                            renderMonthGrid();
                        }
                    }
                }

                // Call sync function after a short delay to ensure calendar is rendered
                setTimeout(syncSelectorWithCalendar, 100);
            });
        </script>

        <style>
            #modalContainer {
                z-index: 9999;
            }

            /* Month/Year Selector Styles */
            #monthYearDropdown {
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            #monthYearDropdown .grid button:hover {
                transform: translateY(-1px);
            }

            #monthYearDropdown .grid button {
                cursor: pointer;
            }

            #monthYearSelector:focus {
                outline: none;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }
        </style>
    </div>
</div>
