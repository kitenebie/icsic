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
                                {{-- {{ $this->commentCount($announcement->id) }} {{ Str::plural('comment', $this->commentCount($announcement->id)) }} --}}
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

<style>
/* Basic announcement styles using standard CSS */
.announcement-container { display: flex; position: relative; height: 100%; margin-top: 4.5rem; }
.announcement-feed { display: flex; flex-direction: column; gap: 1.5rem; align-items: center; justify-content: center; width: 100%; transition: opacity 0.75s; opacity: 1; }
@media (min-width: 1024px) {
    .announcement-feed { margin-right: 2rem; flex-grow: 1; }
}
.announcement-section { max-width: 32rem; margin-top: 0.5rem; margin-left: auto; margin-right: auto; padding-left: 0.25rem; padding-bottom: 3rem; }
@media (min-width: 1024px) {
    .announcement-section { padding-left: 1.5rem; padding-right: 1.5rem; }
}
.announcement-card { margin-bottom: 1.5rem; background-color: white; border: 1px solid #e5e7eb; border-radius: 0.5rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); overflow: hidden; }
@media (min-width: 1024px) {
    .announcement-card { min-width: 650px; }
}
.announcement-header { border-bottom: 1px solid #e5e7eb; }
.school-info { display: flex; align-items: center; gap: 0.75rem; padding: 1rem; }
.school-avatar { width: 3rem; height: 3rem; border-radius: 50%; object-fit: cover; }
.school-details { display: flex; flex-direction: column; }
.school-name { font-weight: bold; font-size: 1.125rem; color: #111827; }
.post-meta { display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #6b7280; }
.separator { color: #9ca3af; }
.announcement-content { padding: 1rem; }
.announcement-title { font-weight: 600; font-size: 1.25rem; margin-bottom: 0.75rem; color: #111827; line-height: 1.25; }
.announcement-text { color: #374151; font-size: 1rem; margin-bottom: 1rem; line-height: 1.625; }
.see-more-btn, .see-less-btn { color: #2563eb; font-weight: 500; cursor: pointer; background: none; border: none; padding: 0; margin-left: 0.25rem; transition: color 0.2s; }
.see-more-btn:hover, .see-less-btn:hover { color: #1d4ed8; }
.image-gallery { margin-bottom: 1rem; }
.gallery-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.5rem; }
.gallery-single { display: grid; gap: 0.5rem; }
.gallery-item { position: relative; aspect-ratio: 1; background-color: #f3f4f6; border-radius: 0.5rem; overflow: hidden; }
.gallery-image { width: 100%; height: 100%; object-fit: cover; transition: transform 0.2s; cursor: pointer; }
.gallery-image:hover { transform: scale(1.05); }
.image-overlay { position: absolute; inset: 0; background-color: rgba(0, 0, 0, 0.6); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background-color 0.2s; }
.image-overlay:hover { background-color: rgba(0, 0, 0, 0.7); }
.image-count { color: white; font-size: 1.875rem; font-weight: bold; }
.announcement-footer { display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 1rem; border-top: 1px solid #f3f4f6; font-size: 0.875rem; }
.comment-count-btn { color: #6b7280; cursor: pointer; background: none; border: none; transition: color 0.2s; }
.comment-count-btn:hover { color: #374151; }
.action-buttons { display: flex; justify-content: space-around; border-top: 1px solid #f3f4f6; padding: 0.5rem 0; }
.action-button-group { position: relative; display: flex; align-items: center; gap: 0.5rem; }
.action-button { display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; color: #6b7280; border-radius: 0.5rem; transition: all 0.2s; cursor: pointer; background: none; border: none; }
.action-button:hover { color: #374151; background-color: #f9fafb; transform: translateY(-1px); }
.action-label { font-size: 0.875rem; color: #6b7280; }
.image-modal { position: fixed; inset: 0; z-index: 50; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(2px); }
.modal-overlay { position: absolute; inset: 0; background-color: rgba(0, 0, 0, 0.9); }
.modal-content { position: relative; max-width: 56rem; max-height: 100%; padding: 1rem; }
.modal-close { position: absolute; top: 1rem; right: 1rem; color: white; font-size: 1.5rem; z-index: 10; cursor: pointer; background: none; border: none; transition: all 0.2s; padding: 0.5rem; border-radius: 50%; }
.modal-close:hover { color: #d1d5db; background-color: rgba(0, 0, 0, 0.5); }
.modal-nav { position: absolute; top: 50%; transform: translateY(-50%); color: white; font-size: 1.5rem; cursor: pointer; background: none; border: none; padding: 1rem; transition: all 0.2s; border-radius: 50%; }
.modal-nav:hover { color: #d1d5db; background-color: rgba(0, 0, 0, 0.5); transform: translateY(-50%) scale(1.1); }
.modal-prev { left: 1rem; }
.modal-next { right: 1rem; }
.modal-image { max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 0.5rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
.hidden { display: none !important; }
@media (max-width: 768px) {
    .announcement-card { min-width: 100%; margin: 0 0.5rem; }
    .gallery-grid { grid-template-columns: 1fr; }
    .modal-content { margin: 0 1rem; }
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
