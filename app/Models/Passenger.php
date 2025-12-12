<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'title',
        'first_name',
        'last_name',
        'phone',
        'email',
        'birth_date',
        'gender',
        'nationality',
        'id_number',
        'id_type',
        'seat_number',
        'is_checked_in',
        'checked_in_at'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_checked_in' => 'boolean',
        'checked_in_at' => 'datetime',
    ];

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Scopes
    public function scopeCheckedIn($query)
    {
        return $query->where('is_checked_in', true);
    }

    public function scopeNotCheckedIn($query)
    {
        return $query->where('is_checked_in', false);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->title . ' ' . $this->first_name . ' ' . $this->last_name;
    }

    public function getAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->birth_date)->diffInYears(now());
    }
}
