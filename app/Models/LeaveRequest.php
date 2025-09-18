<?php

namespace App\Models;

use App\Models\LeaveBalance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'status',
        'reviewed_by',
        'reviewed_at',
        'admin_remark'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function leave()
    {
        return $this->hasOne(Leave::class);
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

    public function approve($adminId, $adminRemark = null)
    {
        $this->update([
            'status' => 'approved',
            'reviewed_by' => $adminId,
            'reviewed_at' => now(),
            'admin_remark' => $adminRemark
        ]);

        // Create actual leave record
        Leave::create([
            'user_id' => $this->user_id,
            'type' => $this->type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'total_days' => $this->total_days,
            'remark' => $this->reason,
            'status' => 'approved',
            'approved_by' => $adminId,
            'approved_at' => now(),
            'source' => 'requested',
            'leave_request_id' => $this->id,
        ]);

        // Update leave balance
        LeaveBalance::updateUsedLeaves($this->user_id, $this->type, $this->total_days, 'add');
    }

    public function reject($adminId, $adminRemark = null)
    {
        $this->update([
            'status' => 'rejected',
            'reviewed_by' => $adminId,
            'reviewed_at' => now(),
            'admin_remark' => $adminRemark
        ]);
        
        // No balance update needed for rejected requests
    }
}