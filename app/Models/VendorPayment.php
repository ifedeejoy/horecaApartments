<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['apartments_id','maintenance_id','vendor_id','cost','cost_breakdown','paid', 'balance', 'payment_method'];

    public function vendor()
    {
        return $this->belongsToMany(Vendor::class);
    }

    public function maintenance()
    {
        return $this->belongsToMany(Maintenance::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchases::class);
    }
}
