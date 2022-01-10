<div class="md:grid">
    <div class="flex justify-between">
        <x-jet-section-title>
            <x-slot name="title">{{ __('octo::messages.system.site.sections.title') }}</x-slot>
            <x-slot name="description">{{ __('octo::messages.system.site.sections.description') }}</x-slot>
        </x-jet-section-title>

        <button onclick='Livewire.emit("openModal", "octo-system-site-section")' style="height: 36px" onclick="" type="button" class="inline-flex h-7 items-center px-3 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
            {{ __('octo::messages.system.site.sections.add_section') }}
        </button>
    </div>

    <div class="container mb-2 flex mx-auto w-full items-center justify-center">
        <ul wire:sortable="updateSectionsOrder" class="flex w-full flex-col py-4">
            @foreach ($sections as $key => $section)
                <li
                    wire:key="section-{{ @$section['id'] }}"
                    class="py-1 flex w-full flex-row cursor-move select-none"
                    wire:sortable.item="{{ @$section['id'] }}"
                >
                    <div class="flex flex-1 items-center p-4 transition duration-500 ease-in-out transform hover:-translate-y-2 rounded-2xl border-2 p-6 hover:shadow-2xl border-gray-900">
                       @if(@$section['image_path'])
                            <div>
                                <img src="{{ @$section['image_url'] }}" alt="{{ @$section['title'] }}" class="w-16 h-16 rounded-full">
                            </div>
                       @endif

                        <div wire:sortable.handle class="flex-1 pl-1 mr-16">
                            <div class="font-medium">
                                {{ @$section['name'] }}
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button wire:click='$emit("openModal", "octo-system-site-section", @json(["section" => $section]))' class="py-2 px-3 text-gray-600 bg-grey-light rounded-full cursor-pointer hover:bg-gray-100 hover:text-gray-700 focus:outline-none">
                                <span class="flex items-center">
                                    <span class="h-4 w-4">
                                        {{ svg('zondicon-compose') }}
                                    </span>
                                </span>
                            </button>

                            <button wire:click="delete('{{ $section['id'] }}')" class="py-2 px-3 text-gray-600 bg-grey-light rounded-full cursor-pointer hover:bg-gray-100 hover:text-gray-700 focus:outline-none">
                                <span class="flex items-center">
                                    <span class="h-4 w-4">
                                        {{ svg('zondicon-trash') }}
                                    </span>
                                </span>
                            </button>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
