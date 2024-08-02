<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Status extends Model
{
    protected $fillable = ['spr_id', 'receiver_id', 'st_ucode', 'st_name'];

    public function spr(): BelongsTo
    {
        return $this->belongsTo(SPR::class, 'spr_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
