<div class="comments-modal {{ $this->closeCommentModal ? 'hidden' : 'flex' }}" role="dialog" aria-modal="true"
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
    <style>
        .comments-modal {
            position: fixed;
            inset: 0;
            z-index: 1000;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
        }

        .modal-overlay {
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.6);
        }

        .comments-container {
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 100%;
            max-width: 500px;
            margin-left: auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        @media (min-width: 1024px) {
            .comments-container {
                position: relative;
                max-width: 500px;
                height: 100vh;
                max-height: 100vh;
                border-radius: 8px;
                overflow: hidden;
            }
        }

        .comments-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            border-bottom: 1px solid #e4e6ea;
            background-color: #ffffff;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .back-button {
            padding: 8px;
            border-radius: 50%;
            transition: background-color 0.2s;
            background: none;
            border: none;
            cursor: pointer;
            color: #65676b;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
        }

        .back-button:hover {
            background-color: #f2f3f4;
        }

        .comments-title {
            font-size: 20px;
            font-weight: 600;
            color: #050505;
            margin: 0;
        }

        .comments-list {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            background-color: #f0f2f5;
        }

        .comment-thread {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .comment {
            display: flex;
            gap: 12px;
        }

        .reply-comment {
            margin-left: 48px;
        }

        .comment-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }

        .comment-content {
            flex: 1;
            min-width: 0;
        }

        .comment-bubble {
            background-color: #ffffff;
            border-radius: 16px;
            padding: 8px 12px;
            display: inline-block;
            max-width: 100%;
            transition: background-color 0.2s;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .comment-bubble:hover {
            background-color: #f8f9fa;
        }

        .comment-author {
            font-weight: 600;
            font-size: 13px;
            color: #050505;
            margin-bottom: 2px;
        }

        .comment-text {
            color: #050505;
            font-size: 15px;
            line-height: 1.3333;
            word-break: break-words;
        }

        .comment-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 6px;
            margin-left: 12px;
            font-size: 13px;
            color: #65676b;
        }

        .comment-actions time {
            font-weight: 600;
        }

        .reply-button {
            font-weight: 600;
            cursor: pointer;
            transition: color 0.2s;
            background: none;
            border: none;
            padding: 0;
            color: #65676b;
        }

        .reply-button:hover {
            text-decoration: underline;
        }

        .comment-input-container {
            position: sticky;
            bottom: 0;
            background-color: #ffffff;
            border-top: 1px solid #e4e6ea;
            padding: 12px 16px;
        }

        .comment-input-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: #f0f2f5;
            border-radius: 20px;
            padding: 8px 12px;
        }

        .comment-input {
            flex: 1;
            background: none;
            border: none;
            outline: none;
            font-size: 15px;
            resize: none;
            max-height: 80px;
            overflow-y: auto;
            min-height: 20px;
            line-height: 1.3333;
            color: #050505;
        }

        .comment-input:empty:before {
            content: attr(placeholder);
            color: #65676b;
        }

        .comment-input:focus:before {
            content: '';
        }

        .mention {
            font-weight: 600;
            color: #1877f2;
        }

        .placeholder-text {
            color: #65676b;
        }

        .send-button {
            color: #1877f2;
            padding: 6px;
            transition: all 0.2s;
            border-radius: 50%;
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
        }

        .send-button:hover {
            background-color: rgba(24, 119, 242, 0.1);
        }

        .send-button:active {
            transform: scale(0.95);
        }

        .empty-state {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 200px;
            flex-direction: column;
            gap: 8px;
        }

        .empty-message {
            color: #65676b;
            font-size: 17px;
            font-weight: 600;
            text-align: center;
        }

        @media (max-width: 1024px) {
            .comments-container {
                position: fixed;
                inset: 0;
                max-width: none;
                border-radius: 0;
            }
        }

        @media (min-width: 1024px) {
            .comments-modal {
                position: relative;
                inset: auto;
                z-index: auto;
                background: none;
                backdrop-filter: none;
            }

            .modal-overlay {
                display: none;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {

            .comments-container,
            .comment-bubble,
            .comment-input-container {
                background-color: #242526;
            }

            .comments-list {
                background-color: #18191a;
            }

            .comments-title,
            .comment-author,
            .comment-text {
                color: #e4e6ea;
            }

            .comment-actions,
            .reply-button,
            .placeholder-text {
                color: #b0b3b8;
            }

            .comment-input {
                color: #e4e6ea;
            }

            .comment-input-wrapper {
                background-color: #3a3b3c;
            }

            .back-button:hover {
                background-color: #3a3b3c;
            }

            .comment-bubble:hover {
                background-color: #3a3b3c;
            }

            .comments-header {
                border-bottom-color: #3e4042;
            }

            .comment-input-container {
                border-top-color: #3e4042;
            }
        }
    </style>

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
