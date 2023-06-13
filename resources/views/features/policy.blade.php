<div @class([
    'flex items-center justify-center min-h-screen bg-gray-100 text-gray-900 filament-breezy-auth-component filament-login-page',
    'dark:bg-gray-900 dark:text-white' => config('filament.dark_mode'),
])>
    <div class="pt-4 dark:bg-gray-900">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div class="w-full flex justify-center py-4">
                <a href="/">
                    <x-filament::brand />
                </a>
            </div>

            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg prose dark:prose-invert">
                {!! $policy !!}
            </div>

            <x-filament::footer />
        </div>
    </div>
    @livewire('notifications')
</div>
