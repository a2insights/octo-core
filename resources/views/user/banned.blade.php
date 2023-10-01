 <div class="fi-simple-layout flex min-h-screen flex-col items-center">
     <div class="fi-simple-main-ctn flex w-full flex-grow items-center justify-center">
         <main
             class="fi-simple-main my-16 w-full bg-white px-6 py-12 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 sm:max-w-lg sm:rounded-xl sm:px-12">
             <div class="flex flex-row justify-center">
                 <img class="w-56 h-56 rounded-full"
                     src="{{ \Filament\Facades\Filament::getUserAvatarUrl(\Filament\Facades\Filament::auth()->user()) }}"
                     alt="avatar">
             </div>

             <div class="flex flex-row justify-center">
                 <div class="mt-2 font-medium dark:text-white">
                     <div>{{ \Filament\Facades\Filament::auth()->user()?->name ?? '' }}</div>
                 </div>
             </div>

             <div class="text-center mt-5">
                 <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                     Account Suspended
                 </h1>
                 <p class=" text-base leading-7 text-gray-600">
                     Your account has been suspended @unless ($ban->expired_at)
                         indefinitely
                     @else
                         until {{ $ban->expired_at->format('Y-m-d H:i:s') }}
                     @endunless
                 </p>

                 @if ($ban->comment)
                     <p class="text-center">
                         Reason: {{ $ban->comment }}
                     </p>
                 @endif
             </div>

             <x-filament-panels::form wire:submit="logout">
                 {{ $this->form }}

                 <x-filament-panels::form.actions :actions="$this->getFormActions()" :full-width="$this->hasFullWidthFormActions()" />
             </x-filament-panels::form>

         </main>
     </div>
 </div>
