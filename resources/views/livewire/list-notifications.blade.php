<div class="flex justify-center overflow-x-hidden">
    <div class="flex flex-col py-1 lg:w-3/4 sm:w-full inline-block overflow-y-auto overflow-hidden bg-gray-100">
        <div class="w-64 mt-1 ml-2 mr-2">
            <div class="bg-gray-200 text-sm text-gray-500 leading-none border-2 border-gray-200 rounded inline-flex">
                <button wire:click="filter('all')" class="{{ $filter === 'all' ? 'text-blue-400' : '' }} border-right inline-flexitems-center transition-colors duration-300 ease-in focus:outline-none hover:text-blue-400 focus:text-blue-400 rounded-l-full px-3 py-1">
                    <span>All</span>
                </button>
                <button wire:click="filter('unread')" class="{{ $filter === 'unread' ? 'text-blue-400' : '' }} inline-flex items-center transition-colors duration-300 ease-in focus:outline-none hover:text-blue-400 focus:text-blue-400 rounded-r-full px-4 py-1">
                    <span>Unread</span>
                </button>
            </div>
        </div>
        @forelse($notifications as $notification)
            <div class="{{ $notification->read_at ? 'bg-white' : 'bg-indigo-100' }} shadow-lg mt-2 pb-2 ml-2 mr-2 rounded-lg">
                <a href="#" wire:click="redirectTo('{{ $notification->id }}')" class="block border-t">
                    <div class="px-4 py-2 flex justify-between">
                        <span class="text-sm font-semibold text-gray-900">
                            {{ $notification->data['title'] }}
                        </span>
                        <div class="flex">
                            <span class="text-sm font-semibold text-gray-600">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <p class="px-4 py-2 text-sm font-semibold text-gray-700">
                        {{ $notification->data['description'] }}
                    </p>
                </a>
                <div class="px-4 flex justify-end">
                    @if($notification->read_at)
                        <button
                            wire:click="markAsUnread('{{ $notification->id }}')"
                            wire:loading.attr="disabled"
                            class="px-2 transition-colors duration-700 transform bg-indigo-500 hover:bg-blue-400 text-gray-100 text-sm rounded-lg focus:border-4 border-indigo-300"
                        >
                            unread
                        </button>
                    @else
                        <button
                            wire:click="markAsRead('{{ $notification->id }}')"
                            wire:loading.attr="disabled"
                            class="px-2 bg-transparent border-2 border-indigo-500 text-indigo-500 text-sm rounded-lg transition-colors duration-700 transform hover:bg-indigo-500 hover:text-gray-100 focus:border-4 focus:border-indigo-300"
                        >
                            read
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="mt-2 pb-2 ml-2 mr-2 rounded-lg">
                <h2 class="pt-4 mx-auto text-4xl text-center">All caught!</h2>
            </div>
        @endforelse
    </div>
</div>





