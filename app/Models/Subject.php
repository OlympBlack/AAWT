<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    protected $fillable = [
        'wording',
        'coefficient',
        'classroom_id',
    ];

    /**
     * Obtenir la classe associée à ce sujet.
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
