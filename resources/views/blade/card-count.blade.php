@props(['title' => '', 'icon' => '', 'count' => '', 'percent' => '', 'direction' => 1, 'route' => '#'])
<a href="{{ $route }}"
    class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white">
    <div class="p-5">
        <div class="flex justify-between">
            <span class="h-4 w-4">
                {{ $icon ? svg($icon) : '' }}
            </span>
            @if ($percent)
                <div
                    class="{{ $direction === 'up' ? 'bg-green-500' : 'bg-red-500 ' }} rounded-full h-6 px-2 flex justify-items-center text-white font-semibold text-sm">
                    <span class="flex items-center">{{ $percent }}%</span>
                </div>
            @endif
        </div>
        <div class="w-full flex-1">
            <div>
                <div class="mt-3 text-3xl font-bold leading-8">{{ $count }}</div>
                <div class="mt-1 text-base text-gray-600">{{ $title }}</div>
            </div>
        </div>
    </div>
</a>
