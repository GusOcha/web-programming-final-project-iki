<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'unit_id' => 'required',
            'user_name' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/'
            ]
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Semua data wajib diisi!',
                'data' => $validator->errors()
            ], 401);
        }
        else{
            $data = [
                'unit_id' => $request->input('unit_id'),
                'user_name' => $request->input('user_name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'role' => 'user',
                'api_token' => 'user_token'
            ];
    
            $data['password'] = Hash::make($data['password']);
    
            User::create($data);
    
            return response()->json([
                    'message' => 'Register berhasil!',
                    'data' => $data
            ]);
        }
    }

    public function login(Request $request){ 
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Semua data wajib diisi!',
                'data' => $validator->errors()
            ], 401);
        }
        else{
            $email = $request->input('email');
            $password = $request->input('password');
    
            $user = User::where('email', $email)->first();
    
            if($user && Hash::check($password, $user->password)){
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
}
