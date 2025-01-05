<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingsController extends Controller
{
    public function index(){
        $bookings = Booking::active()->get();

        return response()->json([
            'message' =>'bookings Data',
            'data'    => $bookings
        ], 200);
    }

    public function store(Request $request){
        if($request->user()->role != 'user'){
            return response()->json([
                'message' => 'Anda tidak memiliki izin untuk melakukan aksi ini!'
            ], 401);
        }
        else{
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'room_id' => 'required',
                'unit_id' => 'required',
                'event_date' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'status' => 'required'
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'message' => 'Semua data wajib diisi!',
                    'data' => $validator->errors()
                ], 401);
            }
            else{
                $bookings = Booking::create([
                    'user_id' => $request->input('user_id'),
                    'room_id' => $request->input('room_id'),
                    'unit_id' => $request->input('unit_id'),
                    'event_date' => $request->input('event_date'),
                    'start_time' => $request->input('start_time'),
                    'end_time' => $request->input('end_time'),
                    'status' => $request->input('status')
                ]);
    
                if($bookings){
                    return response()->json([
                        'message' => 'Booking berhasil disimpan!',
                        'data' => $bookings
                    ], 201);
                }
                else{
                    return response()->json([
                        'message' => 'Booking gagal disimpan!'
                    ], 400);
                }
            }
        }
    }

    public function show($id){
        $bookings = Booking::where('id', $id)
                    -> where('is_deleted', false)
                    -> first();

        if($bookings){
            return response()->json([
                'message' => 'Booking berhasil ditemukan!',
                'data' => $bookings
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'Booking tidak ditemukan!'
            ], 404);
        }
    }

    public function update(Request $request, $id){
        if($request->user()->role != 'user'){
            return response()->json([
                'message' => 'Anda tidak memiliki izin untuk melakukan aksi ini!'
            ], 401);
        }
        else{
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'room_id' => 'required',
                'unit_id' => 'required',
                'event_date' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'status' => 'required'
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'message' => 'Semua kolom wajib diisi!',
                    'data' => $validator->errors()
                ], 401);
            }
            else{
                $bookings = Booking::where('id', $id)
                             ->where('is_deleted', false)
                             ->update([
                                'user_id' => $request->input('user_id'),
                                'room_id' => $request->input('room_id'),
                                'unit_id' => $request->input('unit_id'),
                                'event_date' => $request->input('event_date'),
                                'start_time' => $request->input('start_time'),
                                'end_time' => $request->input('end_time'),
                                'status' => $request->input('status')
                            ]);
    
                if($bookings){
                    return response()->json([
                        'message' => 'Booking berhasil diupdate',
                        'data' => $bookings
                    ], 201);
                }
                else{
                    return response()->json([
                        'message' => 'Booking gagal diupdate!'
                    ], 400);
                }
            }
        }
    }

    public function destroy(Request $request, $id){
        if($request->user()->role != 'user'){
            return response()->json([
                'message' => 'Anda tidak memiliki izin untuk melakukan aksi ini!'
            ], 401);
        }
        else{
            $bookings = Booking::where('id', $id)
                     ->where('is_deleted', false)
                     ->first();

            if($bookings){
                $bookings->softDelete();
                return response()->json([
                    'message' => 'Booking berhasil dihapus!'
                ], 200);
            }
            else{
                return response()->json([
                    'message' => 'Booking tidak ditemukan!'
                ], 404);
            }
        }
    }
}