<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use function asset;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['dp_id', 'nik', 'name', 'password', 'role', 'remember_token'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function getAvatarUrlAttribute(): string
    {
        return asset('images/spurl.png');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'dp_id');
    }

    public function sprs(): HasMany
    {
        return $this->hasMany(SPR::class, 'sender_id');
    }

    public function statuses(): HasMany
    {
        return $this->hasMany(Status::class, 'user_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(Log::class, 'user_id');
    }
}
