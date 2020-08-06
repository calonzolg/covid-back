<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class CovidApiController extends Controller
{
    public function __invoke()
    {
        $response = $this->covid_api->get('statistics', [
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->key
            ]
        ]);

        $response = json_decode($response->getBody()->getContents());

        return response()->json($response, 200);
    }
}
