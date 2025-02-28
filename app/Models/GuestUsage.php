<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestUsage extends Model
{
    protected $table = 'guest_usage';
    
    protected $fillable = [
        'ip_address',
        'session_id',
        'usage_count',
        'last_reset',
    ];
    
    protected $casts = [
        'last_reset' => 'datetime',
    ];

    public function incrementUsage()
    {
        $this->usage_count++;
        $this->save();
    }

    public function resetIfNeeded()
    {
        if ($this->shouldReset()) {
            $this->usage_count = 0;
            $this->last_reset = now();
            $this->save();
        }
    }

    public function shouldReset()
    {
        return $this->last_reset->startOfDay()->lt(now()->startOfDay());
    }

    public function hasReachedLimit()
    {
        return $this->usage_count >= 5;
    }
}
