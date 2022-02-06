<form wire:submit.prevent="submit">
    <div class="bg-white p-4 sm:px-6 sm:py-4 border-b border-gray-150">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            @if (!$section_id)
                {{ __('octo::messages.system.site.sections.create_section') }}
            @else
                {{ __('octo::messages.system.site.sections.edit_section') }}
            @endif
        </h3>
    </div>

    <div class="bg-white px-4 sm:p-6">
        <div class="space-y-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <x-jet-section-title>
                    <x-slot name="title">{{ __('octo::messages.system.site.sections.create_title') }}</x-slot>
                    <x-slot name="description">{{ __('octo::messages.system.site.sections.create_description') }}
                    </x-slot>
                </x-jet-section-title>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="px-4 py-5 bg-white sm:p-6 shadow">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-12">
                                <x-jet-label for="title" value="{{ __('Title') }}" />
                                <x-jet-input id="title" type="text" class="mt-1 block w-full" wire:model.defer="title"
                                    autocomplete="title" />
                                <x-jet-input-error for="title" class="mt-2" />
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
                                <x-jet-label for="name"
                                    value="{{ __('octo::messages.system.site.sections.form.image_align') }}" />
                                <div class="flex mt-2 ">
                                    <x-radio :label=" __('octo::messages.system.site.sections.form.image_align-left')"
                                        lg value="left" wire:model.defer="image_align" />
                                    <x-radio :label=" __('octo::messages.system.site.sections.form.image_align-center')"
                                        lg class="ml-2" value="center" wire:model.defer="image_align" />
                                    <x-radio :label=" __('octo::messages.system.site.sections.form.image_align-right')"
                                        lg class="ml-2" value="right" wire:model.defer="image_align" />
                                </div>
                            </div>

                            <div class="col-span-8 sm:col-span-8">
                                <x-select label="{{ __('octo::messages.system.site.sections.form.theme') }}"
                                    placeholder="{{ __('octo::messages.system.site.sections.form.theme-description') }}"
                                    :options="['Light', 'Hero', 'Clean']" wire:model.defer="theme" />
                            </div>

                            <div class="col-span-4 sm:col-span-4">
                                <x-jet-label for="name"
                                    value="{{ __('octo::messages.system.site.sections.form.theme-color') }}" />
                                <x-jet-input id="theme_color" type="text" class="mt-1 block w-full"
                                    wire:model.defer="theme_color" autocomplete="theme_color" />
                                <x-jet-input-error for="theme_color" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-12">
                                <x-jet-label for="description" value="{{ __('Description') }}" />
                                <textarea id="description" type="text" name="description" wire:model.defer="description"
                                    autocomplete="description"
                                    class="autoexpand tracking-wide py-2 px-4 mb-3 leading-relaxed appearance-none block w-full bg-gray-200 border border-gray-200 rounded focus:outline-none focus:bg-white focus:border-gray-500"></textarea>
                                <x-jet-input-error for="description" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-6">
                                <x-jet-label for="title_color"
                                    value="{{ __('octo::messages.system.site.sections.form.title-color') }}" />
                                <x-jet-input id="title_color" type="text" class="mt-1 block w-full"
                                    wire:model.defer="title_color" autocomplete="title_color" />
                                <x-jet-input-error for="title_color" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-6">
                                <x-jet-label for="description_color"
                                    value="{{ __('octo::messages.system.site.sections.form.description-color') }}" />
                                <x-jet-input id="description_color" type="text" class="mt-1 block w-full"
                                    wire:model.defer="description_color" autocomplete="description_color" />
                                <x-jet-input-error for="description_color" class="mt-2" />
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
