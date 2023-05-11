<?php

namespace Octo\Settings\Filament\Components;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Octo\Settings\Settings;

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
        $settings = app(Settings::class);
        $settings->locale = $locale;

        $settings->save();
        $this->redirect(request()->header('Referer'));
    }

    public function render(): View
    {
        return view('octo::settings.language-switch');
    }
}
