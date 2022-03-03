<?php

namespace Octo\System\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SwitchDashboard extends Component
{
    /**
    * The dashboard of subscribe intent
    *
    * @var string
    */
    public string $dashboard = 'platform';

    /**
     * Show the switch dashboard
     *
     * @var string
     */
    public bool $show = false;

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

    /**
     * Mount the component data
     *
     * @return void
     */
    public function mount()
    {
        $this->dashboard = Auth::user()->dashboard ?? $this->dashboard;
        $this->show = Auth::user()->super_admin ?? false;
    }

    /**
     * Get the current dashboard
     *
     * @return void
     */
    public function currentDashboard()
    {
        return Auth::user()->dashboard;
    }

    /**
     * Switch the dashboard
     *
     * @return void
     */
    public function switchDashboard($dashboard)
    {
        $this->dashboard = $dashboard;

        $this->validate();

        $this->getUser()->forceFill([
            'dashboard' => $this->dashboard
        ])->save();

        if ($this->dashboard === 'system') {
            return redirect()->route('system.dashboard');
        }

        if ($this->dashboard === 'platform') {
            return redirect()->route('filament.pages.dashboard');
        }
    }

    /**
     * Render the view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('octo::system.switch-dashboard');
    }
}
