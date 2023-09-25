<?php

namespace App\Http\Controllers;

use App\Helper\FoodHelper;
use App\Models\History;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index()
    {
        $client = new Client();
        $response = $client->request('GET', env('API_URL_SERVER_FOOD') . '/api/foods');
        $foods = json_decode($response->getBody()->getContents(), true)['data'];

        return view('pages.food', compact(['foods']));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'food_id' => 'required',
            'quantity' => 'required'
        ]);

        $payload = [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'food_id' => $request->food_id,
            'quantity' => $request->quantity
        ];

        $client = new Client();
        $response = $client->request('POST', env('API_URL_SERVER_FOOD') . '/api/transactions', [
            'form_params' => $payload
        ]);
        $transaction = json_decode($response->getBody()->getContents(), true);

        if ($transaction['status_code'] != 201) {
            dd($transaction['message']);
        }

        $foodHelper = new FoodHelper();
        $food = $foodHelper->getFood($request->food_id);

        $payloadHistory = [
            'transaction_id' => $transaction['data']['id'],
            'food_id' => $food['id'],
            'user_id' => auth()->user()->id
        ];

        if (History::create($payloadHistory)) {
            return redirect()->back()->with('success', 'Berhasil membeli ' . $food['name']);
        }

        return redirect()->back()->withErrors('failed', 'Gagal membeli ' . $food['name']);
    }
}
