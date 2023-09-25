<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->email) {
            $transactions = Transaction::where('email', $request->email)->get();
        } else {
            $transactions = Transaction::all();
        }

        return response()->json([
            'status_code' => 200,
            'message' => 'Success',
            'data' => $transactions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make([
            'name' => $request->name,
            'email' => $request->email,
            'car_id' => $request->car_id,
            'quantity' => $request->quantity,
        ], [
            'name' => 'required',
            'email' => 'required|email',
            'car_id' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status_code' => 400,
                'message' => 'Bad Request',
                'errors' => $validate->errors()
            ]);
        }

        $car = Car::find($request->car_id);
        $payload = $request->only(['name', 'email', 'car_id', 'quantity']);
        $payload['total'] = $request->quantity * $car->price;

        if ($transaction = Transaction::create($payload)) {
            return response()->json([
                'status_code' => 201,
                'message' => 'Transaction created successfully',
                'data' => $transaction
            ]);
        }

        return response()->json([
            'status_code' => 500,
            'message' => 'Error creating transaction'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return response()->json([
            'status_code' => 200,
            'message' => 'Success',
            'data' => $transaction
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validate = Validator::make([
            'confirmed_at' => $request->confirmed_at,
        ], [
            'confirmed_at' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status_code' => 400,
                'message' => 'Bad Request',
                'errors' => $validate->errors()
            ]);
        }

        $payload = $request->only(['confirmed_at']);

        if ($transaction->update($payload)) {
            return response()->json([
                'status_code' => 200,
                'message' => 'Transaction updated successfully',
                'data' => $transaction
            ]);
        }

        return response()->json([
            'status_code' => 500,
            'message' => 'Error updating transaction'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        if ($transaction->delete()) {
            return response()->json([
                'status_code' => 200,
                'message' => 'Transaction deleted successfully',
            ]);
        }

        return response()->json([
            'status_code' => 500,
            'message' => 'Error deleting transaction'
        ]);
    }
}
