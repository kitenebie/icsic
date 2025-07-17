<div class="w-full flex-col justify-end items-center space-x-2">
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
                <x-filament::button class="flex-row items-center justify-center gap-2" type="submit" wire:target="create"
                    wire:loading.attr="disabled">
                    {{-- <span wire:loading wire:target="create">
                        <x-filament::loading-indicator class="h-5 w-5" />
                    </span> --}}
                    <span>Post Announcement</span>
                </x-filament::button>

            </form>

            <x-filament-actions::modals />
        </div>
    </x-filament::modal>

    <br> <br>
    {{ $this->table }}
</div>
