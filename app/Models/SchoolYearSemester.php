<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class SchoolYearSemester extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_year_id',
        'semester_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public static function setActive($schoolYearId, $semesterId)
    {
        DB::transaction(function () use ($schoolYearId, $semesterId) {
            self::where('school_year_id', $schoolYearId)->update(['is_active' => false]);
            self::where('school_year_id', $schoolYearId)
                ->where('semester_id', $semesterId)
                ->update(['is_active' => true]);
        });
    }
}
