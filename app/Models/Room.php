<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model{

    protected $table = 'rooms';

    protected $casts = [
        'is_deleted' => 'boolean'
    ];

    protected $fillable = [
        'room_name', 'capacity', 'facilities', 'status', 'is_deleted'
    ];

    public function scopeActive($query){
        return $query->where('is_deleted', false);
    }

    public function scopeDeleted($query){
        return $query->where('is_deleted', true);
    }

    public function softDelete(){
        $this->is_deleted = true;
        return $this->save();
    }

    public function restoreDelete(){
        $this->is_deleted = false;
        return $this->save();
    }

    public function bookings(){
        return $this->hasOne(Booking::class);
    }

}