<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Subject extends Model
{
    use HasFactory;
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

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subject_teacher')
                    ->withPivot('classroom_id')
                    ->withTimestamps();
    }
}
