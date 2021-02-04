<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postmaster extends Model
{
    use HasFactory;

    protected $fillable = ['guest_id', 'balance', 'user_id'];

    public function guests()
    {
        return $this->belongsTo(Guest::class);
    }
}
