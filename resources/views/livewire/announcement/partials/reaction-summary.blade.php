
@php
    $reactions = $this->emojies_react($itemId, $type);
    $totalReacts = $this->total_reacts($itemId, $type);

    $emojiMap = [
        'like' => '👍',
        'love' => '❤️',
        'haha' => '😂',
        'care' => '🤗',
        'wow'  => '😮',
        'sad'  => '😢',
        'angry'=> '😡',
    ];
@endphp

@if ($reactions->isNotEmpty() || $totalReacts > 0)
    <div class="reaction-summary-container">
        <div class="reaction-emojis">
            @foreach ($reactions as $index => $emoji)
                @php
                    $key = strtolower($emoji->react);
                    $file = public_path('build/img/' . $key . '.png');
                    $src  = file_exists($file) ? '/build/img/' . $key . '.png' : null;
                    $char = $emojiMap[$key] ?? '👍';
                @endphp

                @if ($src)
                    <img
                        src="{{ $src }}"
                        alt="{{ $emoji->react }}"
                        class="reaction-emoji {{ $index > 0 ? 'overlapped' : '' }}"
                        title="{{ $emoji->react }}"
                    />
                @else
                    <span
                        class="reaction-emoji {{ $index > 0 ? 'overlapped' : '' }}"
                        title="{{ ucfirst($key) }}"
                        aria-hidden="true"
                        style="display:inline-flex;align-items:center;justify-content:center;font-size:14px;width:18px;height:18px;"
                    >{{ $char }}</span>
                @endif
            @endforeach
        </div>
        
        @if ($totalReacts > 0)
            <span class="reaction-count" title="{{ $totalReacts }} {{ Str::plural('reaction', $totalReacts) }}">
                {{ $totalReacts }}
            </span>
        @endif
    </div>
@endif