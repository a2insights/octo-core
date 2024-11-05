<?php

namespace A2insights\FilamentSaas\Features\Filament\Pages;

use A2insights\FilamentSaas\Features\Features;
use A2insights\FilamentSaas\Settings\TermsSettings;
use Filament\Pages\BasePage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class Policy extends BasePage
{
    protected static ?string $title = '';

    protected ?string $maxContentWidth = 'full';

    protected static string $view = 'filament-saas::features.policy';

    public string $policy;

    public function mount()
    {
        $features = App::make(Features::class);

        if (! $features->terms) {
            return redirect('/');
        }

        $policy = App::make(TermsSettings::class)->privacy_policy;

        $this->policy = Str::markdown($policy);
    }

    public function hasLogo(): bool
    {
        return false;
    }
}
