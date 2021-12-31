<x-jet-form-section submit="submit">
    <x-slot name="title">
        {{ __('Site Informations') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update the site informations') }}
    </x-slot>

    <x-slot name="form">
        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="name" autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <!-- Active -->
        <div class="col-span-2 sm:col-span-3">
            <x-jet-label for="site" value="{{ __('Active') }}" />
            <x-jet-checkbox style="height: 40px; width: 40px; cursor: pointer" id="active" type="text" class="mt-1 block" wire:model.defer="active" autocomplete="active" />
            <x-jet-input-error for="active" class="mt-2" />
        </div>

        <!-- Description -->
        <div class="col-span-6 sm:col-span-12">
            <x-jet-label for="description" value="{{ __('Description') }}" />
            <x-jet-input id="description" type="text" class="mt-1 block w-full" wire:model.defer="description" autocomplete="description" />
            <x-jet-input-error for="description" class="mt-2" />
        </div>


    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
