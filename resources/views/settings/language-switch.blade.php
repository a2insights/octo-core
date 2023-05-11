<x-filament::dropdown placement="bottom-end">
    <style>
        .filament-dropdown-list-item-label {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }
    </style>
    <x-slot name="trigger" @class([
        'ml-4' => __('filament::layout.direction') === 'ltr',
        'mr-4' => __('filament::layout.direction') === 'rtl',
    ])>
        <div
            class="flex items-center justify-center w-10 h-10 font-semibold ">
            {{ \Illuminate\Support\Str::of(app()->getLocale())->length() > 2
                ? \Illuminate\Support\Str::of(app()->getLocale())->substr(0, 2)->upper()
                : \Illuminate\Support\Str::of(app()->getLocale())->upper() }}
        </div>
    </x-slot>
    <x-filament::dropdown.list class="">
        @foreach ($locales as $key => $locale)
            @if (!app()->isLocale($locale))
                <x-filament::dropdown.list.item wire:click="changeLocale('{{ $locale }}')" tag="button">
                   <span
                        class="w-6 h-6 flex items-center justify-center mr-4 flex-shrink-0 rtl:ml-4 @if (!app()->isLocale($locale)) group-hover:bg-white group-hover:text-primary-600 group-hover:border group-hover:border-primary-500/10 group-focus:text-white @endif bg-primary-500/10 text-primary-600 font-semibold rounded-full p-1 text-xs">
                        {{ \Illuminate\Support\Str::of($locale)->snake()->upper()->explode('_')->map(function ($string) use ($locale) {
                                return \Illuminate\Support\Str::of($locale)->wordCount() > 1 ? \Illuminate\Support\Str::substr($string, 0, 1) : \Illuminate\Support\Str::substr($string, 0, 2);
                            })->take(2)->implode('') }}
                        </span>
                    <span class="hover:bg-transparent ml-2 ">
                        {{ \Illuminate\Support\Str::title(\Symfony\Component\Intl\Locales::getName($locale)) }}
                    </span>
                </x-filament::dropdown.list.item>
            @endif
        @endforeach
    </x-filament::dropdown.list>
</x-filament::dropdown>
