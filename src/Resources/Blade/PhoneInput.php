<?php

namespace Octo\Resources\Blade;

use Illuminate\Support\Facades\Request;
use Octo\Country;

class PhoneInput extends Component
{
    /**
     * The country service manager
     *
     * @var $countryRepository
     */
    public $countryRepository;

    /**
     * Initialize the service
     *
     * PhoneInput constructor.
     */
    public function __construct()
    {
        $this->countryRepository = new Country;
    }

    /**
     * Render de view component
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('octo::blade.phone-input', [
            'country' => json_encode($this->getCountry()->toArray()),
            'countries' => json_encode($this->countryRepository->setLocale($this->getCountry()->locale)->all())
        ]);
    }

    private function getCountry()
    {
        return $this->countryRepository->all()
            ->where('iso_code', geoip(Request::ip())->iso_code)
            ->first();
    }
}
