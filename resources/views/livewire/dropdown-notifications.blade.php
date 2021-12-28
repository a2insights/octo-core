<div class="xl:flex mt-2 items-center space-x-5 items-center">
    <div
        x-data="{ dropdownOpen: false }"
        @click.away="dropdownOpen = false"
        class="relative my-32"
    >
        <button @click="dropdownOpen = !dropdownOpen" class="relative z-10 block rounded-md bg-white p-2 focus:outline-none">
                <span class="relative inline-block">
                    {{ svg('heroicon-o-bell', 'w-6 h-6 text-gray-700') }}
                    @if($noReads)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                            {{ $noReads }}
                        </span>
                    @endif
                </span>
        </button>

        <div
            x-show="dropdownOpen"
            class="absolute right-0 rounded-md shadow-lg overflow-hidden z-20"
            x-cloak
            style="width:20rem;display: none;">
            <div class="bg-gray-100">
                @forelse($notifications as $notification)
                    <a
                        href="#"
                        wire:click="redirectTo('{{ $notification->id }}')"
                        class="{{ $notification->read_at ? 'bg-white' : 'bg-indigo-100' }} flex items-center px-2 py-2 border-b hover:bg-gray-700 hover:text-white"
                    >
                        <p style="min-width: 18rem;" class=" text-sm mx-2">
                            <span class="font-bold" href="#">{{ $notification->data['title'] }}</span> <small style="float: right" class="float-right">{{ $notification->created_at->diffForHumans() }}</small>
                            <br><span>{{ \Illuminate\Support\Str::limit($notification->data['description'], 48) }}</span>
                        </p>
                    </a>
                @empty
                    <h3 class="mx-auto py-4 text-2xl text-center">{{ __('octo::messages.notifications.all-caught') }}</h3>
                @endforelse
            </div>
            @if($notifications->count() > 0)
                <a href="{{ route('notifications.index') }}" class="block bg-gray-800 text-white text-center font-bold py-2">{{ __('octo::messages.notifications.all-notifications') }}</a>
            @endif
        </div>
    </div>
</div>
