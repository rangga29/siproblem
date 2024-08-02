<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Problem extends Model
{
    protected $fillable = ['dp_id', 'pr_ucode', 'pr_name'];

    public function sprs(): HasMany
    {
        return $this->hasMany(SPR::class, 'pr_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'dp_id');
    }
}
