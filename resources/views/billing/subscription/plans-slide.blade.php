<div class="space-y-6">
    <div class="grid grid-flow-row grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach ($plans as $plan)
            <div class="w-full flex">
                <div
                    class="{{ $currentPlan === $plan ? 'border-indigo-500' : 'border-gray-300' }} flex flex-col w-full justify-between border-2 rounded-lg p-4 space-y-9">
                    <div class="space-y-3">
                        <div class="font-bold text-lg">
                            {{ $plan->getName() }}
                            <span class="text-xs text-gray-500">
                                @if ($currentPlan === $plan && $billable->subscribed($plan->getName()))
                                    ({{ __('Current') }})
                                @elseif($billable->subscribed($plan->getName()))
                                    <a href="#" wire:click.stop="swapPlan('{{ $plan->getId() }}')">
                                        {{ __('Swap') }}
                                    </a>
                                @endif
                            </span>
                        </div>

                        <div class="font-bold">
                            <span class="text-4xl font-extrabold">
                                {{ $plan->getPrice() > 0.0 ? $plan->getCurrency() . $plan->getPrice() : __('Free') }}
                                @if ($plan->getPrice() > 0.0)
                                    <span class="font-normal text-base">/{{ __('month') }}</span>
                                @endif
                            </span>
                        </div>

                        @if ($plan->getDescription())
                            <div class="text-gray-500">
                                {{ $plan->getDescription() }}
                            </div>
                        @endif

                        <div class="flex flex-col space-y-3">
                            @foreach ($plan->getFeatures() as $feature)
                                <p
                                    class="flex items-baseline {{ $currentPlan === $plan ? 'text-indigo-500' : 'text-gray-600' }}">
                                    <span
                                        class="{{ $currentPlan === $plan ? 'bg-indigo-500' : 'bg-gray-600' }} w-4 h-4 mr-2 inline-flex items-center justify-center text-white rounded-full flex-shrink-0">
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2.5" class="w-3 h-3"
                                            viewBox="0 0 24 24">
                                            <path d="M20 6L9 17l-5-5" />
                                        </svg>
                                    </span>
                                    @if (method_exists($feature, 'getMeteredId'))
                                        <span>
                                            {{ $feature->getName() }}
                                            <span class="text-xs text-gray-500">
                                                Após
                                                {{ $plan->getCurrency() }}{{ $feature->getMeteredPrice() }}/{{ $feature->getMeteredUnitName() }}
                                            </span>
                                        </span>
                                    @else
                                        <span>
                                            {{ $feature->getName() }}
                                        </span>
                                    @endif
                                </p>
                            @endforeach
                        </div>
                    </div>
                    @if (!$billable->subscribed($plan->getName()) && $plan->getPrice() > 0.0)
                        <x-jet-button wire:click="subscribeToPlan('{{ $plan->getId() }}')"
                            wire:loading.attr="disabled"
                            class="bg-indigo-100 hover:bg-indigo-200 text-indigo-600 hover:text-indigo-700 font-bold border-none shadow-none text-center">
                            <span class="mx-auto">{{ __('Subscribe') }}</span>
                        </x-jet-button>
                    @elseif (!$billable->subscribed($plan->getName()) && $plan->getPrice() === 0.0)
                        @if ($plan === $currentPlan)
                            <x-jet-secondary-button wire:click="cancelSubscription('{{ $plan->getId() }}')"
                                wire:loading.attr="disabled"
                                class="bg-indigo-100 hover:bg-indigo-200 text-indigo-600 hover:text-indigo-700 font-bold border-none shadow-none text-center">
                                <span class="mx-auto">{{ __('Cancel subscription') }}</span>
                            </x-jet-secondary-button>
                        @else
                            <x-jet-button wire:click="subscribeToPlan('{{ $plan->getId() }}')"
                                wire:loading.attr="disabled"
                                class="bg-indigo-100 hover:bg-indigo-200 text-indigo-600 hover:text-indigo-700 font-bold border-none shadow-none text-center">
                                <span class="mx-auto">{{ __('Subscribe') }}</span>
                            </x-jet-button>
                        @endif
                    @endif

                    @if ($billable->subscribed($plan->getName()) && $billable->subscription($plan->getName())->recurring())
                        <x-jet-secondary-button wire:click="cancelSubscription('{{ $plan->getId() }}')"
                            wire:loading.attr="disabled"
                            class="bg-indigo-100 hover:bg-indigo-200 text-indigo-600 hover:text-indigo-700 font-bold border-none shadow-none text-center">
                            <span class="mx-auto">{{ __('Cancel subscription') }}</span>
                        </x-jet-secondary-button>
                    @endif

                    @if ($billable->subscription($plan->getName()) && $billable->subscription($plan->getName())->canceled() && $billable->subscription($plan->getName())->onGracePeriod())
                        <x-jet-button wire:click="resumeSubscription('{{ $plan->getId() }}')"
                            wire:loading.attr="disable"
                            class="bg-indigo-100 hover:bg-indigo-200 text-indigo-600 hover:text-indigo-700 font-bold border-none shadow-none text-center">
                            <span class="mx-auto">{{ __('Resume subscription') }}</span>
                        </x-jet-button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div style="margin-top:0px" wire:loading wire:target="swapPlan"
        class="w-full h-full fixed block top-0 left-0 mt-0 bg-white opacity-75 z-50">
        <span class="top-1/2 my-0 mx-auto block relative w-0 h-0" style="top: 50%;">
            {{ __('Switching') }}...
        </span>
    </div>
    <div style="margin-top:0px" wire:loading wire:target="subscribeToPlan"
        class="w-full h-full fixed block top-0 left-0 mt-0 bg-white opacity-75 z-50">
        <span class="top-1/2 my-0 mx-auto block relative w-0 h-0" style="top: 50%;">
            {{ __('Subscribing') }}...
        </span>
    </div>
    <div style="margin-top:0px" wire:loading wire:target="cancelSubscription"
        class="w-full h-full fixed block top-0 left-0 mt-0 bg-white opacity-75 z-50">
        <span class="top-1/2 my-0 mx-auto block relative w-0 h-0" style="top: 50%;">
            {{ __('Cancelling') }}...
        </span>
    </div>
    <div style="margin-top:0px" wire:loading wire:target="resumeSubscription"
        class="w-full h-full fixed block top-0 left-0 mt-0 bg-white opacity-75 z-50">
        <span class="top-1/2 my-0 mx-auto block relative w-0 h-0" style="top: 50%;">
            {{ __('Resuming') }}...
        </span>
    </div>
</div>
