<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = ['dp_code', 'dp_name', 'dp_group', 'dp_spr'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'dp_id');
    }
}
