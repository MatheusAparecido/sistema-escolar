<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credenciais = $request->only('email', 'password');

        if (Auth::attempt($credenciais)) {

            $user = Auth::user();

            return response()->json([
                "status" => true,
                "user" => $user
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Login inválido"
        ], 401);
    }
}
