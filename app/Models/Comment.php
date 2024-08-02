<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = ['spr_id', 'user_id', 'cm_ucode', 'cm_title', 'cm_description'];

    public function spr(): BelongsTo
    {
        return $this->belongsTo(SPR::class, 'spr_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
