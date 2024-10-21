<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolYear extends Model
{
    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'wording',
    ];

    /**
     * Les attributs qui doivent être convertis en types natifs.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Les semestres associés à cette année scolaire.
     */
    public function semesters(): BelongsToMany
    {
        return $this->belongsToMany(Semester::class, 'school_year_semesters');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}
