<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class NoteType extends Model
{
    use HasFactory;
    protected $fillable = [
        'wording',
    ];

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
