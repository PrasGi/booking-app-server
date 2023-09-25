<?php

namespace App\Http\Controllers;

use App\Models\History;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $histories = History::where('user_id', auth()->user()->id)->latest()->get();
        $client = new Client();


        $datas = null;

        foreach ($histories as $data) {

            if ($data->food_id) {
                $responseTransaction = $client->request('GET', env('API_URL_SERVER_FOOD') . '/api/transactions/' . $data->transaction_id);
                $transaction = json_decode($responseTransaction->getBody()->getContents(), true)['data'];
            } else if ($data->car_id) {
                $responseTransaction = $client->request('GET', env('API_URL_SERVER_CAR') . '/api/transactions/' . $data->transaction_id);
                $transaction = json_decode($responseTransaction->getBody()->getContents(), true)['data'];
            }

            if ($data->food_id) {
                $responseItem = $client->request('GET', env('API_URL_SERVER_FOOD') . '/api/foods/' . $data->food_id);
                $item = json_decode($responseItem->getBody()->getContents(), true)['data'];
            } else if ($data->car_id) {
                $responseItem = $client->request('GET', env('API_URL_SERVER_CAR') . '/api/cars/' . $data->car_id);
                $item = json_decode($responseItem->getBody()->getContents(), true)['data'];
            }

            $temp = [
                'name' => $item['name'],
                'description' => $item['description'],
                'quantity' => $transaction['quantity'],
                'price' => $item['price'],
                'total' => $transaction['total'],
                'image' => $item['image'],
                'conrimed_at' => $transaction['confirmed_at'] ? 'confirmed' : 'waiting',
                'date' => Carbon::parse($transaction['created_at'])->format('d F Y')
            ];

            if ($data->food_id) {
                $temp['image'] = $temp['image'] ? env('API_URL_SERVER_FOOD') . '/storage/' . $temp['image'] : null;
            } else if ($data->car_id) {
                $temp['image'] = $temp['image'] ? env('API_URL_SERVER_CAR') . '/storage/' . $temp['image'] : null;
            }

            $datas[] = $temp;
        }

        return view('welcome', compact(['datas']));
    }
}
