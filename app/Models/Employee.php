<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Employee extends Model
{
    use HasFactory;

    /**
     * Die massenzuweisbaren Attribute.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'job_title',
    ];

    /**
     * Ein Mitarbeiter kann viele Termine haben.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Ein Mitarbeiter kann viele Rechnungen ausstellen.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
