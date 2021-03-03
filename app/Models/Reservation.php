<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reference', 'apartments_id', 'checkin', 'checkout', 'nights', 'quantity_of_rooms', 'rate_id',
        'status', 'occupants', 'kids', 'guest_id', 'createdBy', 'extras', 'source', 'agent_id', 'modifiedBy'
    ]; 

    public function reservationPayments()
    {
        return $this->hasMany(ReservationPayment::class, 'reference', 'reference');
    }

    public function reservationSources()
    {
        return $this->hasMany(ReservationSource::class, 'id', 'source');
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function guestBill()
    {
        return $this->hasMany(Inhouse::class);
    }

    public function guestPayment()
    {
        return $this->hasMany(GuestPayment::class);
    }

    public function apartments()
    {
        return $this->belongsTo(Apartments::class);
    }

    public function rate()
    {
        return $this->belongsTo(Rate::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'createdBy');
    }
}
