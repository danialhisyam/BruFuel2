<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_code',
        'name',
        'email',
        'phone',
        'license_type',
        'license_expiry',
        'status',
    ];

    // Auto-generate DRV-001, DRV-002... if not provided
    protected static function booted(): void
    {
        static::creating(function (Driver $driver) {
            if (! $driver->driver_code) {
                $max = DB::table('drivers')
                    ->selectRaw("COALESCE(MAX(CAST(SUBSTRING(driver_code, 5) AS UNSIGNED)), 0) as m")
                    ->value('m');

                $driver->driver_code = 'DRV-' . str_pad(((int)$max + 1), 3, '0', STR_PAD_LEFT);
            }
        });
    }

    // Optional helper for initials in your UI
    public function getInitialsAttribute(): string
    {
        return collect(explode(' ', (string) $this->name))
            ->filter()
            ->map(fn ($n) => mb_substr($n, 0, 1))
            ->take(2)
            ->implode('');
    }
}