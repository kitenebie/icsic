<x-layouts.app :title="__('News Page')">
    <x-modal />
    @fluxAppearance
    {{-- @livewire('guardian.select-students') --}}
    {{-- @livewire('admin.admin-modal') --}}

    <!-- Main Tailwind Layout -->
    
    <!-- Bootstrap-loaded News Section via iframe -->
        @livewire('news.news')
    @fluxScripts
</x-layouts.app>
