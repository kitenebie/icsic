<div>
    <x-filament::modal width="3xl">
        <x-slot name="trigger">
            <x-filament::button>
                Add new event
            </x-filament::button>
        </x-slot>
        <x-slot name="heading">
            Set Event Schedule
        </x-slot>

        <form wire:submit="create">
            {{ $this->form }}
            <br>
            <x-filament::button type="submit" size="xl" icon="heroicon-m-calendar-date-range">
                save event
            </x-filament::button>
        </form>
    </x-filament::modal>

    <br><br>
    <div class="mt-10">
        {{ $this->table }}
    </div>
</div>
