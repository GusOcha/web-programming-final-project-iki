<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    public function index(){

        $users = User::active()->get();

        return response()->json([
            'message' =>'Users Data',
            'data'    => $users
        ], 200);

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'unit_id' => 'required',
            'user_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

        if($validator->fails()){

            return response()->json([
                'message' => 'Semua data wajib diisi!',
                'data' => $validator->errors()
            ], 401);

        }
        else{

            $users = User::create([
                'unit_id' => $request->input('unit_id'),
                'user_name' => $request->input('user_name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'role' => $request->input('role')
            ]);

            if($users){
                return response()->json([
                    'message' => 'User berhasil disimpan!',
                    'data' => $users
                ], 201);
            }
            else{

                return response()->json([
                    'message' => 'User gagal disimpan!'
                ], 400);

            }
        }

    }

    public function show($id){
        $users = User::where('id', $id)
                    -> where('is_deleted', false)
                    -> first();

        if($users){
            return response()->json([
                'message' => 'User berhasil ditemukan!',
                'data' => $users
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'User tidak ditemukan!'
            ], 404);
        }
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'unit_id' => 'required',
            'user_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

        if($validator->fails()){

            return response()->json([
                'message' => 'Semua kolom wajib diisi!',
                'data' => $validator->errors()
            ], 401);

        }
        else{

            $users = User::where('id', $id)
                         ->where('is_deleted', false)
                         ->update([
                            'unit_id' => $request->input('unit_id'),
                            'user_name' => $request->input('user_name'),
                            'email' => $request->input('email'),
                            'password' => $request->input('password'),
                            'role' => $request->input('role')
                        ]);

            if($users){

                return response()->json([
                    'message' => 'User berhasil diupdate',
                    'data' => $users
                ], 201);

            }
            else{

                return response()->json([
                    'message' => 'User gagal diupdate!'
                ], 400);
            }

        }

    }

    public function destroy($id){

        $users = User::where('id', $id)
                     ->where('is_deleted', false)
                     ->first();

        if($users){
            $users->softDelete();
            return response()->json([
                'message' => 'User berhasil dihapus!'
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'User tidak ditemukan!'
            ], 404);
        }

    }

}