<?php

namespace Octo\User\Filament\Pages;

use Illuminate\Support\Facades\App;
use JeffGreco13\FilamentBreezy\Http\Livewire\Auth\Login as FilamentBreezyLogin;
use Octo\Features\Features;

class Login extends FilamentBreezyLogin
{
    protected function getFormSchema(): array
    {
        $parentSchema = parent::getFormSchema();

        $features = App::make(Features::class);

        return $features->recaptcha ? array_merge($parentSchema, [
            \AbanoubNassem\FilamentGRecaptchaField\Forms\Components\GRecaptcha::make('captcha'),
        ]) : $parentSchema;
    }
}
