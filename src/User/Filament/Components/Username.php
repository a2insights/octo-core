<?php

namespace Octo\User\Filament\Components;

use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\App;
use Jeffgreco13\FilamentBreezy\Livewire\MyProfileComponent;
use Octo\Features\Features;
use Octo\Octo;

class Username extends MyProfileComponent
{
    protected string $view = 'octo::user.livewire.phone';

    public static $sort = 10;

    public $user;

    public ?array $data = [];

    public function mount()
    {
        $this->user = Filament::getCurrentPanel()->auth()->user();
        $this->form->fill($this->user->only(['username']));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('username')
                    ->label(__('octo-core::default.user.profile.username.title'))
                    ->prefixIcon('heroicon-m-at-symbol')
                    ->unique(Octo::getUserModel(), ignorable: $this->user)
                    ->required()
                    ->rules(['required', 'max:100', 'min:4', 'string']),
            ])->statePath('data');
    }

    public static function canView(): bool
    {
        $features = App::make(Features::class);

        return $features->username;
    }

    public function submit()
    {

        $data = collect($this->form->getState())->only(['username'])->all();
        $this->user->update($data);

        Notification::make()
            ->success()
            ->title(__('octo-core::default.user.profile.username.notify'))
            ->send();
    }
}
