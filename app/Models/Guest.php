<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'name',
        'email',
        'phone',
        'address',
        'country',
        'id_type',
        'id_file',
    ];

    protected $hidden = ['password'];
    
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function payments()
    {
        return $this->hasMany(GuestPayment::class);
    }
}
