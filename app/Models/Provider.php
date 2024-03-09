<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
class Provider extends Model implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'otp',
        'mobile_number',
        'address',
        'city',
        'state',
        'country',
        'zipcode',
        'working_hours',
        'business_hours_enabled',
        'experience',
        'rate',
        'category_id',
        'service_id',
        'specialization',
        'portfolio',
        'profile_pic',
        'email_verified_at',
        'otp_valid_until'
    ];

    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

}
