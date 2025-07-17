<x-layouts.custome.header>
    <x-modal />
    @livewire('news.featured')
    {{-- FEATURED --}}

    {{-- OTHER NEWS --}}
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h2 class="text-xl font-extrabold leading-6">
                Latest News
            </h2>
            @livewire('news.nav-category')
        </div>
        @livewire('news.latest-news')
        <div class="flex justify-center mt-6">
            @livewire('news.new-button')
        </div>
    </div>

    {{-- {trends} --}}
    <main class="max-w-6xl mx-auto p-6">
        <h2 class="text-xl font-extrabold mb-6 text-slate-900">Trending Topics</h2>
        <div class="flex flex-col md:flex-row gap-6">
            @livewire('news.trends')

            <!-- Recently Featured -->
            @livewire('news.recently-featured')
        </div>
    </main>
</x-layouts.custome.header>
