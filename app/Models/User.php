<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model{

    protected $table = 'users';

    protected $casts = [
        'is_deleted' => 'boolean' 
    ];

    protected $fillable = [
        'unit_id', 'user_name', 'email', 'password', 'role', 'api_token', 'is_deleted'
    ];

    protected $hidden = [

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

    public function units(){
        return $this->belongsTo(Unit::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

}