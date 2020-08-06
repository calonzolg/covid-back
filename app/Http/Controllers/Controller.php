<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $covid_api;

    protected $host;

    protected $key;

    public function __construct()
    {
        $this->covid_api = new Client(['base_uri' => config('services.covid_api.uri')]);
        $this->host = parse_url(config('services.covid_api.uri'), PHP_URL_HOST);
        $this->key = config('services.covid_api.key');
    }
}
