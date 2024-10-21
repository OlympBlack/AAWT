<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Serie extends Model
{
    protected $fillable = [
        'wording',
    ];

    /**
     * Obtenir les classes associées à cette série.
     */
    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class);
    }
}
