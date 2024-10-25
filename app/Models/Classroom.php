<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Classroom extends Model
{
    use HasFactory;
    protected $fillable = [
        'wording',
        'costs',
        'serie_id',
    ];

    /**
     * Obtenir la série associée à cette classe.
     */
    public function serie(): BelongsTo
    {
        return $this->belongsTo(Serie::class);
    }

    /**
     * Obtenir les sujets associés à cette classe.
     */
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
