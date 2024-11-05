<?php

namespace A2insights\FilamentSaas\Features\Filament\Pages;

use A2insights\FilamentSaas\Features\Features;
use A2insights\FilamentSaas\Settings\TermsSettings;
use Filament\Pages\BasePage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class Terms extends BasePage
{
    protected static ?string $title = '';

    protected ?string $maxContentWidth = 'full';

    protected static string $view = 'filament-saas::features.terms';

    public string $terms;

    public function mount()
    {
        $features = App::make(Features::class);

        if (! $features->terms) {
            return redirect('/');
        }

        $terms = App::make(TermsSettings::class)->service;

        $this->terms = Str::markdown($terms);
    }

    public function hasLogo(): bool
    {
        return false;
    }
}
