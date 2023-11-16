<?php

namespace Octo\User\Filament\Components;

use Filament\Facades\Filament;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\App;
use Jeffgreco13\FilamentBreezy\Livewire\MyProfileComponent;
use Octo\Features\Features;
use Octo\Octo;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class Phone extends MyProfileComponent
{
    protected string $view = 'octo::user.livewire.phone';

    public static $sort = 10;

    public $user;

    public ?array $data = [];

    public function mount()
    {
        $this->user = Filament::getCurrentPanel()->auth()->user();
        $this->form->fill($this->user->only(['phone']));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                PhoneInput::make('phone')
                    ->defaultCountry('BR')
                    ->label(__('octo-core::default.user.register.phone'))
                    ->unique(Octo::getUserModel(), ignorable: $this->user)
                    ->validateFor(
                        lenient: true,
                    )
                    ->required(),
            ])->statePath('data');
    }

    public static function canView(): bool
    {
        $features = App::make(Features::class);

        return $features->user_phone;
    }

    public function submit()
    {

        $data = collect($this->form->getState())->only(['phone'])->all();
        $this->user->update($data);

        Notification::make()
            ->success()
            ->title(__('octo-core::default.user.profile.phone.notify'))
            ->send();
    }
}
