<x-filament-panels::page>

    <x-filament::section>

        <x-slot name="heading">
            Have Fun
        </x-slot>

        <x-slot name="description">
            {{ $this->page_description }}
        </x-slot>

        <x-filament-panels::form>

            {{ $this->form }}

            <x-filament::button outlined wire:click="magic">
                Generate
            </x-filament::button>

        </x-filament-panels::form>

    </x-filament::section>

</x-filament-panels::page>
