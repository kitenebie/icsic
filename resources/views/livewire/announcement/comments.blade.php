<div class="comments-modal absolute {{ $this->closeCommentModal ? 'hidden' : 'flex' }}" role="dialog" aria-modal="true"
    aria-labelledby="comments-title">

    <!-- Modal Overlay (Mobile) --> 
    <div class="modal-overlay lg:hidden" wire:click="closeComment"></div>

    <!-- Comments Container -->
    <div class="comments-container">
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
                    role="textbox" aria-label="Write a comment">
                    @if ($this->mentionedName !== '/')
                        <span class="mention">{{ $this->mentionedName }}</span>
                    @else
                        <span class="placeholder-text">{{ $this->Author(auth()->user()->id) }}</span>
                    @endif
                </div>

                <input type="hidden" wire:model.defer="comment_input" name="comment" id="hidden-comment" />

                <button wire:click="submit_comment()" class="send-button" aria-label="Send comment">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const richBox = document.getElementById('rich-comment-box');
            const hiddenInput = document.getElementById('hidden-comment');

            if (richBox && hiddenInput) {
                let isActive = true;

                richBox.addEventListener('input', function() {
                    const content = richBox.innerText.trim();

                    // Handle first character input
                    if (content.length === 1 && isActive) {
                        hiddenInput.value = content;
                        isActive = false;
                    }

                    // Clear placeholder behavior
                    const html = richBox.innerHTML;
                    if (!html.includes('&nbsp;') && !html.includes('\u00A0') && isActive) {
                        richBox.innerText = '';
                    }

                    // Sync with hidden input
                    hiddenInput.value = content;
                    hiddenInput.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                });

                // Handle focus/blur for better UX
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
                });

                // Handle Enter key for submission
                richBox.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        const event = new CustomEvent('submit-comment');
                        document.dispatchEvent(event);
                    }
                });
            }

            // Screen size detection for responsive behavior
            function handleScreenSizeChange() {
                const isSmallOrMedium = window.matchMedia('(max-width: 1023px)').matches;

                if (window.Livewire) {
                    window.Livewire.dispatch('post-created', {
                        refreshPosts: !isSmallOrMedium
                    });
                }
            }

            // Initial check and resize listener
            handleScreenSizeChange();
            window.addEventListener('resize', handleScreenSizeChange);

            // Handle violation words alert
            const violationWords = @json($this->voilateWords ?? []);
            if (violationWords && violationWords.length > 0 && violationWords !== '[]') {
                alert(`${violationWords} contains words that are not allowed. Please remove them and try again.`);
            }
        });

        // Global function for comment submission
        window.submitComment = function() {
            const input = document.getElementById('hidden-comment');
            if (input) {
                input.focus();
                input.value += ' ';
            }
        };
    </script>
</div>
