<?php

namespace Octo\User\Filament\Pages;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Support\Facades\App;
use Illuminate\Support\HtmlString;
use Octo\Features\Features;
use Octo\Octo;
use Wallo\FilamentCompanies\Pages\Auth\Register as BaseTenantRegister;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

/**
 * @property Form $form
 */
class TenantRegister extends BaseTenantRegister
{
    public function form(Form $form): Form
    {
        return $form;
    }

    /**
     * @return array<int | string, string | Form>
     */
    protected function getForms(): array
    {
        $features = App::make(Features::class);

        $userPhone = $features->user_phone;
        $username = $features->username;
        $terms = $features->terms;

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
            ->label(__('octo-core::default.user.profile.username.title'))
            ->prefixIcon('heroicon-m-at-symbol')
            ->unique(Octo::getUserModel())
            ->required()
            ->rules(['required', 'max:100', 'min:4', 'string']);
    }

    protected function getTermsFormComponent(): Component
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
