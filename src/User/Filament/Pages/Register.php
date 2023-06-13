<?php

namespace Octo\User\Filament\Pages;

use Filament\Forms\Components\Checkbox;
use Illuminate\Support\Facades\App;
use Illuminate\Support\HtmlString;
use JeffGreco13\FilamentBreezy\Http\Livewire\Auth\Register as FilamentBreezyRegister;
use Octo\Features\Features;

class Register extends FilamentBreezyRegister
{
    protected function getFormSchema(): array
    {
        $parentSchema = parent::getFormSchema();

        $features = App::make(Features::class);

        $html = new HtmlString('<a href="/terms-of-service" target="_blank">Accept Terms of Service</a> and <a href="/privacy-policy" target="_blank">Privacy Policy</a>');

        return array_merge($parentSchema, [
            Checkbox::make('terms')->label($html)->required($features->terms),
        ]);
    }
}
