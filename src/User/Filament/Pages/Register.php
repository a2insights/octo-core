<?php

namespace A2Insights\FilamentSaas\User\Filament\Pages;

use A2Insights\FilamentSaas\Features\Features;
use A2Insights\FilamentSaas\FilamentSaas;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as AuthRegister;
use Illuminate\Support\Facades\App;
use Illuminate\Support\HtmlString;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

/**
 * @property Form $form
 */
class Register extends AuthRegister
{
    /**
     * @return array<int | string, string | Form>
     */
    protected function getForms(): array
    {
        $features = App::make(Features::class);

        $userPhone = $features->user_phone;
        $username = $features->username;
        $terms = $features->terms;

        $fields = [];

        if ($username) {
            $fields[] = $this->getUsernameFormComponent();
        }

        array_push($fields, $this->getNameFormComponent(), $this->getEmailFormComponent(), $this->getPasswordFormComponent(), $this->getPasswordConfirmationFormComponent());

        if ($userPhone) {
            $fields[] = $this->getPhoneFormComponent();
        }

        if ($terms) {
            $fields[] = $this->getTermsFormComponent();
        }

        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema($fields)
                    ->statePath('data'),
            ),
        ];
    }

    private function getUsernameFormComponent(): Component
    {
        return TextInput::make('username')
            ->label(__('filament-saas::default.users.profile.username.title'))
            ->prefixIcon('heroicon-m-at-symbol')
            ->unique(FilamentSaas::getUserModel())
            ->required()
            ->rules(['required', 'max:100', 'min:4', 'string']);
    }

    private function getTermsFormComponent(): Component
    {
        $html = new HtmlString(trans('filament-saas::default.users.register.accept_terms', ['terms_url' => route('terms'), 'policies_url' => route('policy')]));

        return Checkbox::make('terms')
            ->label($html)
            ->required();
    }

    private function getPhoneFormComponent(): Component
    {
        return PhoneInput::make('phone')
            ->label(__('filament-saas::default.users.register.phone'))
            ->required();
    }
}
