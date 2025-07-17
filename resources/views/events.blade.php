<x-layouts.app :title="__('News Page')">
    <x-modal />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
    @livewire('event.event')

</x-layouts.app>
