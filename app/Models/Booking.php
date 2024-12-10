<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model{

    protected $table = 'bookings';

    protected $casts = [
        'is_deleted' => 'boolean'
    ];

    protected $fillable = [
        'user_id', 'room_id', 'unit_id', 'event_date', 'start_time', 'end_time', 'status'
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

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function rooms(){
        return $this->belongsTo(Room::class);
    }

    public function units(){
        return $this->belongsTo(Unit::class);
    }

}