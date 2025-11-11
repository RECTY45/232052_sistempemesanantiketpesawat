<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'payment_code',
        'amount',
        'method',
        'status',
        'bank_name',
        'account_number',
        'reference_number',
        'payment_date',
        'expires_at',
        'payment_details',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime',
        'expires_at' => 'datetime',
        'payment_details' => 'array',
    ];

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Scopes
    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'success' => 'success',
            'failed' => 'danger',
            'expired' => 'secondary',
            'cancelled' => 'dark'
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function getIsExpiredAttribute()
    {
        return $this->expires_at < now() && $this->status === 'pending';
    }

    // Static Methods
    public static function generatePaymentCode()
    {
        do {
            $code = 'PAY' . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8));
        } while (self::where('payment_code', $code)->exists());

        return $code;
    }
}
