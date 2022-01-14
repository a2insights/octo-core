<form wire:submit.prevent="submit">
    <div class="bg-white p-4 sm:px-6 sm:py-4 border-b border-gray-150">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ __('octo::messages.system.site.sections.create_sections') }}
        </h3>
    </div>

    <div class="bg-white px-4 sm:p-6">
        <div class="space-y-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <x-jet-section-title>
                    <x-slot name="title">{{ __('octo::messages.system.site.sections.basic_info') }}</x-slot>
                    <x-slot name="description">{{ __('octo::messages.system.site.sections.create_new_section') }}
                    </x-slot>
                </x-jet-section-title>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="px-4 py-5 bg-white sm:p-6 shadow">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-12">
                                <x-jet-label for="name" value="{{ __('Name') }}" />
                                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="name"
                                    autocomplete="name" />
                                <x-jet-input-error for="name" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-12">
                                <div x-data="{imageName: null, imagePreview: null}" class="col-span-6 sm:col-span-4">
                                    <!-- Profile image File Input -->
                                    <input type="file" class="hidden" wire:model="image" x-ref="image"
                                        x-on:change="
                                                        imageName = $refs.image.files[0].name;
                                                        const reader = new FileReader();
                                                        reader.onload = (e) => {
                                                            imagePreview = e.target.result;
                                                        };
                                                        reader.readAsDataURL($refs.image.files[0]);
                                                " />

                                    <x-jet-label for="image" value="{{ __('Image') }}" />

                                    <!-- Current Profile image -->
                                    @if ($image_url)
                                        <div class="mt-2" x-show="! imagePreview">
                                            <img src="{{ $image_url }}" alt="image"
                                                class="rounded-full h-20 w-20 object-cover">
                                        </div>
                                    @endif
                                    <!-- New Profile image Preview -->
                                    <div class="mt-2" x-show="imagePreview">
                                        <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                                            x-bind:style="'background-image: url(\'' + imagePreview + '\');'">
                                        </span>
                                    </div>

                                    <x-jet-secondary-button class="mt-2 mr-2" type="button"
                                        x-on:click.prevent="$refs.image.click()">
                                        {{ __('Select A New Image') }}
                                    </x-jet-secondary-button>

                                    @if ($image_path)
                                        <x-jet-secondary-button type="button" class="mt-2"
                                            wire:click="deleteImage">
                                            {{ __('Remove Image') }}
                                        </x-jet-secondary-button>
                                    @endif

                                    <x-jet-input-error for="image" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-span-6 sm:col-span-12">
                                <x-jet-label for="content" value="{{ __('Content') }}" />
                                <textarea id="content" type="text" name="content" wire:model.defer="content"
                                    autocomplete="content"
                                    class="autoexpand tracking-wide py-2 px-4 mb-3 leading-relaxed appearance-none block w-full bg-gray-200 border border-gray-200 rounded focus:outline-none focus:bg-white focus:border-gray-500"></textarea>
                                <x-jet-input-error for="content" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex sp-4 bg-gray-100 p-4 sm:px-6 sm:py-4 justify-end">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="submit">
            {{ __('Save') }}
        </x-jet-button>
    </div>
</form>
