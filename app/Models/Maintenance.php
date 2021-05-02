<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maintenance extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['apartments_id', 'issue', 'images', 'status', 'vendors_id'];

    public function apartment()
    {
        return $this->belongsToMany(Apartments::class);
    }

    public function vendor()
    {
        return $this->belongsToMany(Vendor::class);
    }
}
