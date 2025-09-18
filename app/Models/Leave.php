<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'start_date',
        'end_date',
        'total_days',
        'remark',
        'status',
        'approved_by',
        'approved_at',
        'source',
        'leave_request_id'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function leaveRequest()
    {
        return $this->belongsTo(LeaveRequest::class);
    }

    public function getTypeNameAttribute()
    {
        return match($this->type) {
            'sick' => 'Sick Leave',
            'casual' => 'Casual Leave',
            'festival' => 'Festival Leave',
            'privilege' => 'Privilege Leave',
            'emergency' => 'Emergency Leave',
            default => ucfirst($this->type)
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getSourceBadgeAttribute()
    {
        return match($this->source) {
            'marked' => 'bg-blue-100 text-blue-800',
            'requested' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getSourceNameAttribute()
    {
        return match($this->source) {
            'marked' => 'Marked by Admin',
            'requested' => 'Requested by Employee',
            default => ucfirst($this->source)
        };
    }

    public static function calculateDays($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        // Calculate working days (excluding only Sunday)
        $days = 0;
        while ($start->lte($end)) {
            if (!$start->isSunday()) {
                $days++;
            }
            $start->addDay();
        }
        
        return $days;
    }

    public static function isUserOnLeave($userId, $date = null)
    {
        $date = $date ? Carbon::parse($date) : Carbon::now();
        
        return static::where('user_id', $userId)
            ->where('status', 'approved')
            ->where('start_date', '<=', $date->format('Y-m-d'))
            ->where('end_date', '>=', $date->format('Y-m-d'))
            ->exists();
    }
}