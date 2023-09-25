<?php

namespace App\Helper;

use GuzzleHttp\Client;

class CarHelper
{
    public function getCar($id)
    {
        $client = new Client();
        $response = $client->request('GET', env('API_URL_SERVER_CAR') . '/api/cars/' . $id);
        $food = json_decode($response->getBody()->getContents(), true)['data'];

        return $food;
    }
}
