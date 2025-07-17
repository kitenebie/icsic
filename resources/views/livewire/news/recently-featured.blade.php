<section class="bg-white border rounded-lg p-6 flex-1 shadow-sm">
    <h3 class="font-extrabold mb-4 text-slate-900">Recently Featured</h3>
    <ul class="space-y-6">
        @forelse($featured as $item)
            <li>
                <div class="flex items-center gap-4">
                    @if($item->image)
                        <img src="/storage/{{ $item->image }}" alt="{{ $item->title ?? 'Featured image' }}" class="w-12 h-12 object-cover rounded-lg shrink-0" />
                    @endif
                    <div>
                        <p class="text-xs font-semibold {{ $item->category_color ?? 'text-gray-600' }} uppercase mb-1">
                            {{ $item->category ?? 'Category' }}
                        </p>
                        <p class="font-semibold leading-tight">
                            {{ $item->title ?? 'Untitled' }}
                        </p>
                    </div>
                </div>
                @if(!$loop->last)
                    <hr class="mt-4 border-t border-gray-200" />
                @endif
            </li>
        @empty
            <li class="text-gray-500 text-sm">No featured items found.</li>
        @endforelse
    </ul>
</section>