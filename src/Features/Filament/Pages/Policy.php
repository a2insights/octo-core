<?php

namespace Octo\Features\Filament\Pages;

use Filament\Pages\BasePage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Octo\Features\Features;
use Octo\Settings\TermsSettings;

class Policy extends BasePage
{
    protected static ?string $title = '';

    protected ?string $maxContentWidth = 'full';

    protected static string $view = 'octo::features.policy';

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
