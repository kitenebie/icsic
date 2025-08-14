<div class="flex relative h-full mt-18">
    <div
        class="flex flex-col lg:mr-8 gap-6 items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <section class="max-w-2xl mt-2 mx-auto px-1 lg-px-6 pb-12">
            @forelse ($announcements  as $arryKey => $announcement)
                <!-- Facebook-like Post Section -->
                <!-- 4 -->
                <div id="{{ $announcement->id }}"
                    class="mb-2 lg:min-w-[650px] bg-white border border lg-p-4 rounded-md shadow-sm text-gray-800 text-xs sm:text-sm"
                    style="font-family: Arial, sans-serif">
                    <!-- Header -->
                    <div class="flex items-center gap-2 p-3 border-b border-gray-200">
                        <img alt="Irosin Central School logo green circle with ICS text" class="w-11 h-11 rounded-full"
                            height="24"
                            src="https://storage.googleapis.com/a1aa/image/10e94bdc-c408-4a4f-44e0-cc6af4a3b589.jpg"
                            width="24" />
                        <div class="ml-2 flex flex-col leading-tight">
                            <span class="font-bold text-lg">
                                Irosin Central School
                            </span>
                            <span class="text-gray-500 text-md">
                                {{ $this->formatDateHumanReadable($announcement->created_at) }} ·
                                @if ($announcement->tags)
                                    <i class="fas fa-users"> </i>
                                @else
                                    <i class="fas fa-globe-americas"> </i>
                                @endif
                            </span>
                        </div>
                    </div>
                    <!-- Post Content -->
                    <div class="p-3">
                        <p class="font-semibold text-lg mb-1 leading-snug">
                            {{ $announcement->title }}
                        </p>
                        <p class="text-gray-700 text-lg mb-3 leading-relaxed">
                            <span class="announcement-preview">{!! \Illuminate\Support\Str::limit(
                                $announcement->content,
                                218,
                                ' <button class="see-more-btn text-gray-500 ml-2"> See more...</button> ',
                            ) !!}</span>
                            <span class="announcement-full" style="display: none;">{!! $announcement->content !!}</span>

                            <button class="hide-btn ml-2 text-gray-500" style="display: none;"> See less...</button>
                        </p>
                        <!-- Image Grid -->
                        @if (count($announcement->images) >= 4)
                            <div class="grid grid-cols-2 grid-rows-2 gap-1 mb-3">
                            @else
                                <div class="grid grid-cols gap-1 mb-3">
                        @endif
                        @forelse (array_slice($announcement->images, 0, 4) as $index => $image)
                            <div
                                class="bg-white-700 border flex justify-center items-center relative text-white font-bold text-sm w-full h-64">

                                <img alt="{{ $image }}" src="{{ asset('storage/' . $image) }}"
                                    wire:click='showMore({{ $announcement->id }})' role="button"
                                    class="w-full h-full object-cover" />

                                @if ($index == 4)
                                    <span wire:click='showMore({{ $announcement->id }})' role="button"
                                        class="absolute text-3xl p-4 bg-gray-900 bg-opacity-50 inset-0 flex justify-center items-center">
                                        {{ count($announcement->images) - 4 }}+
                                    </span>
                                @endif
                            </div>
                        @empty
                        @endforelse
                    </div>
                    <!-- Project Timeline -->
                    {{-- <div class="bg-green-100 p-2 rounded text-[11px] text-green-900 leading-tight">
                        <p class="flex items-center gap-1 mb-1 font-semibold">
                            <i class="fas fa-info-circle"> </i>
                            Project Timeline
                        </p>
                        <ul class="list-disc list-inside space-y-0.5">
                            <li>Phase 1 (Completed): Classroom renovations</li>
                            <li>Phase 2 (In Progress): Library expansion</li>
                            <li>Phase 3 (Starting June): Playground installation</li>
                            <li>Project Completion: July 2023</li>
                        </ul>
                    </div> --}}
                </div>
                <!-- Footer -->
                <div
                    class="border-t border-gray-200 flex justify-between items-center px-3 py-2 text-gray-500 text-[11px] relative">
                    <div class="flex relative items-center justify-start gap-0 relative">
                        @forelse ($this->emojies_react($announcement->id, "post") as $emoji)
                            <img src="/build/img/{{ strtolower($emoji->react) }}.png" class="size-[1.2rem] -ml-2"
                                role="button" aria-label="{{ $emoji }}" data-reaction="{{ $emoji }}"
                                title="{{ $emoji }}" />
                        @empty
                        @endforelse
                        <span id="reaction-summary" class="text-gray-700 text-[12px] ml-2 select-none cursor-default">
                            {{ $this->total_reacts($announcement->id, 'post') }}
                        </span>
                    </div>
                    <a href="/announcements-comment/({{ $announcement->id }}">
                        {{ $this->commentCount($announcement->id) }} </a>
                </div>
                <div class="border-t border-gray-200 flex justify-around text-gray-600 text-[11px] py-2">
                    <button class="flex items-center gap-1 hover:text-gray-800 relative" id="like-button-footer"
                        aria-haspopup="true" aria-expanded="false" aria-controls="reaction-popup-footer"
                        aria-label="Like button with reactions">
                        <i {{ $this->current_react($announcement->id, 'post') == '' ? '' : 'hidden' }}
                            id="like-icon-post1" class="far fa-thumbs-up text-2xl"> </i>
                        <img id="like-icon-post" src="{{ $this->current_react($announcement->id, 'post') }}"
                            class="{{ $this->current_react($announcement->id, 'post') == '' ? 'hidden' : '' }} size-[1.6rem]" />

                        <!-- Reaction popup footer -->
                        <div class="reaction-popup flex" id="reaction-popup-footer" role="list"
                            aria-label="Reactions">
                            <img src="/build/img/like.png" class="size-[2rem]"
                                wire:click='react("Like", {{ $announcement->id }}, "post")' role="button"
                                aria-label="Like" data-reaction="like" title="Like" />
                            <img src="/build/img/love.png" class="size-[2rem]"
                                wire:click='react("Love", {{ $announcement->id }}, "post")' role="button"
                                aria-label="Love" data-reaction="love" title="Love" />
                            <img src="/build/img/haha.png" class="size-[2rem]"
                                wire:click='react("Haha", {{ $announcement->id }}, "post")' role="button"
                                aria-label="Haha" data-reaction="haha" title="Haha" />
                            <img src="/build/img/care.png" class="size-[2rem]"
                                wire:click='react("Care", {{ $announcement->id }}, "post")' role="button"
                                aria-label="Care" data-reaction="care" title="Care" />
                            <img src="/build/img/wow.png" class="size-[2rem]"
                                wire:click='react("Wow", {{ $announcement->id }}, "post")' role="button"
                                aria-label="Wow" data-reaction="wow" title="Wow" />
                            <img src="/build/img/sad.png" class="size-[2rem]"
                                wire:click='react("Sad", {{ $announcement->id }}, "post")' role="button"
                                aria-label="Sad" data-reaction="sad" title="Sad" />
                            <img src="/build/img/angry.png" class="size-[2rem]"
                                wire:click='react("Angry", {{ $announcement->id }}, "post")' role="button"
                                aria-label="Angry" data-reaction="angry" title="Angry" />
                        </div>
                    </button>
                    <button wire:click='openComment({{ $announcement->id }})'
                        class="flex items-center gap-1 hover:text-gray-800" id="comment-toggle-button"
                        aria-expanded="false" aria-controls="comments-section">
                        <i class="far fa-comment text-2xl"> </i>
                        Comment
                    </button>
                    <button class="flex items-center gap-1 hover:text-gray-800">
                        <i class="fas fa-share text-2xl"> </i>
                        Share
                    </button>
                </div>
    </div>
@empty
    @livewire('announcement.not-found')
    @endforelse
    </section>
</div>
@if (session('comment'))
    @livewire('announcement.comments', ['comment', 5])
@endif
</div>
