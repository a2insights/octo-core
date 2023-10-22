<?php

namespace Octo\Features\Filament\Pages;

use Filament\Pages\BasePage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Octo\Features\Features;
use Octo\Settings\TermsSettings;

class Terms extends BasePage
{
    protected static ?string $title = '';

    protected ?string $maxContentWidth = 'full';

    protected static string $view = 'octo::features.terms';

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
