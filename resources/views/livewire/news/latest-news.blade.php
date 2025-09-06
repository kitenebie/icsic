<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @forelse ($latest as $News_item)
        <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden group cursor-pointer">
            <!-- News Image -->
            <div class="relative h-48 overflow-hidden">
                <img src="/storage/{{ $News_item->image }}"
                     alt="{{ $News_item->title }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>

                <!-- Category Badge -->
                <div class="absolute top-3 left-3">
                    <span class="px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded-full">
                        {{ $this->categories[$News_item->topic_category] }}
                    </span>
                </div>

                <!-- Reading Time -->
                <div class="absolute top-3 right-3">
                    <div class="bg-white/90 backdrop-blur-sm rounded-lg px-2 py-1">
                        <span class="text-xs font-medium text-gray-700">{{ $News_item->read_duration ?? '5' }} min read</span>
                    </div>
                </div>
            </div>

            <!-- News Content -->
            <div class="p-6">
                <h3 class="font-bold text-gray-900 text-lg leading-tight mb-3 group-hover:text-blue-600 transition-colors line-clamp-2">
                    {{ $News_item->title }}
                </h3>

                <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                    {!! Illuminate\Support\Str::limit(strip_tags($News_item->content[0]['Paragraph'][0]['content'] ?? ''), 150) !!}
                </p>

                <!-- Meta Information -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-900">{{ $News_item->author ?? 'School Admin' }}</p>
                            <p class="text-xs text-gray-500">{{ $this->formatDateHumanReadable($News_item->created_at) }}</p>
                        </div>
                    </div>

                    <a href="/read/{{ Illuminate\Support\Str::random(100) }}/{{ $News_item->id }}"
                       class="inline-flex items-center space-x-1 text-blue-600 hover:text-blue-700 font-medium text-sm transition-colors">
                        <span>Read more</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <!-- Social Stats -->
                <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center space-x-4 text-xs text-gray-500">
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <span>{{ rand(5, 50) }}</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <span>{{ rand(1, 20) }}</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <span>{{ rand(10, 200) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    @empty
        @livewire('news.not-found')
    @endforelse
</div>
