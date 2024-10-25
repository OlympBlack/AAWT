<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'content',
        'receiver_id',
        'sender_id',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function markAsRead(): void
    {
        $this->is_read = true;
        $this->save();
    }

    public function markAsUnread(): void
    {
        $this->is_read = false;
        $this->save();
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }
}
