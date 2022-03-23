<x-jet-dialog-modal wire:model="viewingModal">
    <x-slot name="title">
        {{ $user?->name }}
    </x-slot>

    <x-slot name="content">
        @if ($plan)
            <div class="col-span-6 sm:col-span-6 md:col-span-5 lg:col-span-5 xxl:col-span-5">
                <h3 class=" md:text-2xl lg:text-2xl text-lg">{{ __('octo::messages.system.users.plan_active') }}</h3>
                <div class="bg-white p-3 rounded-xl shadow-xl flex items-center justify-between ">
                    <div class="flex space-x-6 items-center">
                        <div>
                            <p class="font-semibold text-base">{{ $plan['name'] ?? '' }}</p>
                            <p class="font-semibold text-xs text-gray-400">{{ $plan['id'] ?? '' }}</p>
                        </div>
                    </div>

                    <div class="flex space-x-2 items-center">
                        <div class="bg-yellow-200 rounded-md p-2 flex items-center">
                            <p class="text-yellow-600 font-semibold text-xs">R$
                                {{ number_format($plan['price'] ?? 0, 2, '.', ',') ?? 'price' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <h3 class=" md:text-2xl lg:text-2xl text-lg">
                    {{ __('octo::messages.system.users.features_usage') }}
                </h3>
                <div class="flex flex-nowrap">
                    @foreach ($plan['features'] as $feature)
                        <div class="w-60 shadow-lg rounded-lg mr-3">
                            <div class="md:p-7 p-4">
                                <h2 class="text-xl text-center capitalize">{{ Str::title($feature['id']) }}</h2>
                                <h3 class="text-sm text-center">
                                    {{ $feature['total_used'] }} / {{ $feature['value'] }}
                                </h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="col-span-6 sm:col-span-6 md:col-span-5 lg:col-span-5 xxl:col-span-5">
                <div class="bg-white p-3 rounded-xl shadow-xl flex items-center justify-between mt-4">
                    <div class="flex space-x-6 items-center">
                        <div>
                            <p class="font-semibold text-base">
                                {{ __('octo::messages.system.users.no_has_plan_active') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (count($plans) > 0)
            <h3 class="md:text-2xl lg:text-2xl mt-2 text-lg">
                {{ __('octo::messages.system.users.other_subscribed_plans') }}
            </h3>
        @endif
        @foreach ($plans as $p)
            <div class="col-span-6 sm:col-span-6 md:col-span-5 lg:col-span-5 xxl:col-span-5">
                <div class="bg-white p-3 rounded-xl shadow-xl flex items-center justify-between">
                    <div class="flex space-x-6 items-center">
                        <div>
                            <p class="font-semibold text-base">{{ $p['name'] }}</p>
                            <p class="font-semibold text-xs text-gray-400">{{ $p['id'] }}</p>
                        </div>
                    </div>

                    <div class="flex space-x-2 items-center">
                        <div class="bg-yellow-200 rounded-md p-2 flex items-center">
                            <p class="text-yellow-600 font-semibold text-xs">R$
                                {{ number_format($p['price'] ?? 0, 2, '.', ',') ?? 'price' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="resetModal" wire:loading.attr="disabled">
            @lang('Done')
        </x-jet-secondary-button>
    </x-slot>
</x-jet-dialog-modal>
