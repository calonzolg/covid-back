<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Laravel\Lumen\Routing\Controller as BaseController;
use Psr\Http\Message\ResponseInterface;

class Controller extends BaseController
{
    protected $covid_api;

    protected $host;

    protected $key;

    protected $continents;

    public function __construct()
    {
        $this->covid_api = new Client(['base_uri' => config('services.covid_api.uri')]);
        $this->host = parse_url(config('services.covid_api.uri'), PHP_URL_HOST);
        $this->key = config('services.covid_api.key');
        $this->continents = [
            'North-America',
            'South-America',
            'Asia',
            'Africa',
            'Europe',
            'Oceania'
        ];
    }

    /**
     * @param $collection
     * @param $continent
     *
     * @param null $search
     *
     * @return mixed
     */
    function getCountries($collection, $continent, $search = null)
    {
        return array_values(
            $collection->filter(
                function ($country) use ($continent, $search) {
                    if ($country->continent !== $continent) {
                        return false;
                    }

                    if (!(preg_match("/" . $search . "/i", $country->country))) {
                        return false;
                    }

                    return true;
                }
            )->map(
                function ($country) {
                    return [
                        'name' => str_replace('-', ' ', $country->country),
                        'cases' => $country->cases,
                        'last_update' => Carbon::parse($country->time)->format('m/d/Y H:m'),
                        'slug' => strtolower($country->country),
                    ];
                }
            )->toArray()
        );
    }

    /**
     * @return ResponseInterface
     * @throws GuzzleException
     */
    function fetchCovidApi()
    {
        return $this->covid_api->get(
            'statistics',
            [
                'headers' => [
                    'x-rapidapi-host' => $this->host,
                    'x-rapidapi-key' => $this->key
                ],
            ]
        );
    }

    /**
     * @param $slug
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    function fetchCountry($slug)
    {
        return $this->covid_api->get(
            'statistics',
            [
                'headers' => [
                    'x-rapidapi-host' => $this->host,
                    'x-rapidapi-key' => $this->key
                ],
                'query' => [
                    'country' => $slug,
                ]
            ]
        );
    }

    /**
     * @param $collection
     * @param null $search
     *
     * @return array[]
     */
    function getCountriesGroupByContinent($collection, $search = null)
    {
        return array_map(
            function ($continent) use ($collection, $search) {
                return [
                    'name' => str_replace('-', ' ', $continent),
                    'countries' => $this->getCountries($collection, $continent, $search)
                ];
            },
            $this->continents
        );
    }
}
