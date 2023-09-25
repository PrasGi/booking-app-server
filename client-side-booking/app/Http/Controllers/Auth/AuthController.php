<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function registerForm()
    {
        return view('register');
    }
    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $validate['password'] = bcrypt($validate['password']);
        $user = User::create($validate);
        Auth::login($user);
        return redirect()->route('dashboard');
    }
    public function loginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($validate)) {
            return redirect()->route('dashboard');
        }

        return redirect()->back()->withErrors([
            'failed' => 'email or password is wrong'
        ]);
    }

    public function logout()
    {
        try {
            //code...
            Auth::logout();
            return redirect()->route('login.form');
        } catch (\Throwable $th) {
            //throw $th;
            return abort(500, $th->getMessage());
        }
    }
}
