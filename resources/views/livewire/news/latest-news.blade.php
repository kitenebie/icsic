<div id="news" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Card 1 -->
    @forelse ($latest as $News_item)
        <article class="bg-white rounded-lg shadow-sm border">
            <div class="bg-[#D7DEFF] rounded-t-lg flex justify-center items-center">
                <img  class="w-full h-full max-h-64 text-[#4F6BED]" height="48"
                    src="/storage/{{ $News_item->image }}"
                    width="48" />
            </div>
            <div class="p-6">
                <p class="text-[#4F6BED] text-xs font-semibold uppercase mb-1">
                    {{ $this->categories[$News_item->topic_category] }}
                </p>
                <h3 class="font-extrabold text-base leading-6 mb-3">
                    {{ $News_item->title }}
                </h3>
                <p class="text-[#64748B] text-sm leading-5 mb-6">
                    {!! Illuminate\Support\Str::limit($News_item->content[0]['Paragraph'][0]['content'], 168) !!}
                </p>
                <div class="flex mt-2 justify-between items-center text-[#64748B] text-xs">
                    <span>
                        {{ $this->formatDateHumanReadable($News_item->created_at) }}
                    </span>
                    <a href="/read/{{ Illuminate\Support\Str::random(100) }}/{{ $News_item->id }} " class="text-[#2CAC5B] font-medium hover:underline">
                        Read More →
                    </a>
                </div>
            </div>
        </article>
    @empty
            @livewire('news.not-found')
    @endforelse
</div>
