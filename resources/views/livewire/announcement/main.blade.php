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

                        <button class="action-button" aria-label="Share post">
                            <i class="fas fa-share"></i>
                            <span>Share</span>
                        </button>
                    </div>
                </article>
            @empty
                @livewire('announcement.not-found')
            @endforelse
        </section>
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
            display: none; /* Facebook posts don't typically have separate titles */
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
        
        /* Reaction summary styles */
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
        
        /* Modal styles */
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
        
        /* Responsive design */
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
        
        /* Dark mode support (optional) */
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
        </style>
    
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Content toggle functionality
            window.toggleContent = function(announcementId) {
                const card = document.querySelector(`#announcement-${announcementId}`);
                const preview = card.querySelector('.content-preview');
                const full = card.querySelector('.content-full');
                
                if (preview && full) {
                    preview.classList.toggle('hidden');
                    full.classList.toggle('hidden');
                }
            };
    
            // Image modal functionality
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
    
            // Keyboard navigation for modal
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
    
        });
        </script>
    </div>

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
