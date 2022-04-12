<?php

namespace Octo\Common\View\Components;

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
        return view('octo::components.phone-input', [
            'country' => json_encode($this->getCountry()->toArray()),
            'countries' => json_encode(
                $this->countryRepository->setLocale($this->getCountry()->locale)
                    ->all()
                    ->map(fn ($c) => $this->preventFlag($c))
            )
        ]);
    }

    private function getCountry()
    {
        return $this->countryRepository->all()
            ->where('iso_code', geoip(Request::ip())->iso_code)
            ->map(fn ($c) => $this->preventFlag($c))
            ->first();
    }

    private function preventFlag($country)
    {
        if ($country->calling_code == '1') {
            $country->flag =  '🇺🇸 🇨🇦';
        }

        return $country;
    }
}
