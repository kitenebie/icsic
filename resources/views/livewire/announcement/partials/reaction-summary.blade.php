{{-- 
    Reusable reaction summary component
    Props: $itemId, $type
--}}
@php
    $reactions = $this->emojies_react($itemId, $type);
    $totalReacts = $this->total_reacts($itemId, $type);
@endphp

@if ($reactions->isNotEmpty() || $totalReacts > 0)
    <div class="reaction-summary-container">
        <div class="reaction-emojis">
            @foreach ($reactions as $index => $emoji)
                <img 
                    src="/build/img/{{ strtolower($emoji->react) }}.png" 
                    alt="{{ $emoji->react }}"
                    class="reaction-emoji {{ $index > 0 ? 'overlapped' : '' }}"
                    title="{{ $emoji->react }}"
                />
            @endforeach
        </div>
        
        @if ($totalReacts > 0)
            <span class="reaction-count" title="{{ $totalReacts }} {{ Str::plural('reaction', $totalReacts) }}">
                {{ $totalReacts }}
            </span>
        @endif
    </div>
@endif

<style>
.reaction-summary-container {
    @apply bg-white border border-gray-200 rounded-full px-2 py-1 flex items-center gap-1 shadow-sm float-right -mt-6 mr-1 relative z-10;
}

.reaction-emojis {
    @apply flex items-center;
}

.reaction-emoji {
    @apply w-4 h-4 rounded-full border border-white;
}

.reaction-emoji.overlapped {
    @apply -ml-1;
}

.reaction-count {
    @apply text-xs text-gray-600 font-medium min-w-[1rem] text-center;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .reaction-summary-container {
        @apply bg-gray-700 border-gray-600;
    }
    
    .reaction-count {
        @apply text-gray-300;
    }
    
    .reaction-emoji {
        @apply border-gray-700;
    }
}
</style>