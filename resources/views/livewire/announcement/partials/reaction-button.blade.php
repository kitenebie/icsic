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