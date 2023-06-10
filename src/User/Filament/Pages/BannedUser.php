<?php

namespace Octo\User\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Forms;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class BannedUser extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public function mount()
    {
        if (! Filament::auth()->check()) {
            return redirect('/');
        }

        if (! auth()->user()->isBanned()) {
            return redirect(config('filament.home_url'));
        }
    }

    public function logout()
    {
        Filament::auth()->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('filament.auth.login');
    }

    public function render(): View
    {
        $ban = auth()->user()->bans->first();

        $view = view('octo::user.banned', ['ban' => $ban]);

        $view->layout('filament::components.layouts.base');

        return $view;
    }
}
