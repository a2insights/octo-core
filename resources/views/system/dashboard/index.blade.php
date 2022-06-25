<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-12 gap-6 mt-5">
            @foreach ($stats as $stat)
                <x-octo-card-count :title="$stat['title']" :icon="$stat['icon']" :count="$stat['count']" :color="$stat['color']"
                    :route="$stat['route']" :direction="$stat['direction']" :percent="@$stat['percent']" />
            @endforeach
        </div>
    </div>
</x-app-layout>
