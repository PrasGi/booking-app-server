<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ], [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validate->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => Role::where('name', 'user')->first()->id,
        ]);

        try {
            //code...
            Auth::login($user);
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status_code' => 201,
                'message' => 'Success',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                ],
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status_code' => 500,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function login(Request $request)
    {
        $validate = Validator::make([
            'email' => $request->email,
            'password' => $request->password,
        ], [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validate->errors(),
            ], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status_code' => 401, // 'Unauthorized
                'message' => 'Email or password is incorrect',
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status_code' => 200,
            'message' => 'Success',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        if (Auth::user()->tokens()->delete()) {
            return response()->json([
                'status_code' => 200,
                'message' => 'Logout Successful',
            ]);
        }

        return response()->json([
            'status_code' => 400,
            'message' => 'Logout Failed',
        ]);
    }
}
