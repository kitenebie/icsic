<main class="mt-4 max-w-6xl mx-auto">
    @if($featured)
    <section  class="flex flex-col md:flex-row bg-white rounded-xl border shadow-md overflow-hidden"
        style="min-height: 280px">
        <div class="relative flex-1 flex items-center justify-center">
            <span
                class="absolute top-4 left-4 text-xs font-semibold text-white bg-[#e03e2f] rounded-full px-3 py-1 tracking-wide select-none">
                FEATURED
            </span>
            <a href="/read/{{ Illuminate\Support\Str::random(100) }}/{{ $featured->id }} "
                class="absolute z-1 bg-[#2CAC5B] text-white text-sm font-semibold rounded-md px-4 py-4 w-max hover:bg-[#3C7647] transition-colors">
                Read Full Story
            </a>
            <img alt="Icon of a newspaper in white on a green gradient background" aria-hidden="true"
                class="w-full h-full" height="96" src="/storage/{{ $featured->image }}" width="96" />
        </div>
        <div class="flex-1 p-6 md:p-8 flex flex-col justify-center">
            <span class="text-[#2CAC5B] font-semibold text-xs tracking-wide uppercase mb-2">
                {{ $this->categories[$featured->topic_category] }}
            </span>
            <h2 class="font-extrabold text-black text-xl md:text-2xl leading-tight mb-4">
                {{ $featured->title }}
            </h2> 
            <p class="text-gray-600 text-sm md:text-base mb-10S max-w-md leading-relaxed">
                {!! Illuminate\Support\Str::limit($featured->content[0]['Paragraph'][0]['content'], 500) !!}
            </p>
            <div class="flex items-center mt-4 space-x-3 mb-6">
                <div aria-hidden="true"
                    class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-300 text-gray-600">
                    <i class="fas fa-user text-lg">
                    </i>
                </div>
                <div class="text-xs text-gray-700">
                    <p class="font-semibold text-gray-900 leading-none">
                        {{ $featured->author }}
                    </p>
                    <p class="text-gray-500 leading-none">
                        {!! Illuminate\Support\Str::limit($featured->author_description, 60) !!}
                    </p>
                </div>
            </div>
        </div>
    </section>
    @endif
</main>
