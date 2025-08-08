<span class="flex items-center gap-2">
    <button wire:click='toggleLike' aria-label="Like comment" class="flex items-center gap-1 hover:text-[#2CAC5B] focus:outline-none"
        type="button">
        <i class="@if($this->isLike) fas @else far @endif fa-thumbs-up">
        </i>
        {{ $this->LikeCounts() }}
    </button>
    <button wire:click='toggleDislike' aria-label="Dislike comment" class="flex items-center gap-1 hover:text-[#2CAC5B] focus:outline-none"
        type="button">
        <i class="@if($this->isDislike) fas @else far @endif fa-thumbs-down">
        </i>
        {{ $this->DislikeCounts() }}
    </button>
</span>
