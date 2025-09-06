<div>
    <x-filament-actions::modals />

    <!-- Modal Trigger -->
    <x-filament::modal width="2xl" slide-over :close-by-clicking-away="false">
        <x-slot name="trigger">
            <x-filament::button>
                Post New Announcement
            </x-filament::button>
        </x-slot>
        <div>
            <x-slot name="heading">
                Post New Announcement
            </x-slot>
            <form wire:submit="create">
                {{ $this->form }}
                <br><br>
                <x-filament::button type="submit">
                    Post Announcement
                </x-filament::button>
            </form>

        </div>
    </x-filament::modal>
    <br> <br>
    <div>
        {{ $this->table }}
    </div>
</div>
