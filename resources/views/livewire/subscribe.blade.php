<div
     @if($closable)
         x-data="{ showBanner: @entangle('close') }"
         x-show="!showBanner"
         style="display: none;"
     @endif
     class="flex flex-col md:h-32 bg-white overflow-hidden md:flex-row"
>
    @if($closable)
        <div class="absolute flex justify-end inset-x-0 top-0">
            <button
                wire:click="hiddeBanner()"
                class="py-2 m-2 px-3 text-gray-600 rounded-full cursor-pointer focus:outline-none">
            <span class="flex items-center">
                <span class="h-4 w-4">
                    {{ svg('zondicon-close') }}
                </span>
            </span>
            </button>
        </div>
    @endif

    <div class="md:flex items-center justify-center md:w-1/2 md:bg-gray-800">
        <div class="py-2 px-8 md:py-0">
            <h2 class="text-gray-700 text-2xl font-bold md:text-gray-100">{{ $headline }}</h2>
            <p class="mt-1 text-gray-600 md:text-gray-400">{{ $tagline }}</p>
        </div>
    </div>
    <div class="sm:flex items-center justify-center pb-6 md:py-0 md:w-1/2 md:border-b-8 border-gray-800">
        <form wire:submit.prevent>
            <div class="flex mx-3 flex-col overflow-hidden sm:flex-row">
                <x-jet-input style="border-radius: unset"  name="email" placeholder="{{ __('Enter your email') }}" type="email" class="bg-gray-200 text-gray-800 border-gray-300 outline-none placeholder-gray-500 focus:bg-gray-100" wire:model.defer="email" />
                <x-jet-button style="border-radius: unset" wire:click="subscribe" wire:loading.attr="disabled" class="py-3 px-4 bg-gray-700 text-gray-100 font-semibold uppercase hover:bg-gray-600">
                    {{ __('subscribe') }}
                </x-jet-button>
            </div>
            <x-jet-input-error for="email" class="mt-2" />
        </form>
    </div>
</div>
