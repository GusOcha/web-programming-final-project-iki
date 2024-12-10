<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitsController extends Controller
{

    public function index(){

        $units = Unit::active()->get();

        return response()->json([
            'message' =>'Units Data',
            'data'    => $units
        ], 200);

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'unit_name' => 'required'
        ]);

        if($validator->fails()){

            return response()->json([
                'message' => 'Semua data wajib diisi!',
                'data' => $validator->errors()
            ], 401);

        }
        else{

            $units = Unit::create([
                'unit_name' => $request->input('unit_name')
            ]);

            if($units){
                return response()->json([
                    'message' => 'Unit berhasil disimpan!',
                    'data' => $units
                ], 201);
            }
            else{

                return response()->json([
                    'message' => 'Unit gagal disimpan!'
                ], 400);

            }
        }

    }

    public function show($id){
        $units = Unit::where('id', $id)
                    -> where('is_deleted', false)
                    ->first();

        if($units){
            return response()->json([
                'message' => 'Unit berhasil ditemukan!',
                'data' => $units
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'Unit tidak ditemukan!'
            ], 404);
        }
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'unit_name' => 'required'
        ]);

        if($validator->fails()){

            return response()->json([
                'message' => 'Semua kolom wajib diisi!',
                'data' => $validator->errors()
            ], 401);

        }
        else{

            $units = Unit::where('id', $id)
                         ->where('is_deleted', false)
                         ->update([
                            'unit_name' => $request->input('unit_name')
                        ]);

            if($units){

                return response()->json([
                    'message' => 'Unit berhasil diupdate',
                    'data' => $units
                ], 201);

            }
            else{

                return response()->json([
                    'message' => 'Unit gagal diupdate!'
                ], 400);
            }

        }

    }

    public function destroy($id){

        $units = Unit::whereId($id)->first();

        if($units){
            $units->softDelete();
            return response()->json([
                'message' => 'Unit berhasil dihapus!'
            ], 200);
        }

    }

}