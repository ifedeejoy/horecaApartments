<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $with = ['calendar'];
    protected $fillable = ['calendar_id', 'name', 'description', 'allday', 'started_at', 'ended_at', 'user_id', 'google_id'];
    protected $casts = [
        'started_at' => 'datetime:c',
        'ended_at' => 'datetime:c',
    ];

    public function googleAccount()
    {
        return $this->belongsTo(GoogleAccount::class);
    } 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calendar()
    {
        return $this->belongsTo(GoogleCalendar::class, 'calendar_id');
    }

    public function getDurationAttribute()
    {
        return $this->started_at->diffForHumans($this->ended_at, true);
    }
}
