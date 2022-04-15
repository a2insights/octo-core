<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Themes') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto pb-12 px-4 mt-4 sm:px-6 lg:px-8">
            @livewire('octo-system-list-themes')
        </div>
    </div>

</x-app-layout>

