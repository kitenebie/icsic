<div class="comments-modal fixed inset-0 z-50 flex items-center justify-center lg:absolute lg:inset-auto lg:top-0 lg:right-0 lg:bottom-0 lg:w-96" role="dialog" aria-modal="true"
    aria-labelledby="comments-title">

    <!-- Modal Overlay (Mobile) -->
    <div class="fixed inset-0 bg-black bg-opacity-50 lg:hidden" wire:click="closeComment"></div>

    <!-- Comments Container -->
    <div class="comments-container relative bg-white w-full h-full lg:h-auto lg:w-96 flex flex-col max-h-screen lg:max-h-[80vh] rounded-t-lg lg:rounded-lg lg:shadow-lg">
        <!-- Header -->
        <header class="comments-header">
            <button type="button" wire:click="closeComment" class="back-button" aria-label="Close comments">
                <i class="fas fa-arrow-left"></i>
            </button>
            <h2 id="comments-title" class="comments-title">Comments</h2>
        </header>

        <!-- Comments List -->
        <div class="comments-list">
            @forelse ($main_comments as $main_comment)
                <div class="comment-thread">
                    <!-- Main Comment -->
                    <article class="comment">
                        <img src="https://picsum.photos/id/1027/200/200" alt="User avatar" class="comment-avatar" />
                        <div class="comment-content">
                            <div class="comment-bubble">
                                <h4 class="comment-author">{{ $this->Author($main_comment->commentatorId) }}</h4>
                                <p class="comment-text">{{ $main_comment->comment }}</p>
                            </div>

                            <!-- Comment Actions -->
                            <div class="comment-actions">
                                <time datetime="{{ $main_comment->created_at }}">
                                    {{ $this->formatDateHumanReadable($main_comment->created_at) }}
                                </time>

                                @include('livewire.announcement.partials.reaction-button', [
                                    'itemId' => $main_comment->id,
                                    'type' => 'comment',
                                    'size' => 'small',
                                ])

                                @if (auth()->user()->id !== $main_comment->commentatorId)
                                    <button class="reply-button"
                                        wire:click="replay_comment({{ $main_comment->id }}, {{ $main_comment->post_id }}, {{ $main_comment->commentatorId }})">
                                        Reply
                                    </button>
                                @endif
                            </div>

                            <!-- Reaction Summary -->
                            @include('livewire.announcement.partials.reaction-summary', [
                                'itemId' => $main_comment->id,
                                'type' => 'comment',
                            ])
                        </div>
                    </article>

                    <!-- Reply Comments -->
                    @foreach ($this->reply_comments($main_comment->post_id, $main_comment->commentatorId, $main_comment->id, $main_comment) as $reply_comment)
                        <article class="comment reply-comment">
                            <img src="https://picsum.photos/id/1027/200/200" alt="User avatar" class="comment-avatar" />
                            <div class="comment-content">
                                <div class="comment-bubble">
                                    <h4 class="comment-author">{{ $this->Author($reply_comment->commentatorId) }}</h4>
                                    <p class="comment-text">{{ $reply_comment->comment }}</p>
                                </div>

                                <!-- Reply Actions -->
                                <div class="comment-actions">
                                    <time datetime="{{ $reply_comment->created_at }}">
                                        {{ $this->formatDateHumanReadable($reply_comment->created_at) }}
                                    </time>

                                    @include('livewire.announcement.partials.reaction-button', [
                                        'itemId' => $reply_comment->id,
                                        'type' => 'reply',
                                        'size' => 'small',
                                    ])

                                    @if (auth()->user()->id !== $reply_comment->commentatorId)
                                        <button class="reply-button"
                                            wire:click="replay_comment({{ $main_comment->id }}, {{ $reply_comment->post_id }}, {{ $reply_comment->commentatorId }})">
                                            Reply
                                        </button>
                                    @endif
                                </div>

                                <!-- Reaction Summary -->
                                @include('livewire.announcement.partials.reaction-summary', [
                                    'itemId' => $reply_comment->id,
                                    'type' => 'reply',
                                ])
                            </div>
                        </article>
                    @endforeach
                </div>
            @empty
                <div class="empty-state">
                    <p class="empty-message">Be the first to comment</p>
                </div>
            @endforelse
        </div>

        <!-- Comment Input -->
        <div class="comment-input-container">
            <div class="comment-input-wrapper">
                <div id="rich-comment-box" contenteditable="true" class="comment-input" placeholder="Write a comment..."
                    role="textbox" aria-label="Write a comment" data-mention="{{ $this->mentionedName }}">
                    @if ($this->mentionedName !== '/')
                        <span class="mention" contenteditable="false">{{ $this->mentionedName }}</span>&nbsp;
                    @endif
                </div>

                <input type="hidden" wire:model.live="comment_input" name="comment" id="hidden-comment" />

                <!-- Submit button -->
                <button wire:click="submit_comment" class="send-button" aria-label="Send comment"
                        wire:loading.attr="disabled">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>

            <!-- Sending indicator -->
            <div class="sending-indicator" wire:loading wire:target="submit_comment">
                <span>Sending...</span>
            </div>
        </div>
    </div>

    {{-- Comment box behavior --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const richBox = document.getElementById('rich-comment-box');
            const hiddenInput = document.getElementById('hidden-comment');

            if (richBox && hiddenInput) {
                function updateInput() {
                    let content = richBox.innerText.trim();
                    
                    // Handle mentions
                    const mentions = richBox.querySelectorAll('.mention');
                    let mentionText = '';
                    mentions.forEach(mention => {
                        mentionText += mention.textContent + ' ';
                    });
                    
                    if (mentionText) {
                        content = content.replace(mentionText.trim(), '').trim();
                    }
                    
                    hiddenInput.value = content;
                    
                    // Sync with Livewire
                    if (window.Livewire && @this) {
                        @this.set('comment_input', content);
                    }
                }

                // Input events
                richBox.addEventListener('input', updateInput);
                richBox.addEventListener('paste', function() {
                    setTimeout(updateInput, 100);
                });

                // Focus/blur styling
                richBox.addEventListener('focus', function() {
                    const wrapper = this.closest('.comment-input-wrapper');
                    if (wrapper) {
                        wrapper.style.backgroundColor = '#ffffff';
                        wrapper.style.border = '1px solid #1877f2';
                    }
                });

                richBox.addEventListener('blur', function() {
                    const wrapper = this.closest('.comment-input-wrapper');
                    if (wrapper) {
                        wrapper.style.backgroundColor = '#f0f2f5';
                        wrapper.style.border = 'none';
                    }
                    updateInput();
                });

                // Enter to submit
                richBox.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        updateInput();
                        @this.submit_comment();
                    }
                });

                // Clear input event
                document.addEventListener('livewire:init', () => {
                    Livewire.on('clear-comment-input', () => {
                        const mentionData = richBox.getAttribute('data-mention');
                        if (mentionData && mentionData !== '/') {
                            richBox.innerHTML = `<span class="mention" contenteditable="false">${mentionData}</span>&nbsp;`;
                        } else {
                            richBox.innerHTML = '';
                        }
                        hiddenInput.value = '';
                        if (@this) {
                            @this.set('comment_input', '');
                        }
                    });
                });

                updateInput();
            }
        });
    </script>

    {{-- Reaction button behavior --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.reaction-trigger-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // close all open menus first
                    document.querySelectorAll('.reaction-popup-menu').forEach(menu => {
                        menu.classList.add('hidden');
                    });

                    // open only the popup inside THIS wrapper
                    const wrapper = this.closest('.reaction-button-wrapper');
                    const popup = wrapper.querySelector('.reaction-popup-menu');
                    if (popup) {
                        popup.classList.toggle('hidden');
                    }
                });
            });

            // close menus if clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.reaction-button-wrapper')) {
                    document.querySelectorAll('.reaction-popup-menu').forEach(menu => {
                        menu.classList.add('hidden');
                    });
                }
            });
        });
    </script>
</div>
