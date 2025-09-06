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
                style="{{ $sizeStyles }}"
            />
        @else
            <i class="far fa-thumbs-up" style="{{ $sizeStyles }}"></i>
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
                    style="{{ $popupSizeStyles }}"
                />
            </button>
        @endforeach
    </div>
</div>
