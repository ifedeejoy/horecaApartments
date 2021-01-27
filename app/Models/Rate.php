<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'amount'
    ];

    public function apartments()
    {
        return $this->belongsTo(Apartments::class);
    }

    public function reservation()
    {
        return $this->hasOne(Rate::class);
    }
}
