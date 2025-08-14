<div class="flex max-w-[437px] @if ($this->closeCommentModal) hidden @endif flex-col fixed right-0 h-screen">

    {{-- large screen --}}
    @if ($this->isNotSmallMidium)
        <div
            class="bg-white fixed inset-0  absolute sticky hidden  lg:block bottom-0 left-0 right-0 border px-4 max-w-lg h-full">
            <div class="min-w-[400px] overflow-y-auto min-h-[500px] p-0 m-0 relative flex flex-col">
                <div class="border p-2 ">
                    <button type="button" wire:click="closeComment"><i class="fas fa-arrow-left text-lg"></i></button>
                </div>
                <!-- Scrollable comments container -->
                <div class="flex-1 overflow-y-auto" style="max-height: 500px;">

                    @forelse ($main_comments as $main_comment)
                        <div
                            class="bg-white relative flex flex-col dark:bg-gray-800 text-black dark:text-gray-200 p-4 antialiased flex max-w-lg">
                            <!-- Comment -->
                            <div class="flex mb-4">
                                <img class="rounded-full h-8 w-8 mr-2 mt-1"
                                    src="https://picsum.photos/id/1027/200/200" />
                                <div>
                                    <div class="bg-gray-100 dark:bg-gray-700 rounded-3xl px-4 pt-2 pb-2.5">
                                        <div class="font-semibold text-sm leading-relaxed">
                                            {{ $this->Author($main_comment->commentatorId) }}</div>
                                        <div class="text-normal min-w-[200px] leading-snug md:leading-normal">
                                            {{ $main_comment->comment }}
                                        </div>
                                    </div>
                                    <div
                                        class="flex mt-2 min-w-[120px] justify-between text-sm ml-4 text-gray-500 dark:text-gray-400">
                                        <p>{{ $this->formatDateHumanReadable($main_comment->created_at) }}</p>
                                        <button class="flex items-center gap-1 hover:text-gray-800 relative"
                                            id="like-button-footer" aria-haspopup="true" aria-expanded="false"
                                            aria-controls="reaction-popup-footer"
                                            aria-label="Like button with reactions">

                                            <i {{ $this->current_react($main_comment->id, 'comment') == '' ? '' : 'hidden' }}
                                                id="like-icon-post1" class="far fa-thumbs-up"> </i>
                                            <img id="like-icon-post"
                                                src="{{ $this->current_react($main_comment->id, 'comment') }}"
                                                class="{{ $this->current_react($main_comment->id, 'comment') == '' ? 'hidden' : '' }} size-[1rem]" />

                                            <!-- Reaction popup footer -->
                                            <div class="reaction-popup reaction-popup2 flex" id="reaction-popup-footer"
                                                role="list" aria-label="Reactions">
                                                <img src="/build/img/like.png" class="size-[1.5rem]"
                                                    wire:click='react("Like", {{ $main_comment->id }}, "comment")'
                                                    role="button" aria-label="Like" data-reaction="like"
                                                    title="Like" />
                                                <img src="/build/img/love.png" class="size-[1.5rem]"
                                                    wire:click='react("Love", {{ $main_comment->id }}, "comment")'
                                                    role="button" aria-label="Love" data-reaction="love"
                                                    title="Love" />
                                                <img src="/build/img/haha.png" class="size-[1.5rem]"
                                                    wire:click='react("Haha", {{ $main_comment->id }}, "comment")'
                                                    role="button" aria-label="Haha" data-reaction="haha"
                                                    title="Haha" />
                                                <img src="/build/img/care.png" class="size-[1.5rem]"
                                                    wire:click='react("Care", {{ $main_comment->id }}, "comment")'
                                                    role="button" aria-label="Care" data-reaction="care"
                                                    title="Care" />
                                                <img src="/build/img/wow.png" class="size-[1.5rem]"
                                                    wire:click='react("Wow", {{ $main_comment->id }}, "comment")'
                                                    role="button" aria-label="Wow" data-reaction="wow"
                                                    title="Wow" />
                                                <img src="/build/img/sad.png" class="size-[1.5rem]"
                                                    wire:click='react("Sad", {{ $main_comment->id }}, "comment")'
                                                    role="button" aria-label="Sad" data-reaction="sad"
                                                    title="Sad" />
                                                <img src="/build/img/angry.png" class="size-[1.5rem]"
                                                    wire:click='react("Angry", {{ $main_comment->id }}, "comment")'
                                                    role="button" aria-label="Angry" data-reaction="angry"
                                                    title="Angry" />
                                            </div>
                                        </button>
                                        <button class="@if (auth()->user()->id == $main_comment->commentatorId) hidden @endif"
                                            wire:click='replay_comment({{ $main_comment->id }},{{ $main_comment->post_id }}, {{ $main_comment->commentatorId }})'>Reply</button>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                    <div
                                        class="bg-white dark:bg-gray-700 border border-white dark:border-gray-700 rounded-full float-right -mt-7 mr-0.5 flex shadow items-center">
                                        @forelse ($this->emojies_react($main_comment->id, "comment") as $key => $emoji)
                                            @if ($key == 0)
                                                <img src="/build/img/{{ strtolower($emoji->react) }}.png"
                                                    class="size-[1rem]" role="button" aria-label="{{ $emoji }}"
                                                    data-reaction="{{ $emoji }}" title="{{ $emoji }}" />
                                            @else
                                                <img src="/build/img/{{ strtolower($emoji->react) }}.png"
                                                    class="size-[1rem] -ml-2" role="button"
                                                    aria-label="{{ $emoji }}"
                                                    data-reaction="{{ $emoji }}" title="{{ $emoji }}" />
                                            @endif
                                        @empty
                                        @endforelse
                                        <span
                                            class="text-sm ml-1 pr-1.5 text-gray-500 dark:text-gray-300">{{ $this->total_reacts($main_comment->id, 'comment') }}</span>
                                    </div>

                                    <!-- Reply -->
                                    @forelse ($this->reply_comments($main_comment->post_id, $main_comment->commentatorId, $main_comment->id, $main_comment) as $reply_comment)
                                        <div class="flex mt-4">
                                            <img class="rounded-full h-8 w-8 mr-2 mt-1"
                                                src="https://picsum.photos/id/1027/200/200" />
                                            <div>
                                                <div class="bg-gray-100 dark:bg-gray-700 rounded-3xl px-4 pt-2 pb-2.5">
                                                    <div class="font-semibold text-sm leading-relaxed">
                                                        {{ $this->Author($reply_comment->commentatorId) }}</div>
                                                    <div
                                                        class="text-normal min-w-[180px] leading-snug md:leading-normal">
                                                        {{ $reply_comment->comment }}
                                                    </div>
                                                </div>
                                                <div
                                                    class="flex mt-2 justify-between min-w-[140px] text-sm ml-4 text-gray-500 dark:text-gray-400">
                                                    <p>{{ $this->formatDateHumanReadable($reply_comment->created_at) }}
                                                    </p>
                                                    <button
                                                        class="flex items-center gap-1 hover:text-gray-800 relative"
                                                        id="like-button-footer" aria-haspopup="true"
                                                        aria-expanded="false" aria-controls="reaction-popup-footer"
                                                        aria-label="Like button with reactions">

                                                        <i {{ $this->current_react($reply_comment->id, 'reply') == '' ? '' : 'hidden' }}
                                                            id="like-icon-post1" class="far fa-thumbs-up"> </i>
                                                        <img id="like-icon-post"
                                                            src="{{ $this->current_react($reply_comment->id, 'reply') }}"
                                                            class="{{ $this->current_react($reply_comment->id, 'reply') == '' ? 'hidden' : '' }} size-[1rem]" />


                                                        <!-- Reaction popup footer -->
                                                        <div class="reaction-popup reaction-popup2 flex"
                                                            id="reaction-popup-footer" role="list"
                                                            aria-label="Reactions">
                                                            <img src="/build/img/like.png" class="size-[1.5rem]"
                                                                wire:click='react("Like", {{ $reply_comment->id }}, "reply")'
                                                                role="button" aria-label="Like" data-reaction="like"
                                                                title="Like" />
                                                            <img src="/build/img/love.png" class="size-[1.5rem]"
                                                                wire:click='react("Love", {{ $reply_comment->id }}, "reply")'
                                                                role="button" aria-label="Love" data-reaction="love"
                                                                title="Love" />
                                                            <img src="/build/img/haha.png" class="size-[1.5rem]"
                                                                wire:click='react("Haha", {{ $reply_comment->id }}, "reply")'
                                                                role="button" aria-label="Haha" data-reaction="haha"
                                                                title="Haha" />
                                                            <img src="/build/img/care.png" class="size-[1.5rem]"
                                                                wire:click='react("Care", {{ $reply_comment->id }}, "reply")'
                                                                role="button" aria-label="Care" data-reaction="care"
                                                                title="Care" />
                                                            <img src="/build/img/wow.png" class="size-[1.5rem]"
                                                                wire:click='react("Wow", {{ $reply_comment->id }}, "reply")'
                                                                role="button" aria-label="Wow" data-reaction="wow"
                                                                title="Wow" />
                                                            <img src="/build/img/sad.png" class="size-[1.5rem]"
                                                                wire:click='react("Sad", {{ $reply_comment->id }}, "reply")'
                                                                role="button" aria-label="Sad" data-reaction="sad"
                                                                title="Sad" />
                                                            <img src="/build/img/angry.png" class="size-[1.5rem]"
                                                                wire:click='react("Angry", {{ $reply_comment->id }}, "reply")'
                                                                role="button" aria-label="Angry"
                                                                data-reaction="angry" title="Angry" />
                                                        </div>
                                                    </button>
                                                    <button class="@if (auth()->user()->id == $reply_comment->commentatorId) hidden @endif"
                                                        wire:click='replay_comment({{ $main_comment->id }},{{ $reply_comment->post_id }}, {{ $reply_comment->commentatorId }})'>Reply</button>
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="z-50 bg-white dark:bg-gray-700 border border-white dark:border-gray-700 rounded-full float-right -mt-7 mr-0.5 flex shadow items-center">
                                            @forelse ($this->emojies_react($reply_comment->id, "reply") as $key => $emoji)
                                                @if ($key == 0)
                                                    <img src="/build/img/{{ strtolower($emoji->react) }}.png"
                                                        class="size-[1rem]" role="button"
                                                        aria-label="{{ $emoji }}"
                                                        data-reaction="{{ $emoji }}"
                                                        title="{{ $emoji }}" />
                                                @else
                                                    <img src="/build/img/{{ strtolower($emoji->react) }}.png"
                                                        class="size-[1rem] -ml-2" role="button"
                                                        aria-label="{{ $emoji }}"
                                                        data-reaction="{{ $emoji }}"
                                                        title="{{ $emoji }}" />
                                                @endif
                                            @empty
                                            @endforelse
                                            <span
                                                class="text-sm ml-1 pr-1.5 text-gray-500 dark:text-gray-300">{{ $this->total_reacts($reply_comment->id, 'reply') }}</span>
                                        </div>
                                    @empty
                                    @endforelse

                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="bg-white relative flex flex-col dark:bg-gray-800 text-black dark:text-gray-200 p-4 antialiased flex max-w-lg">
                            <p
                                class="h-[500px] text-center flex justify-center items-center text-sm italic text-gray-500 dark:text-gray-400">
                                Be the first commentor</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
        <!-- Floating input -->
        <div
            class="hidden  lg:flex absolute border sticky h-auto flex bottom-0 left-0 right-0 bg-white border-t border-gray-300 px-4 sm:px-6 py-8">
            <div class="w-full flex px-4">
                <div id="rich-comment-box" contenteditable="true"
                    class="w-full bg-gray-100 pb-[2rem] rounded-md px-4 py-3 text-[15px] sm:text-[16px] text-gray-500 outline-none overflow-hidden resize-none min-h-[3em]"
                    style="line-height: 1.5em; font-weight: normal !important">
                    @if ($this->mentionedName != '/')
                        <span class="font-bold text-green-600">{{ $this->mentionedName }}</b>&nbsp;<span
                                class="font-normal text-gray-500">&nbsp;</span>
                        @else
                            {{ $this->Author(auth()->user()->id) }}
                    @endif
                </div>
                <input type="hidden" wire:model.defer='comment_input' name="comment" id="hidden-comment">

            </div>

            <button wire:click='submit_comment()' onclick="focusAndAddLetter()"
                class="text-gray-400 ml-1 hover:text-gray-700">
                <i class="fas fa-paper-plane text-lg"></i>

                {{-- <div id="loading" class=" flex justify-center items-center h-32">
                    <div class="animate-spin rounded-full h-8 w-8 border-t-4 border-blue-500 border-solid">
                    </div>
                </div> --}}
            </button>

        </div>
    @else
        {{-- end large screen --}}
        {{-- mobile --}}
        <div class="fixed inset-0 lg:hidden flex items-center justify-center bg-black bg-opacity-50 px-4 z-50">
            <div class="pt-8 mt-16 bg-white absolute sticky bottom-0 left-0 right-0 border px-4 max-w-lg h-screen">
                <div class="min-w-[400px] overflow-y-auto min-h-[480px] p-0 m-0 relative flex flex-col">
                    <div class="border p-2 ">
                        <button type="button" wire:click="closeComment"><i
                                class="fas fa-arrow-left text-lg"></i></button>
                    </div>
                    <div class="flex-1 overflow-y-auto" style="max-height: 500px;">

                        @forelse ($main_comments as $main_comment)
                            <div
                                class="bg-white relative flex flex-col dark:bg-gray-800 text-black dark:text-gray-200 p-4 antialiased flex max-w-lg">
                                <!-- Comment -->
                                <div class="flex mb-4">
                                    <img class="rounded-full h-8 w-8 mr-2 mt-1"
                                        src="https://picsum.photos/id/1027/200/200" />
                                    <div>
                                        <div class="bg-gray-100 dark:bg-gray-700 rounded-3xl px-4 pt-2 pb-2.5">
                                            <div class="font-semibold text-sm leading-relaxed">
                                                {{ $this->Author($main_comment->commentatorId) }}</div>
                                            <div class="text-normal min-w-[200px] leading-snug md:leading-normal">
                                                {{ $main_comment->comment }}
                                            </div>
                                        </div>
                                        <div
                                            class="flex mt-2 min-w-[120px] justify-between text-sm ml-4 text-gray-500 dark:text-gray-400">
                                            <p>{{ $this->formatDateHumanReadable($main_comment->created_at) }}</p>
                                            <button class="flex items-center gap-1 hover:text-gray-800 relative"
                                                id="like-button-footer" aria-haspopup="true" aria-expanded="false"
                                                aria-controls="reaction-popup-footer"
                                                aria-label="Like button with reactions">

                                                <i {{ $this->current_react($main_comment->id, 'comment') == '' ? '' : 'hidden' }}
                                                    id="like-icon-post1" class="far fa-thumbs-up"> </i>
                                                <img id="like-icon-post"
                                                    src="{{ $this->current_react($main_comment->id, 'comment') }}"
                                                    class="{{ $this->current_react($main_comment->id, 'comment') == '' ? 'hidden' : '' }} size-[1rem]" />

                                                <!-- Reaction popup footer -->
                                                <div class="reaction-popup reaction-popup2 flex"
                                                    id="reaction-popup-footer" role="list" aria-label="Reactions">
                                                    <img src="/build/img/like.png" class="size-[1.5rem]"
                                                        wire:click='react("Like", {{ $main_comment->id }}, "comment")'
                                                        role="button" aria-label="Like" data-reaction="like"
                                                        title="Like" />
                                                    <img src="/build/img/love.png" class="size-[1.5rem]"
                                                        wire:click='react("Love", {{ $main_comment->id }}, "comment")'
                                                        role="button" aria-label="Love" data-reaction="love"
                                                        title="Love" />
                                                    <img src="/build/img/haha.png" class="size-[1.5rem]"
                                                        wire:click='react("Haha", {{ $main_comment->id }}, "comment")'
                                                        role="button" aria-label="Haha" data-reaction="haha"
                                                        title="Haha" />
                                                    <img src="/build/img/care.png" class="size-[1.5rem]"
                                                        wire:click='react("Care", {{ $main_comment->id }}, "comment")'
                                                        role="button" aria-label="Care" data-reaction="care"
                                                        title="Care" />
                                                    <img src="/build/img/wow.png" class="size-[1.5rem]"
                                                        wire:click='react("Wow", {{ $main_comment->id }}, "comment")'
                                                        role="button" aria-label="Wow" data-reaction="wow"
                                                        title="Wow" />
                                                    <img src="/build/img/sad.png" class="size-[1.5rem]"
                                                        wire:click='react("Sad", {{ $main_comment->id }}, "comment")'
                                                        role="button" aria-label="Sad" data-reaction="sad"
                                                        title="Sad" />
                                                    <img src="/build/img/angry.png" class="size-[1.5rem]"
                                                        wire:click='react("Angry", {{ $main_comment->id }}, "comment")'
                                                        role="button" aria-label="Angry" data-reaction="angry"
                                                        title="Angry" />
                                                </div>
                                            </button>
                                            <button class="@if (auth()->user()->id == $main_comment->commentatorId) hidden @endif"
                                                wire:click='replay_comment({{ $main_comment->id }},{{ $main_comment->post_id }}, {{ $main_comment->commentatorId }})'>Reply</button>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                        <div
                                            class="bg-white dark:bg-gray-700 border border-white dark:border-gray-700 rounded-full float-right -mt-7 mr-0.5 flex shadow items-center">
                                            @forelse ($this->emojies_react($main_comment->id, "comment") as $key => $emoji)
                                                @if ($key == 0)
                                                    <img src="/build/img/{{ strtolower($emoji->react) }}.png"
                                                        class="size-[1rem]" role="button"
                                                        aria-label="{{ $emoji }}"
                                                        data-reaction="{{ $emoji }}"
                                                        title="{{ $emoji }}" />
                                                @else
                                                    <img src="/build/img/{{ strtolower($emoji->react) }}.png"
                                                        class="size-[1rem] -ml-2" role="button"
                                                        aria-label="{{ $emoji }}"
                                                        data-reaction="{{ $emoji }}"
                                                        title="{{ $emoji }}" />
                                                @endif
                                            @empty
                                            @endforelse
                                            <span
                                                class="text-sm ml-1 pr-1.5 text-gray-500 dark:text-gray-300">{{ $this->total_reacts($main_comment->id, 'comment') }}</span>
                                        </div>

                                        <!-- Reply -->
                                        @forelse ($this->reply_comments($main_comment->post_id, $main_comment->commentatorId, $main_comment->id, $main_comment) as $reply_comment)
                                            <div class="flex mt-4">
                                                <img class="rounded-full h-8 w-8 mr-2 mt-1"
                                                    src="https://picsum.photos/id/1027/200/200" />
                                                <div>
                                                    <div
                                                        class="bg-gray-100 dark:bg-gray-700 rounded-3xl px-4 pt-2 pb-2.5">
                                                        <div class="font-semibold text-sm leading-relaxed">
                                                            {{ $this->Author($reply_comment->commentatorId) }}</div>
                                                        <div
                                                            class="text-normal min-w-[180px] leading-snug md:leading-normal">
                                                            {{ $reply_comment->comment }}
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="flex mt-2 justify-between min-w-[140px] text-sm ml-4 text-gray-500 dark:text-gray-400">
                                                        <p>{{ $this->formatDateHumanReadable($reply_comment->created_at) }}
                                                        </p>
                                                        <button
                                                            class="flex items-center gap-1 hover:text-gray-800 relative"
                                                            id="like-button-footer" aria-haspopup="true"
                                                            aria-expanded="false"
                                                            aria-controls="reaction-popup-footer"
                                                            aria-label="Like button with reactions">

                                                            <i {{ $this->current_react($reply_comment->id, 'reply') == '' ? '' : 'hidden' }}
                                                                id="like-icon-post1" class="far fa-thumbs-up"> </i>
                                                            <img id="like-icon-post"
                                                                src="{{ $this->current_react($reply_comment->id, 'reply') }}"
                                                                class="{{ $this->current_react($reply_comment->id, 'reply') == '' ? 'hidden' : '' }} size-[1rem]" />


                                                            <!-- Reaction popup footer -->
                                                            <div class="reaction-popup reaction-popup2 flex"
                                                                id="reaction-popup-footer" role="list"
                                                                aria-label="Reactions">
                                                                <img src="/build/img/like.png" class="size-[1.5rem]"
                                                                    wire:click='react("Like", {{ $reply_comment->id }}, "reply")'
                                                                    role="button" aria-label="Like"
                                                                    data-reaction="like" title="Like" />
                                                                <img src="/build/img/love.png" class="size-[1.5rem]"
                                                                    wire:click='react("Love", {{ $reply_comment->id }}, "reply")'
                                                                    role="button" aria-label="Love"
                                                                    data-reaction="love" title="Love" />
                                                                <img src="/build/img/haha.png" class="size-[1.5rem]"
                                                                    wire:click='react("Haha", {{ $reply_comment->id }}, "reply")'
                                                                    role="button" aria-label="Haha"
                                                                    data-reaction="haha" title="Haha" />
                                                                <img src="/build/img/care.png" class="size-[1.5rem]"
                                                                    wire:click='react("Care", {{ $reply_comment->id }}, "reply")'
                                                                    role="button" aria-label="Care"
                                                                    data-reaction="care" title="Care" />
                                                                <img src="/build/img/wow.png" class="size-[1.5rem]"
                                                                    wire:click='react("Wow", {{ $reply_comment->id }}, "reply")'
                                                                    role="button" aria-label="Wow"
                                                                    data-reaction="wow" title="Wow" />
                                                                <img src="/build/img/sad.png" class="size-[1.5rem]"
                                                                    wire:click='react("Sad", {{ $reply_comment->id }}, "reply")'
                                                                    role="button" aria-label="Sad"
                                                                    data-reaction="sad" title="Sad" />
                                                                <img src="/build/img/angry.png" class="size-[1.5rem]"
                                                                    wire:click='react("Angry", {{ $reply_comment->id }}, "reply")'
                                                                    role="button" aria-label="Angry"
                                                                    data-reaction="angry" title="Angry" />
                                                            </div>
                                                        </button>
                                                        <button class="@if (auth()->user()->id == $reply_comment->commentatorId) hidden @endif"
                                                            wire:click='replay_comment({{ $main_comment->id }},{{ $reply_comment->post_id }}, {{ $reply_comment->commentatorId }})'>Reply</button>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="z-50 bg-white dark:bg-gray-700 border border-white dark:border-gray-700 rounded-full float-right -mt-7 mr-0.5 flex shadow items-center">
                                                @forelse ($this->emojies_react($reply_comment->id, "reply") as $key => $emoji)
                                                    @if ($key == 0)
                                                        <img src="/build/img/{{ strtolower($emoji->react) }}.png"
                                                            class="size-[1rem]" role="button"
                                                            aria-label="{{ $emoji }}"
                                                            data-reaction="{{ $emoji }}"
                                                            title="{{ $emoji }}" />
                                                    @else
                                                        <img src="/build/img/{{ strtolower($emoji->react) }}.png"
                                                            class="size-[1rem] -ml-2" role="button"
                                                            aria-label="{{ $emoji }}"
                                                            data-reaction="{{ $emoji }}"
                                                            title="{{ $emoji }}" />
                                                    @endif
                                                @empty
                                                @endforelse
                                                <span
                                                    class="text-sm ml-1 pr-1.5 text-gray-500 dark:text-gray-300">{{ $this->total_reacts($reply_comment->id, 'reply') }}</span>
                                            </div>
                                        @empty
                                        @endforelse

                                    </div>
                                </div>
                            </div>
                        @empty
                            <div
                                class="bg-white relative flex flex-col dark:bg-gray-800 text-black dark:text-gray-200 p-4 antialiased flex max-w-lg">
                                <p
                                    class="h-[500px] text-center flex justify-center items-center text-sm italic text-gray-500 dark:text-gray-400">
                                    Be the first commentor</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                <!-- Floating input -->
                <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-300 px-4 sm:px-6 py-4 z-50">
                    <div class="max-w-screen-lg mx-auto flex items-end gap-2">
                        <!-- Editable Input -->
                        <div id="rich-comment-box1" contenteditable="true"
                            class="flex-1 bg-gray-100 rounded-md px-4 py-3 text-[15px] sm:text-[16px] text-gray-700 outline-none overflow-y-auto resize-none max-h-32 min-h-[3rem] leading-relaxed"
                            style="font-weight: normal !important" oninput="syncToHiddenInput()">
                            @if ($this->mentionedName != '/')
                                <span class="font-bold text-green-600">{{ $this->mentionedName }}</span>
                                <span class="font-normal text-gray-500">&nbsp;</span>
                            @else
                                {{ $this->Author(auth()->user()->id) }}
                            @endif
                        </div>

                        <!-- Hidden input for Livewire -->
                        <input type="hidden" wire:model.defer='comment_input' name="comment" id="hidden-comment1">

                        <!-- Submit Button -->
                        <button wire:click='submit_comment()' onclick="focusAndAddLetter()"
                            class="text-gray-500 hover:text-blue-600 transition">
                            <i class="fas fa-paper-plane text-lg"></i>

                        </button>

                    </div>
                </div>

                <!-- Scripts -->
                <script>
                    function focusAndAddLetter() {
                        const input = document.getElementById('hidden-comment1');
                        const loading = document.getElementById('loading');
                        input.focus();
                        input.value += ' ';
                        loading.classList.add('hidden');
                    }

                    function syncToHiddenInput() {
                        const richBox = document.getElementById('rich-comment-box1');
                        const hiddenInput = document.getElementById('hidden-comment1');
                        hiddenInput.value = richBox.innerText.trim();
                    }
                </script>

            </div>
        </div>
    @endif
    <script>
        const richBox = document.getElementById('rich-comment-box');
        const hiddenInput = document.getElementById('hidden-comment');
        var active = true;

        richBox.addEventListener('input', () => {
            const html = richBox.innerHTML;
            if (richBox.innerText.length == 1) {
                hiddenInput.value = richBox.innerText;
                active = false;
            }
            if (!html.includes('&nbsp;') && !html.includes('\u00A0') && active) {
                richBox.innerText = "";
            }
            hiddenInput.value = richBox.innerText;
            hiddenInput.dispatchEvent(new Event('input', {
                bubbles: true
            }));
        });
    </script>
    <script>
        const richBox1 = document.getElementById('rich-comment-box1');
        const hiddenInput1 = document.getElementById('hidden-comment1');
        var active1 = true;

        richBox1.addEventListener('input', () => {
            const html = richBox1.innerHTML;
            if (richBox1.innerText.length == 1) {
                hiddenInput1.value = richBox1.innerText;
                active1 = false;
            }
            if (!html.includes('&nbsp;') && !html.includes('\u00A0') && active1) {
                richBox1.innerText = "";
            }
            hiddenInput1.value = richBox1.innerText;
            hiddenInput1.dispatchEvent(new Event('input', {
                bubbles: true
            }));
        });
    </script>
    <script>
        function focusAndAddLetter() {
            const input = document.getElementById('hidden-comment');
            input.focus();
            input.value += ' ';
        }
    </script>
    @script
        <script>
            window.addEventListener('load', function() {
                function checkScreenSize() {
                    const isSmall = window.matchMedia('(max-width: 767px)').matches; // sm and below
                    const isMedium = window.matchMedia('(min-width: 768px) and (max-width: 1023px)').matches; // md

                    if (isSmall || isMedium) {
                        $wire.dispatch('post-created', {
                            refreshPosts: false
                        });

                    } else {
                        $wire.dispatch('post-created', {
                            refreshPosts: true
                        });
                    }
                }

                // Run on load
                checkScreenSize();

                // Optional: Run on resize
                window.addEventListener('resize', checkScreenSize);
            });
        </script>
    @endscript

</div>
