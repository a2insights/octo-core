<div @click.away="open = false" class="flex flex-col w-full md:w-64 text-gray-700 bg-white dark-mode:text-gray-200 dark-mode:bg-gray-800 flex-shrink-0" x-data="{ open: false }">
    <div class="flex-shrink-0 h-16 px-4 py-4 flex flex-row items-center justify-between">
        <div class="flex-shrink-0 flex items-center">
            <a class="mr-8" href="{{ route('dashboard') }}">
                <x-jet-application-mark class="block h-9 w-auto" />
            </a>
            <a href="{{ route('dashboard') }}" class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline">{{  config('app.name', 'Octo') }}</a>
        </div>
        <button class="rounded-lg md:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
            <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
    <nav :class="{'block': open, 'hidden': !open}" class="flex-grow md:block pb-4 md:pb-0 md:overflow-y-auto">
        <div @click.away="open = false" class="relative" x-data="{ open: false }">
            @foreach($items as $item)
                <div x-data="{ open: false }">
                    <button @click="open = !open ; window.location.replace('{{ $getUrl($item) }}')" class="w-full {{ ($isActive($item) xor $hasChildActive($item)) ? 'text-purple-500' : '' }} flex justify-between items-center py-3 px-6 text-gray-600 cursor-pointer hover:bg-gray-100 hover:text-gray-700 focus:outline-none">
                        <span class="flex items-center">
                            <span class="h-4 w-4">
                                {{ $svg($item->icon) }}
                            </span>
                            <span class="mx-4 font-medium">{{ ($item->label)  }}</span>
                        </span>
                        @isset($item->children)
                            <span>
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path x-show="!open" d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;"></path>
                                    <path x-show="open" d="M19 9L12 16L5 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </span>
                        @endisset
                    </button>
                    @isset($item->children)
                        <div x-show="open" class="bg-gray-100">
                            @foreach($item->children as $child)
                                <a class="{{ $isActive($child) ? 'text-purple-500' : '' }} py-2 px-16 block text-sm text-gray-600 hover:bg-blue-500 hover:text-white" href="{{ $getUrl($child) }}">{{ $child->label }}</a>
                            @endforeach
                        </div>
                    @endisset
                </div>
            @endforeach
        </div>
    </nav>
</div>
