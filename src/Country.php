<?php

namespace Octo;

use Illuminate\Support\Str;
use PragmaRX\Countries\Package\Countries;
use PragmaRX\Countries\Package\Support\Collection;
use Stidges\CountryFlags\CountryFlag;
use Symfony\Component\Intl\Intl;
use WhiteCube\Lingua\Service as Lingua;

class Country extends ObjectPrototype
{
    /**
     * Object attributes
     *
     * @var string[]
     */
    protected $attributes = [
        'id', 'name', 'calling_code',
        'flag', 'phone_format', 'iso_code',
        'language', 'locale', 'language_code'
    ];

    /**
     * Locale language
     *
     * @var
     */
    private $localeTr;

    /**
     * Set locale for translation
     *
     * @param $localeTr
     * @return Country
     */
    public function setLocale($localeTr): Country
    {
        $this->localeTr = $localeTr;

        return $this;
    }

    /**
     * Return all countries
     *
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return $this->mapAll();
    }

    /**
     * Map countries to candy data
     *
     * @return \Illuminate\Support\Collection
     */
    private function mapAll()
    {
        if (!$this->localeTr) {
            $this->localeTr = config('app.locale');
        }

        $translatedNamed = Intl::getRegionBundle()->getCountryNames($this->localeTr);

        $countries = new Countries();

        return collect(array_keys($translatedNamed))
            ->map(function ($code) use ($countries, $translatedNamed) {
                $country = $countries->where('cca2', $code)->first();
                return $this->create($country, $translatedNamed);
            })
            ->whereNotNull('calling_code')
            ->values();
    }

    /**
     * Create country data
     *
     * @param Collection $country
     * @param array $translatedNamed
     * @return array|Country|null
     */
    private function create(Collection $country, array $translatedNamed)
    {
        $maskbase = '99999999999999999999999';

        $callingCode = preg_replace("/[^0-9]/", "", $country['dialling']['calling_code'][0] ?? $country['callingCodes'][0] ?? null);

        $nationalDestinationCodeLengths = $country['dialling']['national_destination_code_lengths'] ?? null;
        $nationalNumberLengths = $country['dialling']['national_number_lengths'] ?? null;

        if ($nationalDestinationCodeLengths && $nationalNumberLengths) {
            $nationalDestinationCodePattern = Str::substr($maskbase,0, end($nationalDestinationCodeLengths));
            $nationalNumberPattern = Str::substr($maskbase,0, end($nationalNumberLengths) - end($nationalDestinationCodeLengths));
        }

        $object = null;

        $oficialLanguage = isset($country['languages']) ? array_values($country['languages']->toArray()) : [];
        $oficialLanguage = isset($oficialLanguage[0]) ? strtolower($oficialLanguage[0]) : null;

        if (isset($translatedNamed[$country['cca2']]) && isset($nationalDestinationCodePattern) && isset($nationalNumberPattern)) {
            try {
                $language = Lingua::createFromName($oficialLanguage);
                $object = new Country([
                    'id' => $country['cca2'],
                    'iso_code' => $country['iso_a2'],
                    'language_code' => $language->toISO_639_1(),
                    'language' => $oficialLanguage,
                    'phone_format' => "$nationalDestinationCodePattern $nationalNumberPattern",
                    'calling_code' => $callingCode,
                    'locale' => $language->toISO_639_1().'_'.$country['cca2'],
                    'flag' => (new CountryFlag())->get($country['cca2']),
                    'name' => $translatedNamed[$country['cca2']]
                ]);
            } catch (\Exception $exception){
                return null;
            }
        }

        if (! $object) {
            return null;
        }

        return $object;
    }
}
