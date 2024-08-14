<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function now;
use function sprintf;
use function today;

class Spr extends Model
{
    protected $fillable = ['dp_id', 'pr_id', 'sender_id', 'spr_code', 'spr_ucode', 'spr_title', 'spr_description', 'spr_images'];

    protected $casts = [
        'spr_images' => 'array',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'dp_id');
    }

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

    protected static function booted(): void
    {
        static::creating(function ($spr) {
            $today = now()->format('Ymd');
            $count = DB::table('sprs')
                    ->whereDate('created_at', today())
                    ->count() + 1;
            $spr->spr_code = sprintf('SPR/%s/%04d', $today, $count);
        });

        static::created(function ($spr) {
            $spr->statuses()->create([
                'spr_id' => $spr->id,
                'user_id' => $spr->sender_id,
                'st_ucode' => Str::random(20),
                'st_name' => 'Terkirim',
                'st_description' => 'SPR Terkirim',
                'st_status' => true
            ]);
        });
    }
}
