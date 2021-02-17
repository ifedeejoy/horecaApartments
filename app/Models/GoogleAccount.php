<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\SynchronizeGoogleCalendars;

class GoogleAccount extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();

        static::created(function ($googleAccount) {
            SynchronizeGoogleCalendars::dispatch($googleAccount);
        });
    }

    protected $fillable = ['id', 'google_id', 'email', 'token'];

    protected $casts = ['token' => 'json'];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
