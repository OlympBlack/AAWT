<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class SchoolYear extends Model
{
    use HasFactory; 

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'wording',
        'is_current'
    ];

    /**
     * Les attributs qui doivent être convertis en types natifs.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_current' => 'boolean',
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

    public static function current()
    {
        return self::where('is_current', true)->first();
    }

    public static function toggleCurrent($id)
    {
        DB::transaction(function () use ($id) {
            self::where('is_current', true)->update(['is_current' => false]);
            self::findOrFail($id)->update(['is_current' => true]);
        });
    }

    // Ajoutez cette méthode si elle n'existe pas déjà
    public function schoolYearSemesters(): HasMany
    {
        return $this->hasMany(SchoolYearSemester::class);
    }
}
