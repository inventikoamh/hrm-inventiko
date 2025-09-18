<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'estimated_start_date',
        'estimated_days',
        'project_lead_id',
        'client_id',
        'team_members',
        'project_budget',
        'currency',
        'priority',
        'status',
    ];

    protected $casts = [
        'estimated_start_date' => 'date',
        'team_members' => 'array',
        'project_budget' => 'decimal:2',
    ];

    // Relationships
    public function projectLead(): BelongsTo
    {
        return $this->belongsTo(User::class, 'project_lead_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function teamMembers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_team_members', 'project_id', 'user_id');
    }

    // Accessors
    public function getEstimatedEndDateAttribute()
    {
        return $this->estimated_start_date->addDays($this->estimated_days);
    }

    public function getFormattedBudgetAttribute()
    {
        if (!$this->project_budget) {
            return 'Not specified';
        }

        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'INR' => '₹',
            'JPY' => '¥',
        ];

        $symbol = $symbols[$this->currency] ?? $this->currency;
        return $symbol . number_format($this->project_budget, 2);
    }

    public function getPriorityBadgeAttribute()
    {
        $badges = [
            'low' => 'bg-gray-100 text-gray-800',
            'medium' => 'bg-blue-100 text-blue-800',
            'high' => 'bg-orange-100 text-orange-800',
            'urgent' => 'bg-red-100 text-red-800',
        ];

        return $badges[$this->priority] ?? 'bg-gray-100 text-gray-800';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'planned' => 'bg-gray-100 text-gray-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'on_hold' => 'bg-yellow-100 text-yellow-800',
            'completed' => 'bg-green-100 text-green-800',
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getPriorityNameAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->priority));
    }

    public function getStatusNameAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->status === 'completed') {
            return 100;
        }

        if ($this->status === 'planned') {
            return 0;
        }

        // For in_progress and on_hold, calculate based on time elapsed
        $startDate = $this->estimated_start_date;
        $endDate = $this->estimated_end_date;
        $today = Carbon::today();

        if ($today->lt($startDate)) {
            return 0;
        }

        if ($today->gte($endDate)) {
            return 100;
        }

        $totalDays = $startDate->diffInDays($endDate);
        $elapsedDays = $startDate->diffInDays($today);

        return min(100, round(($elapsedDays / $totalDays) * 100));
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeByProjectLead($query, $userId)
    {
        return $query->where('project_lead_id', $userId);
    }

    public function scopeByTeamMember($query, $userId)
    {
        return $query->whereJsonContains('team_members', $userId);
    }

    // Helper methods
    public function isTeamMember($userId)
    {
        return in_array($userId, $this->team_members ?? []);
    }

    public function canUserAccess($userId)
    {
        return $this->project_lead_id === $userId || $this->isTeamMember($userId);
    }
}