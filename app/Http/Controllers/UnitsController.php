<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitsController extends Controller
{
    public function index(Request $request){
        if($request->user()->role != 'admin'){
            return response()->json([
                'message' => 'Anda tidak memiliki izin untuk melakukan aksi ini!'
            ], 401);
        }
        else{
            $units = Unit::active()->get();

            return response()->json([
                'message' =>'Units Data',
                'data'    => $units
            ], 200);
        }
    }

    public function store(Request $request){
        if($request->user()->role != 'admin'){
            return response()->json([
                'message' => 'Anda tidak memiliki izin untuk melakukan aksi ini!'
            ], 401);
        }
        else{
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
    }

    public function show(Request $request, $id){
        if($request->user()->role != 'admin'){
            return response()->json([
                'message' => 'Anda tidak memiliki izin untuk melakukan aksi ini!'
            ], 401);
        }
        else{
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
    }

    public function update(Request $request, $id){
        if($request->user()->role != 'admin'){
            return response()->json([
                'message' => 'Anda tidak memiliki izin untuk melakukan aksi ini!'
            ], 401);
        }
        else{
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
    }

    public function destroy(Request $request, $id){
        if($request->user()->role != 'admin'){
            return response()->json([
                'message' => 'Anda tidak memiliki izin untuk melakukan aksi ini!'
            ], 401);
        }
        else{
            $units = Unit::whereId($id)->first();

            if($units){
                $units->softDelete();
                return response()->json([
                    'message' => 'Unit berhasil dihapus!'
                ], 200);
            }
            else{
                return response()->json([
                    'message' => 'Unit tidak ditemukan!'
                ], 404);
            }
        }
    }
}