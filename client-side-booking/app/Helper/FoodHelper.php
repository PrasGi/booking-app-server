<?php

namespace App\Helper;

use GuzzleHttp\Client;

class FoodHelper
{
    public function getFood($id)
    {
        $client = new Client();
        $response = $client->request('GET', env('API_URL_SERVER_FOOD') . '/api/foods/' . $id);
        $food = json_decode($response->getBody()->getContents(), true)['data'];

        return $food;
    }
}
