<x-jet-form-section class="mb-2" submit="submit">
    <x-slot name="title">
        {{ __('octo::messages.system.site.info.title') }}
    </x-slot>

    <x-slot name="description">
        {{ __('octo::messages.system.site.info.description') }}
    </x-slot>

    <x-slot name="form">
        <!-- Name -->
        <div class="col-span-8 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="name" autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <div class="col-span-4 sm:col-span-8">
            <div class="flex flex-row">
                <!-- Active -->
                <div>
                    <x-jet-label for="site" value="{{ __('Active') }}" />
                    <x-jet-checkbox style="height: 40px; width: 40px; cursor: pointer" id="active" type="text"
                        class="mt-1 block" wire:model.defer="active" autocomplete="active" />
                    <x-jet-input-error for="active" class="mt-2" />
                </div>
                <div class="ml-3">
                    <!-- Active -->
                    <x-jet-label for="site" value="{{ __('Demo') }}" />
                    <x-jet-checkbox style="height: 40px; width: 40px; cursor: pointer" id="demo" type="text"
                        class="mt-1 block" wire:model.defer="demo" autocomplete="demo" />
                    <x-jet-input-error for="demo" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="col-span-6 sm:col-span-12">
            <x-jet-label for="description" value="{{ __('Description') }}" />
            <x-jet-input id="description" type="text" class="mt-1 block w-full" wire:model.defer="description"
                autocomplete="description" />
            <x-jet-input-error for="description" class="mt-2" />
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
