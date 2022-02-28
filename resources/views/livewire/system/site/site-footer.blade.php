<div>
    <div class="md:grid mt-2">
        <div class="flex justify-between">
            <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ __('octo::messages.system.site.footer.title_link') }}
                    </h3>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('octo::messages.system.site.footer.description_link') }}
                    </p>
                </div>
            </div>

            <button wire:click="addLink()" style="height: 36px" type="button"
                class="inline-flex mr-3 h-7 items-center px-3 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                {{ __('octo::messages.system.site.footer.add_link') }}
            </button>
        </div>

        <div class="container px-3 mb-2 flex mx-auto w-full items-center justify-center">
            <ul wire:sortable="updateFooterLinksOrder" class="flex w-full flex-col py-4">
                @foreach ($links as $key => $link)
                    <li wire:key="link-{{ @$link['id'] }}" class="py-1 flex w-full flex-row"
                        wire:sortable.item="{{ @$link['id'] }}">
                        <div class="flex flex-1 items-center p-4 rounded-2xl border-2 p-6 border-gray-900">
                            <div class="flex-1 pl-1 mr-5">
                                <div class="grid grid-flow-row-dense grid-cols-3">
                                    <div class="col-span-1 mr-2 mb-3">
                                        <x-input wire:model='links.{{ $key }}.title' type="text"
                                            label="title" />
                                        <x-error name="title" />
                                    </div>
                                    <div class="col-span-2">
                                        <x-input wire:model='links.{{ $key }}.url' type="text" label="url" />
                                        <x-error name="url" />
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button wire:click="deleteLink('{{ $link['id'] }}')"
                                    class="py-2 mt-3 px-3 text-gray-600 bg-grey-light rounded-full cursor-pointer hover:bg-gray-100 hover:text-gray-700 focus:outline-none">
                                    <span class="flex items-center">
                                        <span class="h-4 w-4">
                                            {{ svg('zondicon-trash') }}
                                        </span>
                                    </span>
                                </button>
                                <button wire:sortable.handle
                                    class="py-2 mt-3 px-3 text-gray-600 bg-grey-light rounded-full cursor-move hover:bg-gray-100 hover:text-gray-700 focus:outline-none">
                                    <span class="flex items-center">
                                        <span class="h-4 w-4">
                                            {{ svg('zondicon-dots-horizontal-triple') }}
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

    <x-jet-section-border />

    <div class="md:grid mt-2">
        <div class="flex justify-between">
            <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ __('octo::messages.system.site.footer.title_network') }}
                    </h3>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('octo::messages.system.site.footer.description_network') }}
                    </p>
                </div>
            </div>

            <button wire:click="addNetwork()" style="height: 36px" type="button"
                class="inline-flex mr-3 h-7 items-center px-3 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                {{ __('octo::messages.system.site.footer.add_network') }}
            </button>
        </div>

        <div class="container px-3 mb-2 flex mx-auto w-full items-center justify-center">
            <ul wire:sortable="updateFooterNetworksOrder" class="flex w-full flex-col py-4">
                @foreach ($networks as $key => $network)
                    <li wire:key="network-{{ @$network['id'] }}" class="py-1 flex w-full flex-row"
                        wire:sortable.item="{{ @$network['id'] }}">
                        <div class="flex flex-1 items-center p-4 rounded-2xl border-2 p-6 border-gray-900">
                            <div class="flex-1 pl-1 mr-5">
                                <div class="grid grid-flow-row-dense grid-cols-3">
                                    <div class="col-span-1 mr-2 mb-3">
                                        <x-select label="{{ __('Rede social') }}"
                                            wire:model='networks.{{ $key }}.title'
                                            :options="['Facebook', 'Twitter', 'Instagram', 'Youtube']" />
                                        <x-error name="title" />
                                    </div>
                                    <div class="col-span-2">
                                        <x-input wire:model='networks.{{ $key }}.url' type="text"
                                            label="url" />
                                        <x-error name="url" />
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button wire:click="deleteNetwork('{{ $network['id'] }}')"
                                    class="py-2 mt-3 px-3 text-gray-600 bg-grey-light rounded-full cursor-pointer hover:bg-gray-100 hover:text-gray-700 focus:outline-none">
                                    <span class="flex items-center">
                                        <span class="h-4 w-4">
                                            {{ svg('zondicon-trash') }}
                                        </span>
                                    </span>
                                </button>
                                <button wire:sortable.handle
                                    class="py-2 mt-3 px-3 text-gray-600 bg-grey-light rounded-full cursor-move hover:bg-gray-100 hover:text-gray-700 focus:outline-none">
                                    <span class="flex items-center">
                                        <span class="h-4 w-4">
                                            {{ svg('zondicon-dots-horizontal-triple') }}
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
</div>
