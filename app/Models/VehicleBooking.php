<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'departure_date',
        'departure_time',
        'return_date',
        'return_time',
        'destination',
        'purpose',
        'status',
    ];

    // Define the relationship with Vehicle
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    // Define the relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
