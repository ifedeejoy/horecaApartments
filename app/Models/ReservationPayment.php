<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'payment_status',
        'payment_method',
        'service_charge',
        'discount_reason',
        'discount_amount',
        'total',
        'paid',
        'balance',
        'createdBy',
        'refund',
        'modifiedBy'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
