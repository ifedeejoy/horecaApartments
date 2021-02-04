<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = ['guest_id', 'reference', 'amount', 'balance', 'status', 'due_date', 'created_by', 'updated_by'];

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }
}
