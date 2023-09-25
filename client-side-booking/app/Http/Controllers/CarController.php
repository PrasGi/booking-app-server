<?php

namespace App\Http\Controllers;

use App\Helper\CarHelper;
use App\Models\History;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        $client = new Client();
        $response = $client->request('GET', env('API_URL_SERVER_CAR') . '/api/cars');
        $cars = json_decode($response->getBody()->getContents(), true)['data'];

        return view('pages.car', compact(['cars']));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'car_id' => 'required',
            'quantity' => 'required'
        ]);

        $payload = [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'car_id' => $request->car_id,
            'quantity' => $request->quantity
        ];

        $client = new Client();
        $response = $client->request('POST', env('API_URL_SERVER_CAR') . '/api/transactions', [
            'form_params' => $payload
        ]);
        $transaction = json_decode($response->getBody()->getContents(), true);

        if ($transaction['status_code'] != 201) {
            dd($transaction['message']);
        }

        $carHelper = new CarHelper();
        $car = $carHelper->getCar($request->car_id);

        $payloadHistory = [
            'transaction_id' => $transaction['data']['id'],
            'car_id' => $car['id'],
            'user_id' => auth()->user()->id
        ];

        if (History::create($payloadHistory)) {
            return redirect()->back()->with('success', 'Berhasil membeli ' . $car['name']);
        }

        return redirect()->back()->withErrors('failed', 'Gagal membeli ' . $car['name']);
    }
}
