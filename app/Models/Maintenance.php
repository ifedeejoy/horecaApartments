<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maintenance extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['apartments_id', 'issue', 'images', 'status', 'vendor_id'];

    public function apartment()
    {
        return $this->belongsTo(Apartments::class, 'apartments_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function payment()  
    {
        return $this->hasMany(VendorPayment::class);
    }

    public function lastPayment()
    {
        return $this->hasMany(VendorPayment::class)->latest();
    }

    public static function reorderResults($result)
    {
        $reordered = $result->mapWithKeys(function ($item) {
            return [
                'id' => $item['id'],
                'apartment' => $item['apartment']['name'],
                'issue' => $item['issue'],
                'status' => $item['status'],
                'created_at' => $item['created_at'],
                'apartments_id' => $item['apartments_id']
            ];
        });
        return $reordered->all();
    }
}
