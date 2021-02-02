<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inhouse extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'guest_bill';

    protected $fillable = [
        'reservation_id', 'guest_id', 'service', 'description', 'price', 'status'
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function payments()
    {
        return $this->hasMany(GuestPayment::class);
    }

    public function reservations()
    {
        return $this->belongsTo(Reservation::class);
    }
}
