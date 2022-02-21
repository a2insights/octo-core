<x-octo-slide-over icon="heroicon-o-switch-horizontal" title="Dashboard">
    <div role="listitem" class="bg-white cursor-pointer shadow mt-3 flex relative z-30">
        <button wire:click="switchDashboard('system')"
            class="w-full {{ $dashboard == 'system' ? 'bg-gray-800 text-white' : 'text-gray-800' }}  px-6 py-2 text-md border-b hover:text-white hover:bg-gray-500">
            {{ __('System') }}
        </button>
    </div>
    <div role="listitem" class="bg-white cursor-pointer shadow p-8 relative z-30 mt-7">
        <button wire:click="switchDashboard('platform')"
            class="w-full {{ $dashboard == 'platform' ? 'bg-gray-800 text-white' : 'text-gray-800' }}  px-6 py-2 text-md border-b hover:text-white hover:bg-gray-500">
            {{ __('Platform') }}
        </button>
    </div>
</x-octo-slide-over>
