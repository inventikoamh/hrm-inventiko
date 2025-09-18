<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'clock_in_at',
        'clock_out_at',
    ];

    protected $casts = [
        'clock_in_at' => 'datetime',
        'clock_out_at' => 'datetime',
    ];

    // Disable automatic timestamps since we're managing our own
    public $timestamps = false;


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(AttendanceLog::class);
    }

    public static function canClockIn($userId)
    {
        // Check if user is on leave
        if (Leave::isUserOnLeave($userId)) {
            return false;
        }

        // Check if user is already clocked in
        return !static::where('user_id', $userId)
            ->whereNull('clock_out_at')
            ->exists();
    }
}


