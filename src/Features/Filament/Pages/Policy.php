<?php

namespace Octo\Features\Filament\Pages;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Livewire\Component;
use Octo\Features\Features;
use Octo\Settings\TermsSettings;

class Policy extends Component
{
    public function mount()
    {
        $features = App::make(Features::class);

        if (! $features->terms) {
            return redirect('/');
        }
    }

    public function render(): View
    {
        $policy = App::make(TermsSettings::class)->privacy_policy;

        $view = view('octo::features.policy', ['policy' => Str::markdown($policy)]);

        $view->layout('filament::components.layouts.base');

        return $view;
    }
}
