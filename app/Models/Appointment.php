<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Appointment extends Model
{
    use HasFactory;

    /**
     * Die massenzuweisbaren Attribute.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'employee_id',
        'scheduled_at',
        'duration_minutes',
        'status',
        'notes',
    ];

    /**
     * Ein Termin gehört zu einem Kunden.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Ein Termin gehört zu einem Mitarbeiter.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Ein Termin hat viele Dienstleistungen.
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'scheduled_at' => 'datetime',
    ];
}
