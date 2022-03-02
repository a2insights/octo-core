@props(['icon' => '', 'title' => ''])
<div x-data="{open: false }">
    <button @click="open = true" x-data="{show: @entangle('show') }" x-show="show" x-cloak
        class="rounded float-right px-3 mt-3 py-2 m-1 shadow-lg bg-gray-800" style="position:fixed;right:-3px;top:18%;">
        <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 text-white fill-current text-center">
            <title>{{ __($title) }}</title>
            {{ !$icon ?: svg($icon) }}
        </svg>
    </button>
    <div style="display: none;" x-cloak x-show="open" class="fixed inset-0 overflow-hidden"
        aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        <div class="absolute inset-0 overflow-hidden">

            <div x-show="open" x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                x-description="Background overlay, show/hide based on slide-over state."
                class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="open = false"
                aria-hidden="true">
            </div>
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">

                <div x-show="open" x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                    class="pointer-events-auto relative w-screen max-w-md"
                    x-description="Slide-over panel, show/hide based on slide-over state.">

                    <div x-show="open" x-transition:enter="ease-in-out duration-500"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        x-description="Close button, show/hide based on slide-over state."
                        class="absolute top-0 left-0 -ml-8 flex pt-4 pr-2 sm:-ml-10 sm:pr-4">
                        <button type="button"
                            class="rounded-md text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                            @click="open = false">
                            <span class="sr-only">Close panel</span>
                            <svg class="h-6 w-6" x-description="Heroicon name: outline/x"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="h-full flex flex-col py-6 bg-white shadow-xl overflow-hidden">
                        <div class="px-4 sm:px-6">
                            <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">
                                {{ __($title) }}
                            </h2>
                        </div>
                        <div class="relative flex-1 px-4 sm:px-6">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
