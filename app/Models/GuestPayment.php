<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'guest_id',
        'type',
        'description',
        'payment_method',
        'amount'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
}
