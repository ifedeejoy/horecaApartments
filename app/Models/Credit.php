<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'service', 'initial_amount', 'amount', 'status', 'due_date', 'created_by', 'updated_by', 'reference'];

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }
}
