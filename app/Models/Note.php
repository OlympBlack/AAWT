<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    protected $fillable = [
        'value',
        'student_id',
        'note_type_id',
        'subject_id',
        'school_year_semester_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function noteType(): BelongsTo
    {
        return $this->belongsTo(NoteType::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function schoolYearSemester(): BelongsTo
    {
        return $this->belongsTo(SchoolYearSemester::class);
    }
}
