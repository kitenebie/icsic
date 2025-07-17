<nav class="flex items-center overflow-x-scroll max-w-5xl space-x-3 mt-4 md:mt-0 hide-scrollbar hide-scrollbar::-webkit-scrollbar">
    <button class="text-[#2CAC5B] bg-[#EFF8F2] text-sm font-medium rounded-full px-3 py-1" type="button">
        All
    </button>
    @forelse ($this->getRelivantTopics() as $item)
        <button class="text-[#475569] bg-[#EFF8F2] text-sm font-normal rounded-full px-3 py-1" type="button">
            {{ $item }}
        </button>
    @empty
        <!-- Optional: fallback message or empty state -->
    @endforelse
</nav>
