<x-layouts.custome.header style="background-color: #f0f2f5 !important">
    <x-modal />
    @livewire('announcement.main')
    <script src="/build/js/announcement.js"></script>
    {{-- @livewire('announcement.comments') --}}
    <style>
        .facebook-newsfeed {
            min-height: 100vh;
            background-color: #f0f2f5;
            padding: 16px 0;
            max-width: 680px;
            margin: 0 auto;
        }

        /* Create Post Section */
        .create-post-card {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            margin-bottom: 16px;
            padding: 12px 16px;
        }

        .create-post-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .create-post-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .create-post-input {
            flex: 1;
        }

        .fake-input {
            width: 100%;
            background: #f0f2f5;
            border: none;
            border-radius: 24px;
            padding: 12px 16px;
            font-size: 16px;
            color: #65676b;
            cursor: pointer;
            text-align: left;
            transition: background-color 0.2s;
        }

        .fake-input:hover {
            background: #e4e6ea;
        }

        .create-post-actions {
            display: flex;
            border-top: 1px solid #e4e6ea;
            padding-top: 8px;
            gap: 4px;
        }

        .create-action {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 8px 4px;
            background: none;
            border: none;
            border-radius: 6px;
            color: #65676b;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .create-action:hover {
            background: #f2f3f4;
        }

        .create-action .text-red-500 {
            color: #ef4444;
        }

        .create-action .text-green-500 {
            color: #10b981;
        }

        .create-action .text-yellow-500 {
            color: #f59e0b;
        }

        /* Stories Section */
        .stories-section {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
            padding: 0 4px;
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .stories-section::-webkit-scrollbar {
            display: none;
        }

        .story {
            flex: 0 0 112px;
            height: 200px;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .story:hover {
            transform: scale(1.02);
        }

        .story-background {
            width: 100%;
            height: 100%;
            position: relative;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .create-story .story-background {
            background: #ffffff;
            border: 1px solid #e4e6ea;
            align-items: center;
            justify-content: center;
        }

        .story-avatar-bg {
            width: 100%;
            height: 70%;
            object-fit: cover;
        }

        .story-create-overlay {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 16px;
        }

        .story-create-icon {
            width: 40px;
            height: 40px;
            background: #1877f2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .story-create-text {
            font-size: 12px;
            font-weight: 600;
            color: #050505;
            text-align: center;
        }

        .story-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 3px solid white;
            position: absolute;
            top: 12px;
            left: 12px;
        }

        .story-name {
            position: absolute;
            bottom: 12px;
            left: 12px;
            color: white;
            font-size: 13px;
            font-weight: 600;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.8);
        }

        /* Posts Container */
        .posts-container {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* Facebook Post Styles */
        .facebook-post {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        /* Post Header */
        .post-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 12px 16px;
        }

        .post-author-info {
            display: flex;
            gap: 12px;
            flex: 1;
        }

        .post-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .post-meta-info {
            flex: 1;
        }

        .post-author-name {
            font-size: 15px;
            font-weight: 600;
            color: #050505;
            margin: 0;
            line-height: 1.3333;
        }

        .post-time-privacy {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 13px;
            color: #65676b;
            margin-top: 2px;
        }

        .meta-separator {
            margin: 0 2px;
        }

        .meta-icon {
            font-size: 12px;
        }

        .post-options-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: none;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #65676b;
            transition: background-color 0.2s;
        }

        .post-options-btn:hover {
            background: #f2f3f4;
        }

        /* Post Content */
        .post-content {
            padding: 0 16px 12px;
        }

        .post-title {
            font-size: 20px;
            font-weight: 600;
            color: #050505;
            margin: 0 0 8px 0;
            line-height: 1.2;
        }

        .post-text {
            font-size: 16px;
            line-height: 1.3333;
            color: #050505;
        }

        .see-more-link {
            color: #65676b;
            font-weight: 600;
            background: none;
            border: none;
            cursor: pointer;
            margin-left: 4px;
            font-size: 16px;
        }

        .see-more-link:hover {
            text-decoration: underline;
        }

        /* Post Images */
        .post-images {
            margin-bottom: 12px;
        }

        .images-container {
            display: grid;
            gap: 2px;
        }

        .single-image {
            grid-template-columns: 1fr;
        }

        .multi-image {
            grid-template-columns: repeat(2, 1fr);
        }

        .image-wrapper {
            position: relative;
            aspect-ratio: 1;
            overflow: hidden;
            background: #f0f2f5;
        }

        .single-image .image-wrapper {
            aspect-ratio: 16/9;
            max-height: 500px;
        }

        .small-image {
            aspect-ratio: 1;
        }

        .post-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .post-image:hover {
            transform: scale(1.02);
        }

        .more-images-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .more-count {
            color: white;
            font-size: 32px;
            font-weight: 600;
        }

        /* Post Stats */
        .post-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 16px;
            border-bottom: 1px solid #e4e6ea;
        }

        .post-stats-right {
            display: flex;
            gap: 16px;
        }

        .stats-button {
            background: none;
            border: none;
            color: #65676b;
            font-size: 15px;
            cursor: pointer;
            padding: 0;
        }

        .stats-button:hover {
            text-decoration: underline;
        }

        /* Post Actions */
        .post-actions {
            display: flex;
            padding: 4px;
            gap: 4px;
        }

        .action-button-wrapper,
        .action-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 6px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            color: #65676b;
            transition: background-color 0.2s;
        }

        .action-button-wrapper:hover,
        .action-btn:hover {
            background: #f2f3f4;
        }

        .action-text {
            font-size: 15px;
            font-weight: 600;
        }

        /* Empty Feed */
        .empty-feed {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 64px 32px;
            text-align: center;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .empty-icon {
            font-size: 48px;
            color: #65676b;
            margin-bottom: 16px;
        }

        .empty-title {
            font-size: 20px;
            font-weight: 600;
            color: #050505;
            margin: 0 0 8px 0;
        }

        .empty-text {
            color: #65676b;
            font-size: 16px;
            margin: 0;
        }

        /* Reaction Summary Updates */
        .reaction-summary-container {
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

        /* Image Modal */
        .image-modal {
            position: fixed;
            inset: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-overlay {
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.9);
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
            /* object-fit: contain; */
            border-radius: 8px;
        }

        .hidden {
            display: none !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .facebook-newsfeed {
                padding: 8px;
                max-width: 100%;
            }

            .facebook-post {
                border-radius: 0;
                margin-left: -8px;
                margin-right: -8px;
            }

            .create-post-card {
                border-radius: 0;
                margin-left: -8px;
                margin-right: -8px;
            }

            .stories-section {
                margin-left: -8px;
                margin-right: -8px;
                padding: 0 8px;
            }

            .story {
                flex: 0 0 100px;
                height: 180px;
            }

            .create-action {
                flex-direction: column;
                gap: 4px;
                font-size: 12px;
            }

            .create-action i {
                font-size: 20px;
            }

            .modal-content {
                margin: 16px;
            }
        }

        /* Dark Mode Support */
        /* @media (prefers-color-scheme: dark) {
            body {
                background-color: #18191a;
                color: #e4e6ea;
            }

            .facebook-newsfeed {
                background-color: #18191a;
            }

            .create-post-card,
            .facebook-post {
                background-color: #242526;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.4);
            }

            .fake-input {
                background-color: #3a3b3c;
                color: #b0b3b8;
            }

            .fake-input:hover {
                background-color: #4e4f50;
            }

            .create-action {
                color: #b0b3b8;
            }

            .create-action:hover {
                background-color: #3a3b3c;
            }

            .post-author-name {
                color: #e4e6ea;
            }

            .post-title,
            .post-text {
                color: #e4e6ea;
            }

            .post-time-privacy,
            .stats-button,
            .action-btn,
            .action-text {
                color: #b0b3b8;
            }

            .post-options-btn:hover,
            .action-btn:hover {
                background-color: #3a3b3c;
            }

            .post-stats {
                border-bottom-color: #3e4042;
            }

            .create-post-actions {
                border-top-color: #3e4042;
            }

            .see-more-link {
                color: #b0b3b8;
            }

            .empty-feed {
                background-color: #242526;
            }

            .empty-title {
                color: #e4e6ea;
            }

            .empty-icon,
            .empty-text {
                color: #b0b3b8;
            }
        } */

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
            filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.1));
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
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .reaction-option-btn {
            width: 20px;
            height: 27px;
            padding: 2px;
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
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .reaction-option-btn:hover img {
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3)) saturate(1.2) brightness(1.1);
        }

        /* Responsive adjustments for reaction buttons */
        @media (max-width: 768px) {
            .reaction-popup-menu {
                position: absolute;
                bottom: calc(100% + 8px);
                left: 80%;
                transform: translateX(-30%);
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
        }

        /* Dark mode support for reaction buttons */
        /* @media (prefers-color-scheme: dark) {
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
        } */
    </style>

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
                    switch (e.key) {
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
window.sharePost = function (postId, title, content) {
    const postUrl = `announcements#${postId}`;
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
                <button onclick="shareToFacebook('${url}', '${encodeURIComponent(title)}', '${encodeURIComponent(text)}')">
                    <i class="fab fa-facebook-f"></i>
                    <span>Facebook</span>
                </button>
                <button onclick="shareToTwitter('${url}', '${encodeURIComponent(text)}')">
                    <i class="fab fa-twitter"></i>
                    <span>Twitter</span>
                </button>
                <button onclick="shareToWhatsApp('${encodeURIComponent(text)}', '${url}')">
                    <i class="fab fa-whatsapp"></i>
                    <span>WhatsApp</span>
                </button>
                <button onclick="copyToClipboard(event, '${url}')">
                    <i class="fas fa-link"></i>
                    <span>Copy Link</span>
                </button>
            </div>
        </div>
    `;

    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
}

// 🟢 FIX: pass event
window.copyToClipboard = function (event, url) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(url).then(() => {
            const button = event.target.closest('button');
            showCopiedState(button);
        }).catch(() => {
            fallbackCopyToClipboard(event, url);
        });
    } else {
        fallbackCopyToClipboard(event, url);
    }
};

function fallbackCopyToClipboard(event, text) {
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
        showCopiedState(button);
    } catch (err) {
        console.error('Could not copy text: ', err);
        alert('Could not copy link. Please copy manually: ' + text);
    }

    document.body.removeChild(textArea);
}

// 🔥 extract copied state for reusability
function showCopiedState(button) {
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
}

window.shareToFacebook = function (url, title, text) {
    const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}&quote=${decodeURIComponent(text)}`;
    window.open(facebookUrl, 'facebook-share', 'width=580,height=400,scrollbars=yes,resizable=yes');
    closeShareModal();
};

window.shareToTwitter = function (url, text) {
    const twitterUrl = `https://twitter.com/intent/tweet?text=${decodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
    window.open(twitterUrl, 'twitter-share', 'width=580,height=400,scrollbars=yes,resizable=yes');
    closeShareModal();
};

window.shareToWhatsApp = function (text, url) {
    const whatsappText = `${decodeURIComponent(text)} ${url}`;
    const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(whatsappText)}`;
    window.open(whatsappUrl, '_blank');
    closeShareModal();
};

window.closeShareModal = function () {
    const modal = document.querySelector('.share-modal');
    if (modal) {
        modal.remove();
        document.body.style.overflow = 'auto';
    }
};

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

    <style>
        .comments-modal {
            position: fixed;
            inset: 0;
            z-index: 1000;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.171);
            backdrop-filter: blur(4px);
        }

        .modal-overlay {
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.6);
        }

        .comments-container {
            background-color: #FFFFFF2F;
            display: flex;
            flex-direction: column;
            height: 90%;
            width: 100%;
            max-width: 500px;
            margin-left: auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Desktop behavior */
        @media (min-width: 1024px) {
            .comments-modal {
                position: fixed;
                /* keep it floating */
                inset: auto;
                /* remove full overlay */
                top: 0;
                right: 0;
                /* stick to the right */
                height: 100vh;
                width: auto;
                z-index: 9999;
                background: none;
                backdrop-filter: none;
            }

            .modal-overlay {
                display: none;
                /* no dark overlay on desktop */
            }

            .comments-container {
                position: fixed;
                /* pin container */
                right: 0;
                /* right side */
                top: 0;
                /* from top */
                height: 100vh;
                /* full height */
                width: 400px;
                /* adjust width */
                max-width: 400px;
                border-radius: 0;
                /* remove rounded corners if you want full side */
                overflow: hidden;
                box-shadow: -2px 0 8px rgba(0, 0, 0, 0.15);
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
        /* @media (prefers-color-scheme: dark) {

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
        } */
    </style>

</x-layouts.custome.header>
