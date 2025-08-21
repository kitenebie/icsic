
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