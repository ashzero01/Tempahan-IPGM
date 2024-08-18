<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name', 'description', 'images']; // Include 'image' in $fillable

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Accessor method to get the full URL of the image
    public function getImageUrlAttribute()
    {
        // Assuming images are stored in the 'public/images' directory
        if ($this->image) {
            return asset('images/' . $this->image);
        }
        // If no image is set, return a placeholder or default image URL
        return asset('images/default.jpg');
    }
}
