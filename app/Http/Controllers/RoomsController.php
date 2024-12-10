<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomsController extends Controller
{

    public function index(){

        $rooms = Room::active()->get();

        return response()->json([
            'message' =>'Rooms Data',
            'data'    => $rooms
        ], 200);

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'room_name' => 'required',
            'capacity' => 'required',
            'facilities' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails()){

            return response()->json([
                'message' => 'Semua data wajib diisi!',
                'data' => $validator->errors()
            ], 401);

        }
        else{

            $rooms = Room::create([
                'room_name' => $request->input('room_name'),
                'capacity' => $request->input('capacity'),
                'facilities' => $request->input('facilities'),
                'status' => $request->input('status')
            ]);

            if($rooms){
                return response()->json([
                    'message' => 'Room berhasil disimpan!',
                    'data' => $rooms
                ], 201);
            }
            else{

                return response()->json([
                    'message' => 'Room gagal disimpan!'
                ], 400);

            }
        }

    }

    public function show($id){
        $rooms = Room::where('id', $id)
                    -> where('is_deleted', false)
                    ->first();

        if($rooms){
            return response()->json([
                'message' => 'Room berhasil ditemukan!',
                'data' => $rooms
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'Room tidak ditemukan!'
            ], 404);
        }
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'room_name' => 'required',
            'capacity' => 'required',
            'facilities' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails()){

            return response()->json([
                'message' => 'Semua kolom wajib diisi!',
                'data' => $validator->errors()
            ], 401);

        }
        else{

            $rooms = Room::where('id', $id)
                         ->where('is_deleted', false)
                         ->update([
                            'room_name' => $request->input('room_name'),
                            'capacity' => $request->input('capacity'),
                            'facilities' => $request->input('facilities'),
                            'status' => $request->input('status')
                        ]);

            if($rooms){

                return response()->json([
                    'message' => 'Room berhasil diupdate',
                    'data' => $rooms
                ], 201);

            }
            else{

                return response()->json([
                    'message' => 'Room gagal diupdate!'
                ], 400);
            }

        }

    }

    public function destroy($id){

        $rooms = Room::where('id', $id)
                     ->where('is_deleted', false)
                     ->first();

        if($rooms){
            $rooms->softDelete();
            return response()->json([
                'message' => 'Room berhasil dihapus!'
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'Room tidak ditemukan!'
            ], 404);
        }

    }

}