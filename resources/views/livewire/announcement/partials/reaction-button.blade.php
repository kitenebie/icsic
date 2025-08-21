{{-- 
    Reusable reaction button component
    Props: $itemId, $type, $size (optional, defaults to 'medium')
--}}
@php
    $currentReaction = $this->current_react($itemId, $type);
    $sizeClasses = match($size ?? 'medium') {
        'small' => 'w-4 h-4',
        'medium' => 'w-5 h-5',
        'large' => 'w-6 h-6',
        default => 'w-5 h-5'
    };
    $popupSizeClasses = match($size ?? 'medium') {
        'small' => 'w-6 h-6',
        'medium' => 'w-8 h-8',
        'large' => 'w-10 h-10',
        default => 'w-8 h-8'
    };
@endphp

<div class="reaction-button-wrapper">
    <button 
        class="reaction-trigger-btn"
        data-item-id="{{ $itemId }}"
        data-type="{{ $type }}"
        aria-label="React to {{ $type }}"
    >
        @if ($currentReaction)
            <img 
                src="{{ $currentReaction }}" 
                alt="Current reaction" 
                class="current-reaction {{ $sizeClasses }}"
            />
        @else
            <i class="far fa-thumbs-up {{ $sizeClasses }}"></i>
        @endif
    </button>

    <!-- Reaction Popup -->
    <div class="reaction-popup-menu hidden" data-item-id="{{ $itemId }}">
        @foreach (['Like', 'Love', 'Haha', 'Care', 'Wow', 'Sad', 'Angry'] as $reaction)
            <button 
                class="reaction-option-btn"
                wire:click='react("{{ $reaction }}", {{ $itemId }}, "{{ $type }}")'
                aria-label="{{ $reaction }}"
                title="{{ $reaction }}"
                data-reaction="{{ strtolower($reaction) }}"
            >
                <img 
                    src="/build/img/{{ strtolower($reaction) }}.png" 
                    alt="{{ $reaction }}"
                    class="{{ $popupSizeClasses }}"
                />
            </button>
        @endforeach
    </div>
    <style>
    /* Facebook-style reaction button */
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
    
    /* Responsive adjustments */
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
    
    /* Dark mode support */
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
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
</div>