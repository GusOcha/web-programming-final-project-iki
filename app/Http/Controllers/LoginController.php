<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function register(Request $request){
        $data = [
            'unit_id' => $request->input('unit_id'),
            'user_name' => $request->input('user_name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'role' => 'user',
            'api_token' => 'user_token'
        ];

        User::create($data);

        return response()->json($data);
    }

    public function login(Request $request){ 
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if($user->password === $password){
            $token = Str::random(40);

            $user->update([
                'api_token' => $token
            ]);

            return response()->json([
                'message' => 'Login berhasil!',
                'token' => $token,
                'data' => $user
            ]);
        }
        else{
            return response()->json([
                'message' => 'Login gagal!',
                'data' => ''
            ]); 
        }
    }
}
