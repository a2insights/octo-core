<form wire:submit.prevent="submit">
    <div class="bg-white p-4 sm:px-6 sm:py-4 border-b border-gray-150">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            @if (!@$state['id'])
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
                                <x-input label="{{ __('Title') }}" wire:model.defer="state.title" />
                                <x-error name="title" />
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
                                    @if (@$state['image_url'])
                                        <div class="mt-2" x-show="! imagePreview">
                                            <img src="{{ @$state['image_url'] }}" alt="image"
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

                                    @if (@$state['image_path'] || $image)
                                        <x-jet-secondary-button type="button" class="mt-2"
                                            x-on:click.prevent="imagePreview = false" wire:click="deleteImage">
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
                                        lg value="left" wire:model.defer="state.image_align" />
                                    <x-radio :label=" __('octo::messages.system.site.sections.form.image_align-center')"
                                        lg class="ml-2" value="center" wire:model.defer="state.image_align" />
                                    <x-radio :label=" __('octo::messages.system.site.sections.form.image_align-right')"
                                        lg class="ml-2" value="right" wire:model.defer="state.image_align" />
                                </div>
                            </div>

                            <div class="col-span-8 sm:col-span-8">
                                <x-select label="{{ __('octo::messages.system.site.sections.form.theme') }}"
                                    placeholder="{{ __('octo::messages.system.site.sections.form.theme-description') }}"
                                    :options="['Light', 'Hero', 'Clean']" wire:model.defer="state.theme" />
                            </div>

                            <div class="col-span-4 sm:col-span-4">
                                <x-input label="{{ __('octo::messages.system.site.sections.form.theme-color') }}"
                                    wire:model.defer="state.theme_color" />
                                <x-error name="theme_color" />
                            </div>

                            <div class="col-span-6 sm:col-span-12">
                                <x-textarea label="{{ __('Description') }}" wire:model.defer="state.description" />
                                <x-error name="description" />
                            </div>

                            <div class="col-span-6 sm:col-span-6">
                                <x-input label="{{ __('octo::messages.system.site.sections.form.title-color') }}"
                                    wire:model.defer="state.title_color" />
                                <x-error name="title_color" />
                            </div>

                            <div class="col-span-6 sm:col-span-6">
                                <x-jet-input-error for="description_color" class="mt-2" />
                                <x-input
                                    label="{{ __('octo::messages.system.site.sections.form.description-color') }}"
                                    wire:model.defer="state.description_color" />
                                <x-error name="description_color" />
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
