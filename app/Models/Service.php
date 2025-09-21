<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Service extends Model
{
    use HasFactory;

    /**
     * Die massenzuweisbaren Attribute.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'appointment_id',
        'description',
        'price',
        'payment_status',
        'invoiced_at',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Eine Dienstleistung gehört zu vielen Rechnungen (via Pivot-Tabelle).
     */
    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class, 'invoice_service');
    }
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'float',
        'invoiced_at' => 'datetime',
    ];
}
