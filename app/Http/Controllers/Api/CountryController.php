<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;

class CountryController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function __invoke()
    {
        try {
            $response = $this->fetchCovidApi();

            $response = json_decode($response->getBody()->getContents());
            $collection = collect($response->{'response'});

            $data = $this->getCountriesGroupByContinent($collection);

            return response()->json($data, 200);
        } catch (GuzzleException $exception) {
            return response()->json(["Error" => $exception], 400);
        }
    }
}
