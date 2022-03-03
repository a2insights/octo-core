<?php

namespace Octo\Common\Http\Livewire;

use Illuminate\Support\Facades\Cookie;
use Laravel\Jetstream\InteractsWithBanner;
use LivewireUI\Modal\ModalComponent;
use Spatie\Newsletter\NewsletterFacade;

class Subscribe extends ModalComponent
{
    use InteractsWithBanner;

    /**
     * The email of subscribe intent
     *
     * @var string
     */
    public string $email;

    /**
     * Rules of form
     *
     * @var string[]
     */
    protected array $rules = [
        'email' => 'required|email'
    ];

    /**
     * Close banner state
     *
     * @var bool
     */
    public bool $close = false;

    /**
     * Determini if banner can be closed
     *
     * @var bool
     */
    public bool $closable = true;

    /**
     * The background of banner
     *
     * @var string
     */
    public string $bg = 'white';

    /**
     * Cookie to store subscribe state
     *
     * @var string
     */
    private string $cookieName = 'subscribe_show';

    /**
     * Mount the component data
     *
     * @return void
     */
    public function mount()
    {
        if (request()->user() && NewsletterFacade::isSubscribed(request()->user()->email)) {
            $this->close = true;
            return;
        }

        $this->close = (bool) request()->cookie($this->cookieName);
    }

    /**
     * Hidde banner
     *
     * @return void
     */
    public function hiddeBanner()
    {
        $this->close = true;

        Cookie::queue($this->cookieName, 1, 60*24*10);
    }

    /**
     * Subscribe email to newsletter
     *
     * @return void
     */
    public function subscribe()
    {
        $this->validate();

        $subscribed = NewsletterFacade::subscribeOrUpdate($this->email);

        if ($subscribed) {
            $this->banner(__('octo::messages.subscribe.success'));
            $this->hiddeBanner();
        } else {
            $this->dangerBanner(__("octo::messages.subscribe.success.error"));
        }
    }

    /**
     * Render the view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('octo::components.subscribe', [
            'headline' => __('octo::messages.subscribe.headline'),
            'tagline' => __('octo::messages.subscribe.tagline'),
            'closable' => $this->closable,
            'bg' => $this->bg
        ]);
    }
}
