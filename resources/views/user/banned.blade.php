<div @class([
    'flex items-center justify-center min-h-screen bg-gray-100 text-gray-900 filament-breezy-auth-component filament-login-page',
    'dark:bg-gray-900 dark:text-white' => config('filament.dark_mode'),
])>

    <div
        class="px-6 -mt-16 md:mt-0 md:px-2 max-w-md space-y-8 w-screen">
        <form wire:submit.prevent="logout" @class([
            'p-8 space-y-8 bg-white/50 backdrop-blur-xl border border-gray-200 shadow-2xl rounded-2xl relative filament-breezy-auth-card',
            'dark:bg-gray-900/50 dark:border-gray-700' => config('filament.dark_mode'),
        ])>
            <div class="w-full flex justify-center">
        <x-filament::brand />
    </div>

        <div class="space-y-8">
            <h2 class="font-bold tracking-tight text-center text-2xl">
                Account Suspended
            </h2>
            <div>
                <p class="text-center">
                    Your account has been suspended  @unless($ban->expired_at) indefinitely @else until {{ $ban->expired_at->format('Y-m-d H:i:s') }} @endunless
                </p>
                @if($ban->comment)
                    <p class="text-center">
                        Reason: {{ $ban->comment }}
                    </p>
                @else
                    {{-- go to policy --}}
                @endif

                 <a class="text-primary-600 " href="/">
                   <p class="text-center">
                        Go to home
                    </p>
                </a>
            </div>
        </div>

      {{--   {{ $this->form }} --}}

        <x-filament::button type="submit" class="w-full">
            Logout
        </x-filament::button>
        </form>

        {{ $this->modal }}
        <x-filament::footer />
    </div>

    @livewire('notifications')
</div>
