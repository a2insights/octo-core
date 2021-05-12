<?php

namespace Octo\Http\Livewire;

use Illuminate\Support\Facades\Cookie;
use Laravel\Jetstream\InteractsWithBanner;
use LivewireUI\Modal\ModalComponent;
use Spatie\Newsletter\NewsletterFacade;

class Subscribe extends ModalComponent
{
    use InteractsWithBanner;

    public $email;

    protected $rules = [
        'email' => 'required|email'
    ];

    public bool $close = false;

    public bool $closable = true;

    public $bg = 'white';

    private string $cookieName = 'subscribe_show';

    public function mount()
    {
        $this->close = (bool) request()->cookie($this->cookieName);
    }

    public function hiddeBanner()
    {
        $this->close = true;

        Cookie::queue($this->cookieName, 1, 60*24*10);
    }

    public function subscribe()
    {
        $this->validate();

        $ok = NewsletterFacade::subscribeOrUpdate($this->email);

        if ($ok) {
            $this->banner(__('Now you are subscribed in our chanel. Thanks !'));
            $this->close = true;
        } else {
            $this->dangerBanner(__("Couldn't not subscribe now. Try a few minutes later"));
        }
    }

    public function render()
    {
        return view('octo::livewire.subscribe', [
            'headline' => config('octo.plugins.subscribe.headline'),
            'tagline' => config('octo.plugins.subscribe.tagline'),
            'closable' =>  $this->closable,
            'bg' =>  $this->bg,
        ]);
    }
}
