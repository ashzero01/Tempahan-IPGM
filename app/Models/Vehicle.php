<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'registration_number',
        'type',
        'status',
        'description',
    ];

    // Define the relationship with VehicleBooking
    public function bookings()
    {
        return $this->hasMany(VehicleBooking::class);
    }
}