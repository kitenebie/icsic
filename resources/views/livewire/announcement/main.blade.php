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

@push('styles')
<link href="{{ asset('css/announcement.css') }}" rel="stylesheet">
@endpush

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
        document.body.classList.add('overflow-hidden');
    };

    window.closeImageModal = function() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
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
