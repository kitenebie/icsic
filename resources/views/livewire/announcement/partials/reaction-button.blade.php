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
</div>

<style>
.reaction-button-wrapper {
    @apply relative inline-block;
}

.reaction-trigger-btn {
    @apply flex items-center gap-1 hover:text-gray-800 cursor-pointer bg-none border-none p-1 rounded transition-colors;
}

.reaction-trigger-btn:hover {
    @apply bg-gray-100;
}

.current-reaction {
    @apply object-contain;
}

.reaction-popup-menu {
    @apply absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 bg-white border rounded-full shadow-lg p-2 flex gap-1 z-50;
    @apply before:content-[''] before:absolute before:top-full before:left-1/2 before:transform before:-translate-x-1/2 before:w-0 before:h-0;
    @apply before:border-l-4 before:border-r-4 before:border-t-4 before:border-transparent before:border-t-white;
}

.reaction-option-btn {
    @apply p-1 hover:scale-110 transition-transform cursor-pointer bg-none border-none rounded;
}

.reaction-option-btn:hover {
    @apply bg-gray-50;
}

@media (max-width: 768px) {
    .reaction-popup-menu {
        @apply bottom-auto top-full mt-2 mb-0;
        @apply before:top-auto before:bottom-full before:border-t-0 before:border-b-4 before:border-b-white;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle reaction popup visibility
    const triggers = document.querySelectorAll('.reaction-trigger-btn');
    
    triggers.forEach(trigger => {
        const itemId = trigger.dataset.itemId;
        const popup = document.querySelector(`.reaction-popup-menu[data-item-id="${itemId}"]`);
        
        if (popup) {
            let showTimeout;
            
            trigger.addEventListener('mouseenter', function() {
                showTimeout = setTimeout(() => {
                    // Hide all other popups first
                    document.querySelectorAll('.reaction-popup-menu').forEach(p => {
                        p.classList.add('hidden');
                    });
                    popup.classList.remove('hidden');
                }, 500);
            });
            
            trigger.addEventListener('mouseleave', function() {
                clearTimeout(showTimeout);
                setTimeout(() => {
                    if (!popup.matches(':hover')) {
                        popup.classList.add('hidden');
                    }
                }, 100);
            });
            
            popup.addEventListener('mouseleave', function() {
                popup.classList.add('hidden');
            });
            
            // Mobile touch support
            trigger.addEventListener('touchstart', function(e) {
                e.preventDefault();
                const isVisible = !popup.classList.contains('hidden');
                
                // Hide all popups
                document.querySelectorAll('.reaction-popup-menu').forEach(p => {
                    p.classList.add('hidden');
                });
                
                // Show this popup if it wasn't visible
                if (!isVisible) {
                    popup.classList.remove('hidden');
                }
            });
        }
    });
    
    // Close popups when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.reaction-button-wrapper')) {
            document.querySelectorAll('.reaction-popup-menu').forEach(popup => {
                popup.classList.add('hidden');
            });
        }
    });
});
</script>