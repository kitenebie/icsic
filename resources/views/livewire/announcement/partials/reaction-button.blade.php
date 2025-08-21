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
.reaction-button-wrapper { position: relative; display: inline-block; }
.reaction-trigger-btn { display: flex; align-items: center; gap: 0.25rem; cursor: pointer; background: none; border: none; padding: 0.25rem; border-radius: 0.25rem; transition: all 0.2s; color: #6b7280; }
.reaction-trigger-btn:hover { color: #374151; background-color: #f3f4f6; }
.current-reaction { object-fit: contain; }
.reaction-popup-menu { position: absolute; bottom: 100%; margin-bottom: 0.5rem; left: 50%; transform: translateX(-50%); background-color: white; border: 1px solid #e5e7eb; border-radius: 9999px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); padding: 0.5rem; display: flex; gap: 0.25rem; z-index: 50; }
.reaction-popup-menu::after { content: ''; position: absolute; top: 100%; left: 50%; transform: translateX(-50%); width: 0; height: 0; border-left: 4px solid transparent; border-right: 4px solid transparent; border-top: 4px solid white; }
.reaction-option-btn { padding: 0.25rem; transition: transform 0.2s; cursor: pointer; background: none; border: none; border-radius: 0.25rem; }
.reaction-option-btn:hover { transform: scale(1.1); background-color: #f9fafb; }
@media (max-width: 768px) {
    .reaction-popup-menu { bottom: auto; top: 100%; margin-bottom: 0; margin-top: 0.5rem; }
    .reaction-popup-menu::after { top: auto; bottom: 100%; border-top: 0; border-bottom: 4px solid white; }
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