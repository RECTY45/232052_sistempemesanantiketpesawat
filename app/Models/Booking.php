<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'flight_id',
        'flight_class_id',
        'passengers_count',
        'total_price',
        'status',
        'booking_date',
        'payment_deadline',
        'notes',
        'contact_info'
    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'payment_deadline' => 'datetime',
        'total_price' => 'decimal:2',
        'contact_info' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function flightClass()
    {
        return $this->belongsTo(FlightClass::class);
    }

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latest();
    }

    // Scopes
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'confirmed' => 'info',
            'paid' => 'success',
            'cancelled' => 'danger',
            'completed' => 'primary'
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    // Static Methods
    public static function generateBookingCode()
    {
        do {
            $code = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6));
        } while (self::where('booking_code', $code)->exists());

        return $code;
    }
}
