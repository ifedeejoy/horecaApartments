<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartments extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'description',
        'max_guests',
        'beds',
        'status',
        'maintenance_status',
        'address',
        'country'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
