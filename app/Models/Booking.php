<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'service_id',
        'provider_id',
        'user_id',
        'zipcode',
        'address',
        'city',
        'state',
        'country',
        'booking_date',
        'booking_time',
        'status',
    ];

    // Define relationships
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
