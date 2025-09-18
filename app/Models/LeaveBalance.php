<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Setting;

class LeaveBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'leave_type',
        'total_allowed',
        'used',
        'remaining',
    ];

    protected $casts = [
        'total_allowed' => 'integer',
        'used' => 'integer',
        'remaining' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTypeNameAttribute(): string
    {
        return match($this->leave_type) {
            'sick' => 'Sick Leave',
            'casual' => 'Casual Leave',
            'festival' => 'Festival Leave',
            'privilege' => 'Privilege Leave',
            'emergency' => 'Emergency Leave',
            default => ucfirst($this->leave_type)
        };
    }

    public function getUsagePercentageAttribute(): float
    {
        if ($this->total_allowed == 0) {
            return 0;
        }
        return round(($this->used / $this->total_allowed) * 100, 1);
    }

    public function getStatusBadgeAttribute(): string
    {
        $percentage = $this->usage_percentage;
        
        if ($percentage >= 90) {
            return 'bg-red-100 text-red-800';
        } elseif ($percentage >= 75) {
            return 'bg-yellow-100 text-yellow-800';
        } else {
            return 'bg-green-100 text-green-800';
        }
    }

    /**
     * Update the remaining balance based on used leaves
     */
    public function updateRemaining(): void
    {
        $this->remaining = max(0, $this->total_allowed - $this->used);
        $this->save();
    }

    /**
     * Check if user has enough balance for the requested days
     */
    public function hasEnoughBalance(int $days): bool
    {
        return $this->remaining >= $days;
    }

    /**
     * Get or create leave balance for a user and leave type
     */
    public static function getOrCreate(int $userId, string $leaveType, int $defaultAllowed = 0): self
    {
        return static::firstOrCreate(
            ['user_id' => $userId, 'leave_type' => $leaveType],
            ['total_allowed' => $defaultAllowed, 'used' => 0, 'remaining' => $defaultAllowed]
        );
    }

    /**
     * Get all leave balances for a user
     */
    public static function getUserBalances(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        $leaveTypes = array_map('strtolower', array_map('str_replace', [' ', ' '], ['_', '_'], Setting::getEnumValues('leave_type')));
        
        // First, get existing balances
        $existingBalances = static::where('user_id', $userId)
            ->whereIn('leave_type', $leaveTypes)
            ->get()
            ->keyBy('leave_type');
        
        // Create missing balances and collect all
        $allBalances = new \Illuminate\Database\Eloquent\Collection();
        
        foreach ($leaveTypes as $type) {
            if ($existingBalances->has($type)) {
                $allBalances->push($existingBalances->get($type));
            } else {
                $allBalances->push(static::getOrCreate($userId, $type));
            }
        }
        
        return $allBalances;
    }

    /**
     * Update used leaves for a user and leave type
     */
    public static function updateUsedLeaves(int $userId, string $leaveType, int $days, string $action = 'add'): void
    {
        $balance = static::getOrCreate($userId, $leaveType);
        
        if ($action === 'add') {
            $balance->used += $days;
        } elseif ($action === 'subtract') {
            $balance->used = max(0, $balance->used - $days);
        }
        
        $balance->updateRemaining();
    }

    /**
     * Get default leave allowances
     */
    public static function getDefaultAllowances(): array
    {
        $leaveTypes = array_map('strtolower', array_map('str_replace', [' ', ' '], ['_', '_'], Setting::getEnumValues('leave_type')));
        $defaults = [];
        
        // Set default allowances for each leave type
        foreach ($leaveTypes as $type) {
            $defaults[$type] = match($type) {
                'sick' => 20,
                'casual' => 10,
                'festival' => 15,
                'privilege' => 0,
                'emergency' => 12,
                default => 0,
            };
        }
        
        return $defaults;
    }
}