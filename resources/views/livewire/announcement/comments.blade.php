<div class="comments-modal {{ $this->closeCommentModal ? 'hidden' : 'flex' }}" 
     role="dialog" 
     aria-modal="true" 
     aria-labelledby="comments-title">
    
    <!-- Modal Overlay (Mobile) -->
    <div class="modal-overlay lg:hidden" wire:click="closeComment"></div>
    
    <!-- Comments Container -->
    <div class="comments-container">
        <!-- Header -->
        <header class="comments-header">
            <button 
                type="button" 
                wire:click="closeComment" 
                class="back-button"
                aria-label="Close comments"
            >
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
                        <img 
                            src="https://picsum.photos/id/1027/200/200" 
                            alt="User avatar"
                            class="comment-avatar"
                        />
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
                                    'size' => 'small'
                                ])
                                
                                @if (auth()->user()->id !== $main_comment->commentatorId)
                                    <button 
                                        class="reply-button"
                                        wire:click="replay_comment({{ $main_comment->id }}, {{ $main_comment->post_id }}, {{ $main_comment->commentatorId }})"
                                    >
                                        Reply
                                    </button>
                                @endif
                            </div>
                            
                            <!-- Reaction Summary -->
                            @include('livewire.announcement.partials.reaction-summary', [
                                'itemId' => $main_comment->id,
                                'type' => 'comment'
                            ])
                        </div>
                    </article>

                    <!-- Reply Comments -->
                    @foreach ($this->reply_comments($main_comment->post_id, $main_comment->commentatorId, $main_comment->id, $main_comment) as $reply_comment)
                        <article class="comment reply-comment">
                            <img 
                                src="https://picsum.photos/id/1027/200/200" 
                                alt="User avatar"
                                class="comment-avatar"
                            />
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
                                        'size' => 'small'
                                    ])
                                    
                                    @if (auth()->user()->id !== $reply_comment->commentatorId)
                                        <button 
                                            class="reply-button"
                                            wire:click="replay_comment({{ $main_comment->id }}, {{ $reply_comment->post_id }}, {{ $reply_comment->commentatorId }})"
                                        >
                                            Reply
                                        </button>
                                    @endif
                                </div>
                                
                                <!-- Reaction Summary -->
                                @include('livewire.announcement.partials.reaction-summary', [
                                    'itemId' => $reply_comment->id,
                                    'type' => 'reply'
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
                <div 
                    id="rich-comment-box" 
                    contenteditable="true"
                    class="comment-input"
                    placeholder="Write a comment..."
                    role="textbox"
                    aria-label="Write a comment"
                >
                    @if ($this->mentionedName !== '/')
                        <span class="mention">{{ $this->mentionedName }}</span>
                    @else
                        <span class="placeholder-text">{{ $this->Author(auth()->user()->id) }}</span>
                    @endif
                </div>
                
                <input 
                    type="hidden" 
                    wire:model.defer="comment_input" 
                    name="comment" 
                    id="hidden-comment"
                />
                
                <button 
                    wire:click="submit_comment()" 
                    class="send-button"
                    aria-label="Send comment"
                >
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Comments component styles using standard CSS */
.comments-modal { position: fixed; inset: 0; z-index: 50; }
.modal-overlay { position: absolute; inset: 0; background-color: rgba(0, 0, 0, 0.5); }
.comments-container { background-color: white; display: flex; flex-direction: column; height: 100%; width: 100%; max-width: 28rem; margin-left: auto; }
@media (min-width: 1024px) {
    .comments-container { position: relative; max-width: 32rem; border: 1px solid #e5e7eb; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); height: 100vh; max-height: 100vh; }
}
.comments-header { display: flex; align-items: center; gap: 0.75rem; padding: 1rem; border-bottom: 1px solid #e5e7eb; background-color: white; position: sticky; top: 0; z-index: 10; }
.back-button { padding: 0.5rem; border-radius: 50%; transition: background-color 0.2s; }
.back-button:hover { background-color: #f3f4f6; }
.comments-title { font-size: 1.125rem; font-weight: 600; color: #111827; }
.comments-list { flex: 1; overflow-y: auto; padding: 1rem; display: flex; flex-direction: column; gap: 1rem; }
.comment-thread { display: flex; flex-direction: column; gap: 0.75rem; }
.comment { display: flex; gap: 0.75rem; }
.reply-comment { margin-left: 3rem; }
.comment-avatar { width: 2.5rem; height: 2.5rem; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
.comment-content { flex: 1; min-width: 0; }
.comment-bubble { background-color: #f3f4f6; border-radius: 1rem; padding: 0.75rem 1rem; display: inline-block; max-width: 100%; transition: background-color 0.2s; }
.comment-bubble:hover { background-color: #f9fafb; }
.comment-author { font-weight: 600; font-size: 0.875rem; color: #111827; margin-bottom: 0.25rem; }
.comment-text { color: #374151; font-size: 0.875rem; line-height: 1.5; word-break: break-words; }
.comment-actions { display: flex; align-items: center; gap: 1rem; margin-top: 0.5rem; margin-left: 1rem; font-size: 0.75rem; color: #6b7280; }
.reply-button { font-weight: 500; cursor: pointer; transition: color 0.2s; }
.reply-button:hover { color: #374151; }
.comment-input-container { position: sticky; bottom: 0; background-color: white; border-top: 1px solid #e5e7eb; padding: 1rem; }
.comment-input-wrapper { display: flex; align-items: flex-end; gap: 0.75rem; }
.comment-input { flex: 1; background-color: #f3f4f6; border-radius: 1rem; padding: 0.75rem 1rem; font-size: 0.875rem; outline: none; resize: none; max-height: 8rem; overflow-y: auto; transition: all 0.2s; min-height: 2.5rem; }
.comment-input:focus { ring: 2px; ring-color: rgba(59, 130, 246, 0.5); background-color: white; }
.comment-input:empty:before { content: attr(placeholder); color: #6b7280; }
.comment-input:focus:before { content: ''; }
.mention { font-weight: 600; color: #2563eb; }
.placeholder-text { color: #6b7280; }
.send-button { color: #2563eb; padding: 0.5rem; transition: all 0.2s; border-radius: 50%; }
.send-button:hover { color: #1d4ed8; background-color: #dbeafe; transform: scale(1.1); }
.send-button:active { transform: scale(0.95); }
.empty-state { display: flex; align-items: center; justify-content: center; height: 16rem; }
.empty-message { color: #6b7280; font-size: 0.875rem; font-style: italic; }
@media (max-width: 1024px) {
    .comments-container { position: fixed; inset: 0; max-width: none; }
}
@media (min-width: 1024px) {
    .comments-modal { position: relative; inset: auto; z-index: auto; }
    .modal-overlay { display: none; }
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
            hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
        });

        // Handle focus/blur for better UX
        richBox.addEventListener('focus', function() {
            this.classList.add('ring-2', 'ring-blue-500', 'ring-opacity-50');
        });

        richBox.addEventListener('blur', function() {
            this.classList.remove('ring-2', 'ring-blue-500', 'ring-opacity-50');
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