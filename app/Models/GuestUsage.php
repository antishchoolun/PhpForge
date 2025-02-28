<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestUsage extends Model
{
    protected $table = 'guest_usage';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'ip_address',
        'session_id',
        'usage_count',
        'last_reset',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_reset' => 'datetime',
        'usage_count' => 'integer',
    ];

    /**
     * Increment the usage count.
     *
     * @return void
     */
    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }

    /**
     * Reset usage if needed based on last reset date.
     *
     * @return void
     */
    public function resetIfNeeded(): void
    {
        if ($this->shouldReset()) {
            $this->update([
                'usage_count' => 0,
                'last_reset' => now(),
            ]);
        }
    }

    /**
     * Check if usage should be reset.
     *
     * @return bool
     */
    public function shouldReset(): bool
    {
        return $this->last_reset->startOfDay()->lt(now()->startOfDay());
    }

    /**
     * Check if usage limit has been reached.
     *
     * @return bool
     */
    public function hasReachedLimit(): bool
    {
        return $this->usage_count >= 5;
    }

    /**
     * Scope a query to find by session.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $ip
     * @param string $sessionId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBySession($query, string $ip, string $sessionId)
    {
        return $query->where('ip_address', $ip)
                    ->where('session_id', $sessionId);
    }
}
