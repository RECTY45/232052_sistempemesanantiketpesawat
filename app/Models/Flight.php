<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_number',
        'airline_id',
        'aircraft_id',
        'departure_airport_id',
        'arrival_airport_id',
        'departure_time',
        'arrival_time',
        'duration_minutes',
        'economy_price',
        'business_price',
        'first_class_price',
        'available_economy_seats',
        'available_business_seats',
        'available_first_class_seats',
        'status',
        'gate',
        'is_active'
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
        'economy_price' => 'decimal:2',
        'business_price' => 'decimal:2',
        'first_class_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class);
    }

    public function departureAirport()
    {
        return $this->belongsTo(Airport::class, 'departure_airport_id');
    }

    public function arrivalAirport()
    {
        return $this->belongsTo(Airport::class, 'arrival_airport_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('departure_time', today());
    }

    // Accessors
    public function getRouteAttribute()
    {
        return $this->departureAirport->code . ' → ' . $this->arrivalAirport->code;
    }

    public function getDurationFormatAttribute()
    {
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        return sprintf('%dh %dm', $hours, $minutes);
    }

    // Methods
    public function getPriceByClass($class)
    {
        switch ($class) {
            case 'business':
                return $this->business_price;
            case 'first_class':
                return $this->first_class_price;
            default:
                return $this->economy_price;
        }
    }

    public function getAvailableSeatsByClass($class)
    {
        switch ($class) {
            case 'business':
                return $this->available_business_seats;
            case 'first_class':
                return $this->available_first_class_seats;
            default:
                return $this->available_economy_seats;
        }
    }
}
