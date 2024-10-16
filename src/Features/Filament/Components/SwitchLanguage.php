<?php

namespace Octo\Features\Filament\Components;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Octo\Settings\Settings;
use Octo\User\Settings as UserSettings;

class SwitchLanguage extends Component
{
    public array $locales;

    public string $locale;

    public function mount(Settings $settings)
    {
        $this->locales = $settings->locales;
        $this->locale = $settings->locale;
    }

    public function changeLocale($locale)
    {
        $user = auth()->user();

        $settings = UserSettings::from(array_merge(
            $user->settings?->toArray() ?? [],
            ['locale' => $locale]
        ));

        $user->settings = $settings;

        $user->save();

        $this->redirect(request()->header('Referer'));
    }

    public function render(): View
    {
        return view('octo::features.switch-language');
    }
}
