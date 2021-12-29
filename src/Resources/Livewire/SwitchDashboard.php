<?php

namespace Octo\Resources\Livewire;

use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Component;

class SwitchDashboard extends Component
{
    use InteractsWithBanner;

     /**
     * The dashboard of subscribe intent
     *
     * @var string
     */
    public string $dashboard = 'platform';

    /**
     * Rules of form
     *
     * @var string[]
     */
    protected array $rules = [
        'dashboard' => 'required|in:platform,system'
    ];


     /**
     * Get the auth user
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    private function getUser()
    {
        return Auth::user();
    }

    public function switchDashboard()
    {
        $this->validate();

        $this->getUser()->update(['dashboard' => $this->dashboard]);
    }

    /**
     * Render the view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('octo::livewire.switch-dashboard');
    }
}
