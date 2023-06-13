<?php

namespace Octo\Features\Filament\Pages;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Livewire\Component;
use Octo\Features\Features;
use Octo\Settings\TermsSettings;

class Terms extends Component
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
        $terms = App::make(TermsSettings::class)->service;

        $view = view('octo::features.terms', ['terms' => Str::markdown($terms)]);

        $view->layout('filament::components.layouts.base');

        return $view;
    }
}
