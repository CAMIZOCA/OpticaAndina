<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'service_slug',
        'appointment_date',
        'appointment_time',
        'message',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
            'appointment_time' => 'string',
        ];
    }

    /**
     * Scope: Get pending appointments.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Get confirmed appointments.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope: Order by appointment_date.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('appointment_date', 'asc')->orderBy('appointment_time', 'asc');
    }
}
