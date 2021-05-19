<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vendors';

    protected $fillable = ['name', 'phone', 'email', 'address', 'business_name', 'type'];

    public function maintenance()
    {
        return $this->belongsToMany(Maintenance::class);
    }

    public function payment()
    {
        return $this->hasMany(VendorPayment::class);
    }

    public function credit()
    {
        return $this->hasMany(Credit::class);
    }
}
