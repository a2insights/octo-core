<x-filament-panels::page>
    @php
        // Fetch components from Wallo and Breezy
        $walloComponents = \Wallo\FilamentCompanies\FilamentCompanies::getProfileComponents();
        $brezzyComponents = $this->getRegisteredMyProfileComponents();

        $providedComponents = array_merge($walloComponents, $brezzyComponents);

        // Define all available components
        $allComponents = [
            "Wallo\FilamentCompanies\Http\Livewire\UpdateProfileInformationForm",
            "Wallo\FilamentCompanies\Http\Livewire\UpdatePasswordForm",
            "Wallo\FilamentCompanies\Http\Livewire\ConnectedAccountsForm",
            "Wallo\FilamentCompanies\Http\Livewire\LogoutOtherBrowserSessionsForm",
            "Wallo\FilamentCompanies\Http\Livewire\DeleteUserForm",
            "Jeffgreco13\FilamentBreezy\Livewire\PersonalInfo",
            "A2insights\FilamentSaas\User\Filament\Components\Phone",
            "A2insights\FilamentSaas\User\Filament\Components\Username",
            "Jeffgreco13\FilamentBreezy\Livewire\UpdatePassword",
            "Jeffgreco13\FilamentBreezy\Livewire\TwoFactorAuthentication",
        ];

        $showComponents = [
            "Jeffgreco13\FilamentBreezy\Livewire\PersonalInfo",
            "A2insights\FilamentSaas\User\Filament\Components\Username",
            "A2insights\FilamentSaas\User\Filament\Components\Phone",
            "Jeffgreco13\FilamentBreezy\Livewire\UpdatePassword",
            "Jeffgreco13\FilamentBreezy\Livewire\TwoFactorAuthentication",
            "Wallo\FilamentCompanies\Http\Livewire\ConnectedAccountsForm",
            "Wallo\FilamentCompanies\Http\Livewire\LogoutOtherBrowserSessionsForm",
            "Wallo\FilamentCompanies\Http\Livewire\DeleteUserForm",
        ];

        $showComponents = array_filter($showComponents, function ($component) use ($providedComponents) {
            return in_array($component, $providedComponents);
        });
    @endphp

    @foreach($showComponents as $index => $component)
        @livewire($component)

        @if(!$loop->last)
            <x-filament-companies::section-border />
        @endif
    @endforeach
</x-filament-panels::page>
