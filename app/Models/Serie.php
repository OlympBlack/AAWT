<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Serie extends Model
{
    use HasFactory;
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
