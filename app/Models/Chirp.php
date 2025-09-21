<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Chirp extends Model
{
    /** @use HasFactory<\Database\Factories\ChirpFactory> */
    use HasFactory;
    /**
     * User who created this Chirp.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Chirps created by User.
     */
    public function chirps(): HasMany
    {
        return $this->hasMany(Chirp::class, 'creator_id');
    }
}
