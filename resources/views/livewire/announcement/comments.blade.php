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
                // Function to update hidden input and sync with Livewire
                function updateHiddenInput() {
                    let content = richBox.innerText.trim();
                    
                    // Handle mention preservation - extract text after mentions
                    const mentions = richBox.querySelectorAll('.mention');
                    let mentionText = '';
                    mentions.forEach(mention => {
                        mentionText += mention.textContent + ' ';
                    });
                    
                    // Get text after mentions
                    let actualContent = content;
                    if (mentionText) {
                        actualContent = content.replace(mentionText.trim(), '').trim();
                    }
                    
                    // Update both hidden input value and Livewire property
                    hiddenInput.value = actualContent;
                    
                    // Force Livewire sync
                    if (window.Livewire && @this) {
                        @this.set('comment_input', actualContent);
                    }
                    
                    // Dispatch input event for good measure
                    hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
                    
                    console.log('Comment input updated:', actualContent); // Debug log
                }

                // Clear input on clear-comment-input event
                window.addEventListener('clear-comment-input', function() {
                    richBox.innerHTML = '';
                    const mentionData = richBox.getAttribute('data-mention');
                    if (mentionData && mentionData !== '/') {
                        richBox.innerHTML = `<span class="mention" contenteditable="false">${mentionData}</span>&nbsp;`;
                    }
                    hiddenInput.value = '';
                    if (window.Livewire && @this) {
                        @this.set('comment_input', '');
                    }
                });

                // Enhanced input handler
                richBox.addEventListener('input', updateHiddenInput);
                richBox.addEventListener('paste', function(e) {
                    // Handle paste events
                    setTimeout(updateHiddenInput, 100);
                });

                richBox.addEventListener('focus', function() {
                    const wrapper = this.closest('.comment-input-wrapper');
                    if (wrapper) {
                        wrapper.style.backgroundColor = '#ffffff';
                        wrapper.style.border = '1px solid #1877f2';
                    }
                    
                    // Place cursor after mention if exists
                    const mentions = richBox.querySelectorAll('.mention');
                    if (mentions.length > 0) {
                        const range = document.createRange();
                        const selection = window.getSelection();
                        range.setStartAfter(mentions[mentions.length - 1]);
                        range.collapse(true);
                        selection.removeAllRanges();
                        selection.addRange(range);
                    }
                });

                richBox.addEventListener('blur', function() {
                    const wrapper = this.closest('.comment-input-wrapper');
                    if (wrapper) {
                        wrapper.style.backgroundColor = '#f0f2f5';
                        wrapper.style.border = 'none';
                    }
                    // Final sync on blur
                    updateHiddenInput();
                });

                richBox.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        // Ensure final sync before submit
                        updateHiddenInput();
                        setTimeout(() => {
                            @this.submit_comment();
                        }, 50);
                    }
                    
                    // Prevent deletion of mention spans
                    if (e.key === 'Backspace' || e.key === 'Delete') {
                        const selection = window.getSelection();
                        if (selection.rangeCount > 0) {
                            const range = selection.getRangeAt(0);
                            const mention = range.startContainer.parentElement?.closest('.mention');
                            if (mention && range.startOffset === 0) {
                                e.preventDefault();
                            }
                        }
                    }
                });

                // Initial sync
                updateHiddenInput();
            }

            function handleScreenSizeChange() {
                const isSmallOrMedium = window.matchMedia('(max-width: 1023px)').matches;
                if (window.Livewire) {
                    window.Livewire.dispatch('post-created', {
                        refreshPosts: !isSmallOrMedium
                    });
                }
            }

            handleScreenSizeChange();
            window.addEventListener('resize', handleScreenSizeChange);

            const violationWords = @json($this->voilateWords ?? []);
            if (violationWords && violationWords.length > 0 && violationWords !== '[]') {
                alert(`${violationWords} contains words that are not allowed. Please remove them and try again.`);
            }
        });

        // Listen for Livewire events
        document.addEventListener('livewire:init', () => {
            Livewire.on('clear-comment-input', () => {
                const richBox = document.getElementById('rich-comment-box');
                const hiddenInput = document.getElementById('hidden-comment');
                
                if (richBox && hiddenInput) {
                    const mentionData = richBox.getAttribute('data-mention');
                    if (mentionData && mentionData !== '/') {
                        richBox.innerHTML = `<span class="mention" contenteditable="false">${mentionData}</span>&nbsp;`;
                    } else {
                        richBox.innerHTML = '';
                    }
                    hiddenInput.value = '';
                    if (window.Livewire && @this) {
                        @this.set('comment_input', '');
                    }
                }
            });
        });

        window.submitComment = function() {
            const richBox = document.getElementById('rich-comment-box');
            if (richBox) {
                const content = richBox.innerText.trim();
                if (content) {
                    @this.submit_comment();
                }
            }
        };
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
