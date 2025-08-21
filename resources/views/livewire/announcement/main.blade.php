<div class="announcement-container">
    <div class="announcement-feed">
        <section class="announcement-section">
            @forelse ($announcements as $announcement)
                <article id="announcement-{{ $announcement->id }}" class="announcement-card">
                    <!-- Header -->
                    <header class="announcement-header">
                        <div class="school-info">
                            <img 
                                src="https://storage.googleapis.com/a1aa/image/10e94bdc-c408-4a4f-44e0-cc6af4a3b589.jpg" 
                                alt="Irosin Central School logo" 
                                class="school-avatar"
                            />
                            <div class="school-details">
                                <h3 class="school-name">Irosin Central School</h3>
                                <div class="post-meta">
                                    <time datetime="{{ $announcement->created_at }}">
                                        {{ $this->formatDateHumanReadable($announcement->created_at) }}
                                    </time>
                                    <span class="separator">·</span>
                                    @if ($announcement->tags)
                                        <i class="fas fa-users" aria-label="Group post" title="Group post"></i>
                                    @else
                                        <i class="fas fa-globe-americas" aria-label="Public post" title="Public post"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </header>

                    <!-- Content -->
                    <div class="announcement-content">
                        <h4 class="announcement-title">{{ $announcement->title }}</h4>
                        <div class="announcement-text">
                            <div class="content-preview">
                                {!! \Illuminate\Support\Str::limit($announcement->content, 218, '') !!}
                                @if (strlen($announcement->content) > 218)
                                    <button class="see-more-btn" onclick="toggleContent({{ $announcement->id }})">
                                        See more...
                                    </button>
                                @endif
                            </div>
                            @if (strlen($announcement->content) > 218)
                                <div class="content-full hidden">
                                    {!! $announcement->content !!}
                                    <button class="see-less-btn" onclick="toggleContent({{ $announcement->id }})">
                                        See less...
                                    </button>
                                </div>
                            @endif
                        </div>

                        <!-- Image Gallery -->
                        @if (count($announcement->images) > 0)
                            <div class="image-gallery {{ count($announcement->images) >= 4 ? 'gallery-grid' : 'gallery-single' }}">
                                @php
                                    $imagesArray = array_map(fn($img) => asset('storage/' . $img), $announcement->images);
                                @endphp

                                @foreach (array_slice($announcement->images, 0, 4) as $index => $image)
                                    <div class="gallery-item">
                                        <img 
                                            src="{{ asset('storage/' . $image) }}" 
                                            alt="Announcement image {{ $index + 1 }}"
                                            class="gallery-image cursor-pointer"
                                            onclick="openImageModal({{ json_encode($imagesArray) }}, {{ $index }})"
                                        />
                                        @if ($index === 3 && count($announcement->images) > 4)
                                            <div class="image-overlay" onclick="openImageModal({{ json_encode($imagesArray) }}, {{ $index }})">
                                                <span class="image-count">+{{ count($announcement->images) - 4 }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Footer Stats -->
                    <footer class="announcement-footer">
                        @include('livewire.announcement.partials.reaction-summary', [
                            'itemId' => $announcement->id,
                            'type' => 'post'
                        ])
                        
                        @if ($this->commentCount($announcement->id))
                            <button 
                                class="comment-count-btn"
                                wire:click='openComment({{ $announcement->id }})'
                                aria-label="View {{ $this->commentCount($announcement->id) }} comments"
                            >
                                {{ $this->commentCount($announcement->id) }} {{ Str::plural('comment', $this->commentCount($announcement->id)) }}
                            </button>
                        @endif
                    </footer>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <div class="action-button-group">
                            @include('livewire.announcement.partials.reaction-button', [
                                'itemId' => $announcement->id,
                                'type' => 'post',
                                'size' => 'medium'
                            ])
                            <span class="action-label">Like</span>
                        </div>

                        <button 
                            class="action-button"
                            wire:click='openComment({{ $announcement->id }})'
                            aria-label="Comment on post"
                        >
                            <i class="far fa-comment"></i>
                            <span>Comment</span>
                        </button>

                        <button
                            class="action-button"
                            onclick="sharePost({{ $announcement->id }}, '{{ addslashes($announcement->title) }}', '{{ addslashes(strip_tags($announcement->content)) }}')"
                            aria-label="Share post"
                        >
                            <i class="fas fa-share"></i>
                            <span>Share</span>
                        </button>
                    </div>
                </article>
            @empty
                @livewire('announcement.not-found')
            @endforelse
        </section>

        <!-- Image Modal -->
        <div id="imageModal" class="image-modal hidden" role="dialog" aria-modal="true" aria-labelledby="modal-title">
            <div class="modal-overlay" onclick="closeImageModal()"></div>
            <div class="modal-content">
                <button class="modal-close" onclick="closeImageModal()" aria-label="Close modal">
                    <i class="fas fa-times"></i>
                </button>
                <button class="modal-nav modal-prev" onclick="changeModalImage(-1)" aria-label="Previous image">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <img id="modalImage" src="" alt="Announcement image" class="modal-image" />
                <button class="modal-nav modal-next" onclick="changeModalImage(1)" aria-label="Next image">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        @if (session('comment'))
            @livewire('announcement.comments', ['comment', 5])
        @endif
    </div>
</div>

@push('styles')
<style>
/* Facebook-inspired styles */
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    background-color: #f0f2f5;
    margin: 0;
    padding: 0;
}

.announcement-container {
    min-height: 100vh;
    background-color: #f0f2f5;
    padding-top: 20px;
}

.announcement-feed {
    max-width: 590px;
    margin: 0 auto;
    padding: 0 16px;
}

.announcement-section {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.announcement-card {
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    margin-bottom: 16px;
}

.announcement-header {
    padding: 12px 16px 0px 16px;
    border-bottom: none;
}

.school-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.school-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.school-details {
    flex: 1;
}

.school-name {
    font-weight: 600;
    font-size: 15px;
    color: #050505;
    margin: 0;
    line-height: 1.3333;
}

.post-meta {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 13px;
    color: #65676b;
    margin-top: 2px;
}

.separator {
    color: #65676b;
    margin: 0 4px;
}

.post-meta i {
    font-size: 12px;
    color: #65676b;
}

.announcement-content {
    padding: 16px 16px 0 16px;
}

.announcement-title {
    display: none;
}

.announcement-text {
    color: #050505;
    font-size: 15px;
    line-height: 1.3333;
    margin-bottom: 12px;
}

.see-more-btn, .see-less-btn {
    color: #65676b;
    font-weight: 500;
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
    margin-left: 4px;
    font-size: 15px;
    text-decoration: none;
}

.see-more-btn:hover, .see-less-btn:hover {
    text-decoration: underline;
}

.image-gallery {
    margin: 12px 0 0 0;
    padding: 0;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2px;
    border-radius: 8px;
    overflow: hidden;
}

.gallery-single {
    border-radius: 8px;
    overflow: hidden;
}

.gallery-item {
    position: relative;
    aspect-ratio: 1;
    background-color: #f0f2f5;
    overflow: hidden;
}

.gallery-single .gallery-item {
    aspect-ratio: 16/9;
    max-height: 400px;
}

.gallery-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    cursor: pointer;
    transition: transform 0.2s ease;
}

.gallery-image:hover {
    transform: scale(1.02);
}

.image-overlay {
    position: absolute;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.image-count {
    color: white;
    font-size: 24px;
    font-weight: 600;
}

.announcement-footer {
    padding: 8px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 15px;
    color: #65676b;
    border-top: none;
}

.comment-count-btn {
    color: #65676b;
    cursor: pointer;
    background: none;
    border: none;
    font-size: 15px;
    padding: 0;
}

.comment-count-btn:hover {
    text-decoration: underline;
}

.action-buttons {
    display: flex;
    border-top: 1px solid #e4e6ea;
    margin: 0;
    padding: 0;
}

.action-button-group, .action-button {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px;
    color: #65676b;
    border-radius: 0;
    transition: background-color 0.2s ease;
    cursor: pointer;
    background: none;
    border: none;
    font-size: 15px;
    font-weight: 600;
    position: relative;
}

.action-button-group:not(:last-child):after,
.action-button:not(:last-child):after {
    content: '';
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 1px;
    height: 20px;
    background-color: #e4e6ea;
}

.action-button-group:hover, .action-button:hover {
    background-color: #f2f3f4;
}

.action-label {
    font-size: 15px;
    font-weight: 600;
    color: #65676b;
}

.action-button i {
    font-size: 16px;
    color: #65676b;
}

.reaction-summary-container {
    background: none;
    border: none;
    border-radius: 0;
    padding: 0;
    box-shadow: none;
    float: none;
    margin: 0;
    position: static;
    z-index: auto;
    display: flex;
    align-items: center;
    gap: 6px;
}

.reaction-emojis {
    display: flex;
    align-items: center;
    margin-right: 6px;
}

.reaction-emoji {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: 2px solid #ffffff;
    margin-left: -3px;
}

.reaction-emoji:first-child {
    margin-left: 0;
}

.reaction-count {
    font-size: 15px;
    color: #65676b;
    font-weight: 400;
    cursor: pointer;
}

.reaction-count:hover {
    text-decoration: underline;
}

.image-modal {
    position: fixed;
    inset: 0;
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(255, 255, 255, 0.9);
}

.modal-overlay {
    position: absolute;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.8);
}

.modal-content {
    position: relative;
    max-width: 90vw;
    max-height: 90vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-close {
    position: absolute;
    top: 16px;
    right: 16px;
    color: white;
    font-size: 24px;
    cursor: pointer;
    background: rgba(0, 0, 0, 0.5);
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
}

.modal-close:hover {
    background: rgba(0, 0, 0, 0.7);
}

.modal-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    color: white;
    font-size: 24px;
    cursor: pointer;
    background: rgba(0, 0, 0, 0.5);
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-nav:hover {
    background: rgba(0, 0, 0, 0.7);
}

.modal-prev {
    left: 16px;
}

.modal-next {
    right: 16px;
}

.modal-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    border-radius: 8px;
}

.hidden {
    display: none !important;
}

@media (max-width: 768px) {
    .announcement-feed {
        max-width: 100%;
        padding: 0 8px;
    }
    
    .announcement-card {
        margin-bottom: 8px;
        border-radius: 0;
    }
    
    .gallery-grid {
        grid-template-columns: 1fr;
    }
    
    .modal-content {
        margin: 16px;
    }
    
    .action-button-group, .action-button {
        padding: 8px;
        font-size: 14px;
    }
}

@media (prefers-color-scheme: dark) {
    body {
        background-color: #18191a;
    }
    
    .announcement-container {
        background-color: #18191a;
    }
    
    .announcement-card {
        background-color: #242526;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.4);
    }
    
    .school-name {
        color: #e4e6ea;
    }
    
    .announcement-text {
        color: #e4e6ea;
    }
    
    .post-meta, .post-meta i {
        color: #b0b3b8;
    }
    
    .action-button-group, .action-button {
        color: #b0b3b8;
    }
    
    .action-button-group:hover, .action-button:hover {
        background-color: #3a3b3c;
    }
    
    .action-buttons {
        border-top-color: #3e4042;
    }
    
    .action-button-group:after, .action-button:after {
        background-color: #3e4042;
    }
    
    .reaction-count, .comment-count-btn {
        color: #b0b3b8;
    }
    
    .see-more-btn, .see-less-btn {
        color: #b0b3b8;
    }
}

/* Reaction Button Styles */
.reaction-button-wrapper {
    position: relative;
    display: inline-block;
}

.reaction-trigger-btn {
    display: flex;
    align-items: center;
    gap: 4px;
    cursor: pointer;
    background: none;
    border: none;
    padding: 6px 8px;
    border-radius: 6px;
    transition: all 0.2s ease;
    color: #65676b;
    font-size: 15px;
    font-weight: 600;
    min-height: 32px;
}

.reaction-trigger-btn:hover {
    background-color: #f2f3f4;
    transform: translateY(-1px);
}

.reaction-trigger-btn.reacted {
    color: #1877f2;
}

.current-reaction {
    object-fit: contain;
    filter: drop-shadow(0 1px 2px rgba(0,0,0,0.1));
}

/* Facebook-style reaction popup */
.reaction-popup-menu {
    position: absolute;
    bottom: calc(100% + 8px);
    left: 50%;
    transform: translateX(-50%);
    background: #ffffff;
    border-radius: 25px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(0, 0, 0, 0.05);
    padding: 8px 12px;
    display: flex;
    gap: 4px;
    z-index: 100;
    animation: reactionPopupIn 0.15s ease-out;
    transform-origin: bottom center;
}

@keyframes reactionPopupIn {
    0% {
        opacity: 0;
        transform: translateX(-50%) translateY(4px) scale(0.9);
    }
    100% {
        opacity: 1;
        transform: translateX(-50%) translateY(0) scale(1);
    }
}

.reaction-popup-menu::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-top: 6px solid #ffffff;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
}

.reaction-option-btn {
    padding: 6px;
    transition: all 0.15s ease;
    cursor: pointer;
    background: none;
    border: none;
    border-radius: 50%;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.reaction-option-btn:hover {
    transform: scale(1.3);
    z-index: 1;
}

.reaction-option-btn img {
    transition: all 0.15s ease;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
}

.reaction-option-btn:hover img {
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3)) saturate(1.2) brightness(1.1);
}

/* Responsive adjustments for reaction buttons */
@media (max-width: 768px) {
    .reaction-popup-menu {
        bottom: auto;
        top: calc(100% + 8px);
        padding: 10px 14px;
        gap: 6px;
    }
    
    .reaction-popup-menu::after {
        top: auto;
        bottom: 100%;
        border-top: 0;
        border-bottom: 6px solid #ffffff;
    }
    
    .reaction-option-btn {
        padding: 8px;
    }
    
    .reaction-option-btn:hover {
        transform: scale(1.2);
    }
}

/* Dark mode support for reaction buttons */
@media (prefers-color-scheme: dark) {
    .reaction-trigger-btn {
        color: #b0b3b8;
    }
    
    .reaction-trigger-btn:hover {
        background-color: #3a3b3c;
    }
    
    .reaction-popup-menu {
        background: #3e4042;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.1);
    }
    
    .reaction-popup-menu::after {
        border-top-color: #3e4042;
    }
    
    @media (max-width: 768px) {
        .reaction-popup-menu::after {
            border-bottom-color: #3e4042;
        }
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    window.toggleContent = function(announcementId) {
        const card = document.querySelector(`#announcement-${announcementId}`);
        const preview = card.querySelector('.content-preview');
        const full = card.querySelector('.content-full');
        
        if (preview && full) {
            preview.classList.toggle('hidden');
            full.classList.toggle('hidden');
        }
    };

    let currentImages = [];
    let currentIndex = 0;

    window.openImageModal = function(images, index) {
        currentImages = images;
        currentIndex = index;
        document.getElementById('modalImage').src = currentImages[currentIndex];
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    window.closeImageModal = function() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    };

    window.changeModalImage = function(direction) {
        currentIndex += direction;
        if (currentIndex < 0) currentIndex = currentImages.length - 1;
        if (currentIndex >= currentImages.length) currentIndex = 0;
        document.getElementById('modalImage').src = currentImages[currentIndex];
    };

    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('imageModal');
        if (!modal.classList.contains('hidden')) {
            switch(e.key) {
                case 'Escape':
                    closeImageModal();
                    break;
                case 'ArrowLeft':
                    changeModalImage(-1);
                    break;
                case 'ArrowRight':
                    changeModalImage(1);
                    break;
            }
        }
    });

    window.sharePost = function(postId, title, content) {
        const postUrl = `${window.location.origin}/read/${btoa(postId)}`;
        const shareText = title + '\n\n' + content.substring(0, 200) + (content.length > 200 ? '...' : '');
        
        if (navigator.share) {
            navigator.share({
                title: title,
                text: shareText,
                url: postUrl
            }).catch(err => {
                console.log('Error sharing:', err);
                showShareModal(postUrl, title, shareText);
            });
        } else {
            showShareModal(postUrl, title, shareText);
        }
    };

    function showShareModal(url, title, text) {
        const modal = document.createElement('div');
        modal.className = 'share-modal';
        modal.innerHTML = `
            <div class="share-modal-overlay" onclick="closeShareModal()"></div>
            <div class="share-modal-content">
                <div class="share-modal-header">
                    <h3>Share this post</h3>
                    <button onclick="closeShareModal()" class="share-modal-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="share-options">
                    <button onclick="shareToFacebook('${url}', '${title.replace(/'/g, "\\'")}', '${text.replace(/'/g, "\\'")}')">
                        <i class="fab fa-facebook-f"></i>
                        <span>Facebook</span>
                    </button>
                    <button onclick="shareToTwitter('${url}', '${text.replace(/'/g, "\\'")}')">
                        <i class="fab fa-twitter"></i>
                        <span>Twitter</span>
                    </button>
                    <button onclick="shareToWhatsApp('${text.replace(/'/g, "\\'")}', '${url}')">
                        <i class="fab fa-whatsapp"></i>
                        <span>WhatsApp</span>
                    </button>
                    <button onclick="copyToClipboard('${url}')">
                        <i class="fas fa-link"></i>
                        <span>Copy Link</span>
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        document.body.style.overflow = 'hidden';
        
        if (!document.getElementById('share-modal-styles')) {
            const styles = document.createElement('style');
            styles.id = 'share-modal-styles';
            styles.innerHTML = `
                .share-modal {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    z-index: 1000;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .share-modal-overlay {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.6);
                }
                .share-modal-content {
                    background: white;
                    border-radius: 8px;
                    padding: 20px;
                    max-width: 400px;
                    width: 90%;
                    position: relative;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }
                .share-modal-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 20px;
                }
                .share-modal-header h3 {
                    margin: 0;
                    font-size: 20px;
                    font-weight: 600;
                    color: #050505;
                }
                .share-modal-close {
                    background: none;
                    border: none;
                    font-size: 20px;
                    cursor: pointer;
                    color: #65676b;
                    padding: 5px;
                    border-radius: 50%;
                    width: 36px;
                    height: 36px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .share-modal-close:hover {
                    background-color: #f2f3f4;
                }
                .share-options {
                    display: grid;
                    grid-template-columns: repeat(2, 1fr);
                    gap: 12px;
                }
                .share-options button {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    gap: 8px;
                    padding: 16px;
                    background: #f0f2f5;
                    border: none;
                    border-radius: 8px;
                    cursor: pointer;
                    transition: background-color 0.2s;
                    font-size: 14px;
                    font-weight: 600;
                    color: #050505;
                }
                .share-options button:hover {
                    background: #e4e6ea;
                }
                .share-options button i {
                    font-size: 24px;
                }
                .share-options button:nth-child(1) i { color: #1877f2; }
                .share-options button:nth-child(2) i { color: #1da1f2; }
                .share-options button:nth-child(3) i { color: #25d366; }
                .share-options button:nth-child(4) i { color: #65676b; }
            `;
            document.head.appendChild(styles);
        }
    }

    window.closeShareModal = function() {
        const modal = document.querySelector('.share-modal');
        if (modal) {
            modal.remove();
            document.body.style.overflow = 'auto';
        }
    };

    window.shareToFacebook = function(url, title, text) {
        const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}&quote=${encodeURIComponent(text)}`;
        window.open(facebookUrl, 'facebook-share', 'width=580,height=400,scrollbars=yes,resizable=yes');
        closeShareModal();
    };

    window.shareToTwitter = function(url, text) {
        const twitterUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
        window.open(twitterUrl, 'twitter-share', 'width=580,height=400,scrollbars=yes,resizable=yes');
        closeShareModal();
    };

    window.shareToWhatsApp = function(text, url) {
        const whatsappText = `${text} ${url}`;
        const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(whatsappText)}`;
        window.open(whatsappUrl, '_blank');
        closeShareModal();
    };

    window.copyToClipboard = function(url) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(url).then(() => {
                const button = event.target.closest('button');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-check"></i><span>Copied!</span>';
                button.style.background = '#42b883';
                button.style.color = 'white';
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.style.background = '';
                    button.style.color = '';
                    closeShareModal();
                }, 1000);
            }).catch(() => {
                fallbackCopyToClipboard(url);
            });
        } else {
            fallbackCopyToClipboard(url);
        }
    };

    function fallbackCopyToClipboard(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        textArea.style.top = '-999999px';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand('copy');
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check"></i><span>Copied!</span>';
            button.style.background = '#42b883';
            button.style.color = 'white';
            
            setTimeout(() => {
                button.innerHTML = originalText;
                button.style.background = '';
                button.style.color = '';
                closeShareModal();
            }, 1000);
        } catch (err) {
            console.error('Could not copy text: ', err);
            alert('Could not copy link. Please copy manually: ' + text);
        }
        
        document.body.removeChild(textArea);
    }

    // Handle reaction popup visibility with improved Facebook-like behavior
    const triggers = document.querySelectorAll('.reaction-trigger-btn');
    
    triggers.forEach(trigger => {
        const itemId = trigger.dataset.itemId;
        const popup = document.querySelector(`.reaction-popup-menu[data-item-id="${itemId}"]`);
        
        if (popup) {
            let showTimeout;
            let hideTimeout;
            
            // Show popup on hover (faster response)
            trigger.addEventListener('mouseenter', function() {
                clearTimeout(hideTimeout);
                showTimeout = setTimeout(() => {
                    // Hide all other popups first
                    document.querySelectorAll('.reaction-popup-menu').forEach(p => {
                        if (p !== popup) {
                            p.classList.add('hidden');
                        }
                    });
                    popup.classList.remove('hidden');
                }, 300); // Reduced from 500ms for better UX
            });
            
            trigger.addEventListener('mouseleave', function() {
                clearTimeout(showTimeout);
                hideTimeout = setTimeout(() => {
                    if (!popup.matches(':hover')) {
                        popup.classList.add('hidden');
                    }
                }, 150);
            });
            
            // Keep popup open when hovering over it
            popup.addEventListener('mouseenter', function() {
                clearTimeout(hideTimeout);
            });
            
            popup.addEventListener('mouseleave', function() {
                popup.classList.add('hidden');
            });
            
            // Enhanced mobile touch support
            trigger.addEventListener('touchstart', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const isVisible = !popup.classList.contains('hidden');
                
                // Hide all popups
                document.querySelectorAll('.reaction-popup-menu').forEach(p => {
                    p.classList.add('hidden');
                });
                
                // Show this popup if it wasn't visible
                if (!isVisible) {
                    popup.classList.remove('hidden');
                    
                    // Auto-hide after 3 seconds on mobile
                    setTimeout(() => {
                        popup.classList.add('hidden');
                    }, 3000);
                }
            });
            
            // Add click handlers to reaction options for immediate feedback
            const reactionOptions = popup.querySelectorAll('.reaction-option-btn');
            reactionOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Add visual feedback
                    this.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        popup.classList.add('hidden');
                    }, 100);
                });
            });
        }
    });
    
    // Close popups when clicking outside (improved)
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.reaction-button-wrapper')) {
            document.querySelectorAll('.reaction-popup-menu').forEach(popup => {
                popup.classList.add('hidden');
            });
        }
    });
    
    // Close popups on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.reaction-popup-menu').forEach(popup => {
                popup.classList.add('hidden');
            });
        }
    });
});
</script>
@endpush
