<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status_code' => 200,
            'message' => 'Success get all datas',
            'data' => Car::all()
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
            'image' => $request->image,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ], [
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|string'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status_code' => 400,
                'message' => 'Bad Request'
            ]);
        }

        $payload = $request->only(['name', 'description', 'price']);
        if ($request->image) {
            $payload['image'] = $request->file('image')->store('images', 'public');
        }

        if ($car = Car::create($payload)) {
            return response()->json([
                'status_code' => 200,
                'message' => 'Success add new car',
                'data' => $car
            ]);
        }

        return response()->json([
            'status_code' => 500,
            'message' => 'Internal Server Error'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        return response()->json([
            'status_code' => 200,
            'message' => 'Success get data',
            'data' => $car
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $validate = Validator::make([
            'image' => $request->image,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ], [
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'nullable|string'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status_code' => 400,
                'message' => $validate->errors()
            ]);
        }

        $payload = $request->only(['name', 'description', 'price']);
        if ($request->image) {
            $payload['image'] = $request->file('image')->store('images', 'public');
        }

        if ($car->update($payload)) {
            return response()->json([
                'status_code' => 200,
                'message' => 'Success update car',
                'data' => $car
            ]);
        }

        return response()->json([
            'status_code' => 500,
            'message' => 'Internal Server Error'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        if ($car->delete()) {
            return response()->json([
                'status_code' => 200,
                'message' => 'Success delete car'
            ]);
        }

        return response()->json([
            'status_code' => 500,
            'message' => 'Internal Server Error'
        ]);
    }
}
