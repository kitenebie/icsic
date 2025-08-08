    <section class="max-w-7xl mx-auto px-6 pb-12">
        <h2 class="text-center font-bold text-lg sm:text-xl mb-2">Events</h2>
        <p class="text-center text-gray-600 text-xs sm:text-sm mb-8 max-w-md mx-auto">
            Stay updated with the latest happenings at Irosin Central School.
        </p>

        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($events as $event)
                <div id="event-{{ \Carbon\Carbon::parse($event->event_date)->format('Y') }}{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}"
                    class="bg-white rounded-xl p-6 shadow-md border">
                    <div class="flex justify-between items-start mb-4">
                        <div class="bg-[#d9f0e1] rounded-md text-[#2f7a4e] font-semibold text-center w-14">
                            <div class="text-xl leading-none pt-1 font-bold">
                                {{ \Carbon\Carbon::parse($event->event_date)->format('d') }}
                            </div>
                            <div class="text-sm pb-1">
                                {{ \Carbon\Carbon::parse($event->event_date)->format('M') }}
                            </div>
                        </div>
                        <div class="bg-[#0b6b2f] text-white text-xs rounded-full px-3 py-1 font-semibold self-start">
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
            @endforelse
        </div>
        <div class="mt-8 flex justify-center">
            <a href="/events"
                class="bg-green-800 text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-md hover:bg-green-900">
                View All Events
        </a>
        </div>
    </section>
