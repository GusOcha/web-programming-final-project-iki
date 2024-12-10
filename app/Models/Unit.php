<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model{

    protected $table = 'units';

    protected $casts = [
        'is_deleted' => 'boolean'
    ];

    protected $fillable = [
        'unit_name', 'is_deleted'
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
        return $this->hasMany(User::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);       
    }

}