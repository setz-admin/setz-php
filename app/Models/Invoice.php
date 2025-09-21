<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Invoice extends Model
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
        'invoice_number',
        'status',
        'total_amount',
        'issued_at',
        'paid_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    /**
     * Eine Rechnung gehört zu einem Kunden.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Eine Rechnung gehört zu einem Mitarbeiter.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Eine Rechnung hat viele Dienstleistungen (via Pivot-Tabelle).
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'invoice_service');
    }
}
