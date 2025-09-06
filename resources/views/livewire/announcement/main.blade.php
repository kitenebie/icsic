<div class="relative w-full bg-[#f0f2f5]">
    <div class="facebook-newsfeed">
        <!-- News Feed Posts -->
        <div class="posts-container">
            @forelse ($announcements as $announcement)
                <article id="announcement-{{ $announcement->id }}" class="facebook-post mt-12">
                    @section('meta')
                        <meta property="og:title" content="{{ $announcement->title }}" />
                        <meta property="og:description" content="{{ Str::limit(strip_tags($announcement->content), 150) }}" />
                        <meta property="og:image" content="{{ asset('storage/' . $announcement->image_path) }}" />
                        <meta property="og:url" content="{{ url()->current() }}" />
                        <meta property="og:type" content="article" />
                    @endsection
                    <!-- Post Header -->
                    <header id="{{ $announcement->id }}" class="post-header">
                        <div class="post-author-info">
                            <img src="https://storage.googleapis.com/a1aa/image/10e94bdc-c408-4a4f-44e0-cc6af4a3b589.jpg"
                                alt="Irosin Central School logo" class="post-avatar" />
                            <div class="post-meta-info">
                                <h3 class="post-author-name">Irosin Central School</h3>
                                <div class="post-time-privacy">
                                    <time datetime="{{ $announcement->created_at }}">
                                        {{ $this->formatDateHumanReadable($announcement->created_at) }}
                                    </time>
                                    <span class="meta-separator">·</span>
                                    @if ($announcement->tags)
                                        <i class="fas fa-users meta-icon" aria-label="Group post"
                                            title="Group post"></i>
                                    @else
                                        <i class="fas fa-globe-americas meta-icon" aria-label="Public post"
                                            title="Public post"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- <button class="post-options-btn" aria-label="Post options">
                            <i class="fas fa-ellipsis-h"></i>
                        </button> --}}
                    </header>

                    <!-- Post Content -->
                    <div class="post-content">
                        @if ($announcement->title && $announcement->title !== strip_tags($announcement->content))
                            <h4 class="post-title">{{ $announcement->title }}</h4>
                        @endif
                        <div class="post-text">
                            <div class="content-preview">
                                {!! \Illuminate\Support\Str::limit($announcement->content, 300, '') !!}
                                @if (strlen($announcement->content) > 300)
                                    <button class="see-more-link" onclick="toggleContent({{ $announcement->id }})">
                                        See more
                                    </button>
                                @endif
                            </div>
                            @if (strlen($announcement->content) > 300)
                                <div class="content-full hidden">
                                    {!! $announcement->content !!}
                                    <button class="see-more-link" onclick="toggleContent({{ $announcement->id }})">
                                        See less
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Post Images -->
                    @if (count($announcement->images) > 0)
                        <div class="post-images">
                            <div
                                class="images-container {{ count($announcement->images) >= 2 ? 'multi-image' : 'single-image' }}">
                                @php
                                    $imagesArray = array_map(
                                        fn($img) => asset('storage/' . $img),
                                        $announcement->images,
                                    );
                                @endphp

                                @foreach (array_slice($announcement->images, 0, count($announcement->images) >= 5 ? 4 : count($announcement->images)) as $index => $image)
                                    <div
                                        class="image-wrapper {{ count($announcement->images) >= 3 && $index >= 2 ? 'small-image' : '' }}">
                                        <img src="{{ asset('storage/' . $image) }}"
                                            alt="Post image {{ $index + 1 }}" class="post-image"
                                            onclick="openImageModal({{ json_encode($imagesArray) }}, {{ $index }})" />
                                        @if ($index === 3 && count($announcement->images) > 4)
                                            <div class="more-images-overlay"
                                                onclick="openImageModal({{ json_encode($imagesArray) }}, {{ $index }})">
                                                <span class="more-count">+{{ count($announcement->images) - 4 }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Post Reactions Summary -->
                    <div class="post-stats">
                        @include('livewire.announcement.partials.reaction-summary', [
                            'itemId' => $announcement->id,
                            'type' => 'post',
                        ])

                        <div class="post-stats-right">
                            @if ($this->commentCount($announcement->id))
                                <button class="stats-button" wire:click='openComment({{ $announcement->id }})'
                                    aria-label="View {{ $this->commentCount($announcement->id) }} comments">
                                    {{ $this->commentCount($announcement->id) }}
                                    {{ Str::plural('comment', $this->commentCount($announcement->id)) }}
                                </button>
                            @endif
                            {{-- <button class="stats-button"  >
                                2 shares
                            </button> --}}
                        </div>
                    </div>

                    <!-- Post Actions -->
                    <div class="post-actions">
                        <div class="action-button-wrapper">
                            @include('livewire.announcement.partials.reaction-button', [
                                'itemId' => $announcement->id,
                                'type' => 'post',
                                'size' => 'medium',
                            ])
                            <span class="action-text">Like</span>
                        </div>

                        <button class="action-btn" wire:click='openComment({{ $announcement->id }})'
                            aria-label="Comment on post">
                            <i class="far fa-comment"></i>
                            <span class="action-text">Comment</span>
                        </button>

                        <button class="action-btn"
                            onclick='sharePost({{ json_encode($announcement->id) }}, {{ json_encode($announcement->title) }}, {{ json_encode(strip_tags($announcement->content)) }})'
                            aria-label="Share post">
                            <i class="fas fa-share"></i>
                            <span class="action-text">Share</span>
                        </button>
                    </div>
                </article>
            @empty
                <div class="empty-feed">
                    <div class="empty-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h3 class="empty-title">No posts yet</h3>
                    <p class="empty-text">When there are new announcements, they'll appear here.</p>
                </div>
            @endforelse
        </div>

        <!-- Image Modal -->
        <div id="imageModal" class="image-modal hidden" role="dialog" aria-modal="true" aria-labelledby="modal-title">
            <div class="modal-overlay" onclick="closeImageModal()"></div>
            <button class="modal-close" onclick="closeImageModal()" aria-label="Close modal">
                <i class="fas fa-times"></i>
            </button>
            <div class="modal-content">
                <button class="modal-nav modal-prev" onclick="changeModalImage(-1)" aria-label="Previous image">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <img id="modalImage" src="" alt="Announcement image" class="modal-image" />
                <button class="modal-nav modal-next" onclick="changeModalImage(1)" aria-label="Next image">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Comment Modal Integration -->
    @if ($showCommentModal && $currentAnnouncementId)
        @livewire('announcement.comments', ['id' => $currentAnnouncementId], key('comments-'.$currentAnnouncementId))
    @endif

</div>
