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

    public function getFlightClassesAttribute()
    {
        $classes = [];
        
        // Economy Class
        if ($this->economy_price > 0 && $this->available_economy_seats > 0) {
            $classes[] = (object) [
                'id' => 1,
                'class_name' => 'Economy',
                'code' => 'ECO',
                'price' => $this->economy_price,
                'available_seats' => $this->available_economy_seats
            ];
        }
        
        // Business Class
        if ($this->business_price > 0 && $this->available_business_seats > 0) {
            $classes[] = (object) [
                'id' => 2,
                'class_name' => 'Business',
                'code' => 'BUS',
                'price' => $this->business_price,
                'available_seats' => $this->available_business_seats
            ];
        }
        
        // First Class
        if ($this->first_class_price > 0 && $this->available_first_class_seats > 0) {
            $classes[] = (object) [
                'id' => 3,
                'class_name' => 'First',
                'code' => 'FST',
                'price' => $this->first_class_price,
                'available_seats' => $this->available_first_class_seats
            ];
        }
        
        return collect($classes);
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
        switch (strtolower($class)) {
            case 'bus':
            case 'business':
                return $this->business_price;
            case 'fst':
            case 'first_class':
            case 'first':
                return $this->first_class_price;
            case 'eco':
            case 'economy':
            default:
                return $this->economy_price;
        }
    }

    public function getAvailableSeatsByClass($class)
    {
        switch (strtolower($class)) {
            case 'bus':
            case 'business':
                return $this->available_business_seats;
            case 'fst':
            case 'first_class':
            case 'first':
                return $this->available_first_class_seats;
            case 'eco':
            case 'economy':
            default:
                return $this->available_economy_seats;
        }
    }

    public function hasAvailableSeats($class, $count = 1)
    {
        return $this->getAvailableSeatsByClass($class) >= $count;
    }

    public function reserveSeats($class, $count)
    {
        if (!$this->hasAvailableSeats($class, $count)) {
            throw new \Exception('Not enough seats available');
        }

        switch (strtolower($class)) {
            case 'bus':
            case 'business':
                $this->available_business_seats -= $count;
                break;
            case 'fst':
            case 'first_class':
            case 'first':
                $this->available_first_class_seats -= $count;
                break;
            case 'eco':
            case 'economy':
            default:
                $this->available_economy_seats -= $count;
                break;
        }

        return $this->save();
    }

    public function releaseSeats($class, $count)
    {
        $aircraft = $this->aircraft;
        
        switch (strtolower($class)) {
            case 'bus':
            case 'business':
                $this->available_business_seats = min(
                    $this->available_business_seats + $count,
                    $aircraft->business_seats
                );
                break;
            case 'fst':
            case 'first_class':
            case 'first':
                $this->available_first_class_seats = min(
                    $this->available_first_class_seats + $count,
                    $aircraft->first_class_seats
                );
                break;
            case 'eco':
            case 'economy':
            default:
                $this->available_economy_seats = min(
                    $this->available_economy_seats + $count,
                    $aircraft->economy_seats
                );
                break;
        }

        return $this->save();
    }

    public function getTotalBookedSeatsAttribute()
    {
        return $this->bookings()->where('status', '!=', 'cancelled')->sum('passengers_count');
    }
}
