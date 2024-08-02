<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SPR extends Model
{
    protected $fillable = ['pr_id', 'sender_id', 'spr_ucode', 'spr_title', 'spr_description', 'images'];

    public function problem(): BelongsTo
    {
        return $this->belongsTo(Problem::class, 'pr_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function statuses(): HasMany
    {
        return $this->hasMany(Status::class, 'spr_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'spr_id');
    }
}
