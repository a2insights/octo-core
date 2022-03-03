<x-jet-dialog-modal wire:model="viewingModal">
    <x-slot name="title">
        {{ $user?->name }}
    </x-slot>

    <x-slot name="content">
        @if ($userCurrentPlan)
            <div class="col-span-6 sm:col-span-6 md:col-span-5 lg:col-span-5 xxl:col-span-5">
                <div class="bg-white p-3 rounded-xl shadow-xl flex items-center justify-between mt-4">
                    <div class="flex space-x-6 items-center">
                        <div>
                            <p class="font-semibold text-base">{{ __('octo::messages.system.users.plan_active') }}</p>
                            <p class="font-semibold text-xs text-gray-400">{{ $userCurrentPlan['name'] ?? '' }}</p>
                        </div>
                    </div>

                    <div class="flex space-x-2 items-center">
                        <div class="bg-yellow-200 rounded-md p-2 flex items-center">
                            <p class="text-yellow-600 font-semibold text-xs">R$
                                {{ number_format($userCurrentPlan['price'] ?? 0, 2, '.', ',') ?? 'price' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-span-6 sm:col-span-6 md:col-span-5 lg:col-span-5 xxl:col-span-5">
                <div class="bg-white p-3 rounded-xl shadow-xl flex items-center justify-between mt-4">
                    <div class="flex space-x-6 items-center">
                        <div>
                            <p class="font-semibold text-base">
                                {{ __('octo::messages.system.users.no_has_plan_active') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="resetModal" wire:loading.attr="disabled">
            @lang('Done')
        </x-jet-secondary-button>
    </x-slot>
</x-jet-dialog-modal>
