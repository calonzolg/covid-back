<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;

class DetailController extends Controller
{
    public function __invoke($slug)
    {
        try {
            $response = $this->fetchCountry($slug);

            $response = json_decode($response->getBody()->getContents());
            $collection = collect($response->{'response'});

            $data = $collection->toArray();

            return response()->json($data, 200);
        } catch (GuzzleException $exception) {
            return response()->json(["Error" => $exception], 400);
        }
    }
}
