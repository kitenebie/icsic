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
.reaction-summary-container { background-color: white; border: 1px solid #e5e7eb; border-radius: 9999px; padding: 0.25rem 0.5rem; display: flex; align-items: center; gap: 0.25rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); float: right; margin-top: -1.5rem; margin-right: 0.25rem; position: relative; z-index: 10; }
.reaction-emojis { display: flex; align-items: center; }
.reaction-emoji { width: 1rem; height: 1rem; border-radius: 50%; border: 1px solid white; }
.reaction-emoji.overlapped { margin-left: -0.25rem; }
.reaction-count { font-size: 0.75rem; color: #4b5563; font-weight: 500; min-width: 1rem; text-align: center; }
@media (prefers-color-scheme: dark) {
    .reaction-summary-container { background-color: #374151; border-color: #4b5563; }
    .reaction-count { color: #d1d5db; }
    .reaction-emoji { border-color: #374151; }
}
</style>