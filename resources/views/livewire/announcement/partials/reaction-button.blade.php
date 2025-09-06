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
        style="background: none; border: none; cursor: pointer; padding: 4px;"
    >
        @if ($currentReaction)
            <img
                src="{{ $currentReaction }}"
                alt="Current reaction"
                style="{{ $sizeStyles }}"
            />
        @else
            <i class="far fa-thumbs-up" style="{{ $sizeStyles }}"></i>
        @endif
    </button>

    <!-- Reaction Popup -->
    <div class="reaction-popup-menu hidden" 
         data-item-id="{{ $itemId }}"
         style="position: absolute; 
                bottom: 100%; 
                left: 50%; 
                transform: translateX(-50%);
                background: white;
                border-radius: 25px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.15);
                padding: 8px 12px;
                display: flex;
                gap: 4px;
                z-index: 1000;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.2s ease, visibility 0.2s ease, transform 0.2s ease;
                transform: translateX(-50%) translateY(-10px) scale(0.8);
                margin-bottom: 8px;">
        @foreach (['Like', 'Love', 'Haha', 'Care', 'Wow', 'Sad', 'Angry'] as $reaction)
            <button
                type="button"
                class="reaction-option-btn"
                wire:click.stop.prevent='react("{{ $reaction }}", {{ $itemId }}, "{{ $type }}")'
                aria-label="{{ $reaction }}"
                title="{{ $reaction }}"
                data-reaction="{{ strtolower($reaction) }}"
                style="background: none; 
                       border: none; 
                       cursor: pointer; 
                       padding: 4px;
                       border-radius: 50%;
                       transition: transform 0.1s ease;
                       display: flex;
                       align-items: center;
                       justify-content: center;"
                onmouseover="this.style.transform='scale(1.3)'"
                onmouseout="this.style.transform='scale(1)'"
            >
                <img
                    src="/build/img/{{ strtolower($reaction) }}.png"
                    alt="{{ $reaction }}"
                    style="{{ $popupSizeStyles }}"
                />
            </button>
        @endforeach
    </div>
</div>

<style>
.reaction-popup-menu.show {
    opacity: 1 !important;
    visibility: visible !important;
    transform: translateX(-50%) translateY(0) scale(1) !important;
}

.reaction-trigger-btn:hover {
    transform: scale(1.1);
    transition: transform 0.1s ease;
}

.reaction-option-btn:active {
    transform: scale(0.9) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle reaction button clicks
    document.addEventListener('click', function(e) {
        const triggerBtn = e.target.closest('.reaction-trigger-btn');
        
        if (triggerBtn) {
            e.preventDefault();
            e.stopPropagation();
            
            const wrapper = triggerBtn.closest('.reaction-button-wrapper');
            const popup = wrapper.querySelector('.reaction-popup-menu');
            
            // Close any other open popups
            document.querySelectorAll('.reaction-popup-menu.show').forEach(otherPopup => {
                if (otherPopup !== popup) {
                    otherPopup.classList.remove('show');
                }
            });
            
            // Toggle current popup
            if (popup.classList.contains('show')) {
                popup.classList.remove('show');
            } else {
                popup.classList.add('show');
            }
        }
    });
    
    // Close popup when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.reaction-button-wrapper')) {
            document.querySelectorAll('.reaction-popup-menu.show').forEach(popup => {
                popup.classList.remove('show');
            });
        }
    });
    
    // Handle reaction option clicks
    document.addEventListener('click', function(e) {
        const reactionBtn = e.target.closest('.reaction-option-btn');
        
        if (reactionBtn) {
            // Close the popup after selection
            setTimeout(() => {
                const popup = reactionBtn.closest('.reaction-popup-menu');
                if (popup) {
                    popup.classList.remove('show');
                }
            }, 100);
        }
    });
    
    // Optional: Close popup on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.reaction-popup-menu.show').forEach(popup => {
                popup.classList.remove('show');
            });
        }
    });
});
</script>