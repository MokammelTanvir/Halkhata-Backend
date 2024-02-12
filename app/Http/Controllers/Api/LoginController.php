<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthenticationRequest;

class LoginController extends Controller
{
    public function login(AuthenticationRequest $request)
    {
        $credentials =[
            'email' => $request->email,
            'password' => $request->password
        ];
        if(Auth::attempt($credentials, true)){
            $user = Auth::user();

            $response = [
                'status_code' => 200,
                'status' => 'success',
                'data' => [
                    'token' => $user->createToken('MyApp')->plainTextToken,
                    'name' => $user->name,
                ],
                'message' => 'User logged in successfully'

            ];
            return response()->json($response, 200);

        }else{
            $response = [
                'status_code' => 401,
                'status' => 'error',
                'data' => null,
                'message' => 'Invalid credentials'
            ];
            return response()->json($response, 401);
        }

    }
}
