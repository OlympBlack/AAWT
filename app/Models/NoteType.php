<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NoteType extends Model
{
    protected $fillable = [
        'wording',
    ];

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
