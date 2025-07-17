<!-- Most Read -->
<section class="bg-white border rounded-lg p-6 flex-1 shadow-sm">
    @if ($newsTrends->where('reads', '>', 0)->isEmpty())
        <p class="text-gray-400">No trending news with reads available.</p>
    @else
        @forelse($newsTrends as $index => $trend)
            <div class="flex mt-4 items-start gap-4">
                <span class="text-green-600 font-extrabold text-lg min-w-[2rem]">
                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                </span>
                <div>
                    <p class="font-semibold leading-tight">{{ $trend->title }}</p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ number_format($trend->reads) }} reads &bull; {{ $trend->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        @empty
            <li class="text-gray-400">No trending news available.</li>
        @endforelse
    @endif
</section>
