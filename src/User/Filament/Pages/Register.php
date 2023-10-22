<?php

namespace Octo\User\Filament\Pages;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as AuthRegister;
use Illuminate\Support\Facades\App;
use Illuminate\Support\HtmlString;
use Octo\Features\Features;
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

        $user_phone = $features->user_phone;
        $terms = $features->terms;

        $fields = [
            $this->getNameFormComponent(),
            $this->getEmailFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getPasswordConfirmationFormComponent(),
        ];

        if ($user_phone) {
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

    private function getTermsFormComponent(): Component
    {
        $html = new HtmlString(trans('octo-core::default.user.register.accept_terms', ['terms_url' => route('terms'), 'policies_url' => route('policy')]));

        return Checkbox::make('terms')
            ->label($html)
            ->required();
    }

    private function getPhoneFormComponent(): Component
    {
        return PhoneInput::make('phone')
            ->label(__('octo-core::default.user.register.phone'))
            ->required();
    }
}
