<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $response = $this->fetchCovidApi();
        $search = $request->input('searchParam');

        $response = json_decode($response->getBody()->getContents());
        $collection = collect($response->{'response'});

        $data = $this->getCountriesGroupByContinent($collection, $search);

        return response()->json($data, 200);
    }
}
