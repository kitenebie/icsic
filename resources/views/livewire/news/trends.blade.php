<!-- Trending News by Views -->
<section class="bg-white border rounded-lg p-6 flex-1 shadow-sm">
    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
        <svg class="w-6 h-6 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
        </svg>
        Trending News
    </h2>

    @if ($trendingNews->isEmpty())
        <div class="text-center py-8">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <p class="text-gray-400 text-lg">No trending news with reads available.</p>
            <p class="text-gray-300 text-sm mt-2">Articles will appear here once they get views.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($trendingNews as $index => $trend)
                <article class="flex items-start gap-4 p-4 rounded-lg hover:bg-gray-50 transition-colors group cursor-pointer">
                    <!-- Ranking Number -->
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full
                            @if($index === 0) bg-gradient-to-r from-yellow-400 to-orange-500 text-white font-bold
                            @elseif($index === 1) bg-gradient-to-r from-gray-300 to-gray-400 text-white font-bold
                            @elseif($index === 2) bg-gradient-to-r from-orange-300 to-orange-400 text-white font-bold
                            @else bg-gray-100 text-gray-600 font-semibold
                            @endif">
                            {{ $index + 1 }}
                        </span>
                    </div>

                    <!-- Article Content -->
                    <div class="flex-1 min-w-0">
                        <a href="/read/{{ Illuminate\Support\Str::random(100) }}/{{ $trend->id }}"
                           class="block group-hover:text-blue-600 transition-colors">
                            <h3 class="font-semibold text-gray-900 leading-tight mb-1 line-clamp-2">
                                {{ $trend->title }}
                            </h3>
                        </a>

                        <div class="flex items-center gap-4 text-xs text-gray-500 mt-2">
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ number_format($trend->views) }} views
                            </span>

                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $this->formatDateHumanReadable($trend->created_at) }}
                            </span>

                            <!-- Category Badge -->
                            <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                                {{ $this->categories[$trend->topic_category] ?? 'General' }}
                            </span>
                        </div>

                        <!-- Trending Indicator -->
                        @if($index < 3)
                            <div class="flex items-center mt-2">
                                <div class="flex items-center text-xs text-orange-600 font-medium">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                    Trending
                                </div>
                            </div>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>

        <!-- View More Link -->
        <div class="mt-6 pt-4 border-t border-gray-100 text-center">
            <a href="#" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium text-sm transition-colors">
                View all trending news
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    @endif
</section>
