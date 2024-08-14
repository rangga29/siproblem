<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Status extends Model
{
    protected $fillable = ['spr_id', 'user_id', 'st_ucode', 'st_description', 'st_images', 'st_name', 'st_status'];

    protected $casts = [
        'st_images' => 'array',
    ];

    public function spr(): BelongsTo
    {
        return $this->belongsTo(Spr::class, 'spr_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
