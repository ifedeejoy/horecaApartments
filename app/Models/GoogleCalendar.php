<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleCalendar extends Model
{
    use HasFactory;

    protected $fillable = ['calendar_id', 'name', 'color', 'timezone', 'google_id', 'user_id'];

    public function googleAccount()
    {
        return $this->belongsTo(GoogleAccount::class);
    } 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->hasMany(Event::class, 'calendar_id');
    }
}
