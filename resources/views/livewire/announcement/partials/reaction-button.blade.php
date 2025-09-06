@php
    $currentReaction = $this->current_react($itemId, $type);

    $sizeStyles = match($size ?? 'medium') {
        'small' => 'width: 16px; height: 16px;',   // w-4 h-4
        'medium' => 'width: 20px; height: 20px;',  // w-5 h-5
        'large' => 'width: 24px; height: 24px;',   // w-6 h-6
        default => 'width: 20px; height: 20px;'
    };

    $popupSizeStyles = match($size ?? 'medium') {
        'small' => 'width: 24px; height: 24px;',   // w-6 h-6
        'medium' => 'width: 32px; height: 32px;',  // w-8 h-8
        'large' => 'width: 40px; height: 40px;',   // w-10 h-10
        default => 'width: 32px; height: 32px;'
    };
@endphp

<div class="reaction-button-wrapper" style="position: relative; display: inline-block;">
    <button
        type="button"
        class="reaction-trigger-btn"
        data-item-id="{{ $itemId }}"
        data-type="{{ $type }}"
        aria-label="React to {{ $type }}"
        style="background: none; border: none; padding: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center;"
    >
        @if ($currentReaction)
            <img
                src="{{ $currentReaction }}"
                alt="Current reaction"
                style="{{ $sizeStyles }} object-fit: contain;"
            />
        @else
            <i class="far fa-thumbs-up" style="{{ $sizeStyles }} color: #65676B;"></i>
        @endif
    </button>

    <!-- Reaction Popup -->
    <div 
        class="reaction-popup-menu hidden" 
        data-item-id="{{ $itemId }}"
        style="
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            border: 1px solid #ddd;
            border-radius: 25px;
            padding: 8px;
            display: flex;
            gap: 4px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
            margin-bottom: 8px;
            white-space: nowrap;
        "
    >
        @foreach (['Like', 'Love', 'Haha', 'Care', 'Wow', 'Sad', 'Angry'] as $reaction)
            <button
                type="button"
                class="reaction-option-btn"
                wire:click.stop.prevent='react("{{ $reaction }}", {{ $itemId }}, "{{ $type }}")'
                aria-label="{{ $reaction }}"
                title="{{ $reaction }}"
                data-reaction="{{ strtolower($reaction) }}"
                style="
                    background: none;
                    border: none;
                    padding: 4px;
                    cursor: pointer;
                    border-radius: 50%;
                    transition: transform 0.1s ease;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                "
                onmouseover="this.style.transform='scale(1.2)'"
                onmouseout="this.style.transform='scale(1)'"
            >
                <img
                    src="/build/img/{{ strtolower($reaction) }}.png"
                    alt="{{ $reaction }}"
                    style="{{ $popupSizeStyles }} object-fit: contain;"
                />
            </button>
        @endforeach
    </div>
</div>

<style>
.reaction-popup-menu.hidden {
    display: none !important;
}

.reaction-popup-menu:not(.hidden) {
    display: flex !important;
}

/* Arrow pointing down from popup */
.reaction-popup-menu:not(.hidden)::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-top: 8px solid white;
    filter: drop-shadow(0 2px 2px rgba(0,0,0,0.1));
}
</style>

<script>
// Improved reaction button functionality
document.addEventListener('DOMContentLoaded', function() {
    function initReactionButtons() {
        const wrappers = document.querySelectorAll('.reaction-button-wrapper');
        
        wrappers.forEach(wrapper => {
            const btn = wrapper.querySelector('.reaction-trigger-btn');
            const popup = wrapper.querySelector('.reaction-popup-menu');
            
            if (!btn || !popup) return;
            
            // Remove existing event listeners to prevent duplicates
            btn.onmouseenter = null;
            btn.onmouseleave = null;
            btn.onclick = null;
            wrapper.onmouseleave = null;
            
            let hoverTimeout;
            
            // Show popup on hover
            btn.addEventListener('mouseenter', function() {
                clearTimeout(hoverTimeout);
                // Close all other popups first
                document.querySelectorAll('.reaction-popup-menu').forEach(p => {
                    if (p !== popup) p.classList.add('hidden');
                });
                popup.classList.remove('hidden');
            });
            
            // Hide popup when leaving the entire wrapper
            wrapper.addEventListener('mouseleave', function() {
                hoverTimeout = setTimeout(() => {
                    popup.classList.add('hidden');
                }, 100); // Small delay to prevent flickering
            });
            
            // Keep popup open when hovering over it
            popup.addEventListener('mouseenter', function() {
                clearTimeout(hoverTimeout);
            });
            
            // Hide when leaving popup
            popup.addEventListener('mouseleave', function() {
                popup.classList.add('hidden');
            });
            
            // Toggle on click (for touch devices)
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const isHidden = popup.classList.contains('hidden');
                
                // Close all other popups
                document.querySelectorAll('.reaction-popup-menu').forEach(p => {
                    p.classList.add('hidden');
                });
                
                // Toggle current popup
                if (isHidden) {
                    popup.classList.remove('hidden');
                } else {
                    popup.classList.add('hidden');
                }
            });
        });
    }
    
    // Initialize on page load
    initReactionButtons();
    
    // Re-initialize after Livewire updates
    if (window.Livewire) {
        document.addEventListener('livewire:load', initReactionButtons);
        document.addEventListener('livewire:update', initReactionButtons);
        
        if (window.Livewire.hook) {
            window.Livewire.hook('message.processed', () => {
                setTimeout(initReactionButtons, 50);
            });
        }
    }
    
    // Close all popups when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.reaction-button-wrapper')) {
            document.querySelectorAll('.reaction-popup-menu').forEach(popup => {
                popup.classList.add('hidden');
            });
        }
    });
});
</script>