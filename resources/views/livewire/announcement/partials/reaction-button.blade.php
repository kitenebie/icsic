@php
    $currentReaction = $this->current_react($itemId, $type);

    $sizeStyles = match($size ?? 'medium') {
        'small' => 'width: 16px; height: 16px;',
        'medium' => 'width: 20px; height: 20px;',
        'large' => 'width: 24px; height: 24px;',
        default => 'width: 20px; height: 20px;'
    };

    $popupSizeStyles = match($size ?? 'medium') {
        'small' => 'width: 24px; height: 24px;',
        'medium' => 'width: 32px; height: 32px;',
        'large' => 'width: 40px; height: 40px;',
        default => 'width: 32px; height: 32px;'
    };
@endphp

<div class="reaction-wrapper" 
     onmouseenter="showReactionPopup(this)" 
     onmouseleave="hideReactionPopup(this)"
     style="position: relative; display: inline-block;">
    
    <button type="button" 
            class="reaction-btn"
            style="background: none; border: none; padding: 4px; cursor: pointer; border-radius: 4px;">
        @if ($currentReaction)
            <img src="{{ $currentReaction }}" 
                 alt="Current reaction" 
                 style="{{ $sizeStyles }}" />
        @else
            <i class="far fa-thumbs-up" style="{{ $sizeStyles }} color: #65676B;"></i>
        @endif
    </button>

    <div class="reaction-popup" 
         style="position: absolute; 
                bottom: calc(100% + 8px); 
                left: 50%; 
                transform: translateX(-50%); 
                background: white; 
                border: 1px solid #ddd; 
                border-radius: 25px; 
                padding: 6px; 
                display: none; 
                flex-direction: row; 
                gap: 4px; 
                box-shadow: 0 2px 8px rgba(0,0,0,0.15); 
                z-index: 99999;
                white-space: nowrap;">
        
        @foreach (['Like', 'Love', 'Haha', 'Care', 'Wow', 'Sad', 'Angry'] as $reaction)
            <button type="button" 
                    wire:click='react("{{ $reaction }}", {{ $itemId }}, "{{ $type }}")'
                    style="background: none; 
                           border: none; 
                           padding: 2px; 
                           cursor: pointer; 
                           border-radius: 50%; 
                           transition: transform 0.1s;"
                    onmouseover="this.style.transform='scale(1.2)'" 
                    onmouseout="this.style.transform='scale(1)'"
                    title="{{ $reaction }}">
                <img src="/build/img/{{ strtolower($reaction) }}.png" 
                     alt="{{ $reaction }}" 
                     style="{{ $popupSizeStyles }}" />
            </button>
        @endforeach
    </div>
</div>

<script>
function showReactionPopup(wrapper) {
    const popup = wrapper.querySelector('.reaction-popup');
    if (popup) {
        popup.style.display = 'flex';
    }
}

function hideReactionPopup(wrapper) {
    const popup = wrapper.querySelector('.reaction-popup');
    if (popup) {
        popup.style.display = 'none';
    }
}

// Close all popups when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.reaction-wrapper')) {
        document.querySelectorAll('.reaction-popup').forEach(popup => {
            popup.style.display = 'none';
        });
    }
});
</script>