<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'product_type',
        'budget',
        'start',
        'converted_to_client',
        'client_id',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'converted_to_client' => 'boolean',
    ];

    // Lead Status Constants
    const STATUS_NEW_LEAD = 'new_lead';
    const STATUS_INITIAL_CONTACT = 'initial_contact';
    const STATUS_QUALIFICATION_CALL = 'qualification_call';
    const STATUS_PROPOSAL_SENT = 'proposal_sent';
    const STATUS_CONVERTED = 'converted';
    const STATUS_DEAD = 'dead';
    const STATUS_ON_HOLD = 'on_hold';

    public static function getStatuses()
    {
        return [
            self::STATUS_NEW_LEAD => 'New Lead',
            self::STATUS_INITIAL_CONTACT => 'Initial Contact Made',
            self::STATUS_QUALIFICATION_CALL => 'Qualification Call Completed',
            self::STATUS_PROPOSAL_SENT => 'Proposal Sent',
            self::STATUS_CONVERTED => 'Converted to Client',
            self::STATUS_DEAD => 'Lead Lost',
            self::STATUS_ON_HOLD => 'On Hold',
        ];
    }

    public static function getProgressiveStatuses()
    {
        return [
            self::STATUS_NEW_LEAD,
            self::STATUS_INITIAL_CONTACT,
            self::STATUS_QUALIFICATION_CALL,
            self::STATUS_PROPOSAL_SENT,
            self::STATUS_CONVERTED,
        ];
    }

    public function getNextStatus()
    {
        $progressiveStatuses = self::getProgressiveStatuses();
        $currentIndex = array_search($this->status, $progressiveStatuses);
        
        if ($currentIndex !== false && $currentIndex < count($progressiveStatuses) - 1) {
            return $progressiveStatuses[$currentIndex + 1];
        }
        
        return null;
    }

    public function canBePromoted()
    {
        return $this->getNextStatus() !== null && 
               !in_array($this->status, [self::STATUS_DEAD, self::STATUS_ON_HOLD, self::STATUS_CONVERTED]);
    }

    public function canBeUnheld()
    {
        return $this->status === self::STATUS_ON_HOLD;
    }

    public function canBeUndead()
    {
        return $this->status === self::STATUS_DEAD;
    }

    public function getPreviousStatus()
    {
        // For unhold/undead, we'll default to new_lead status
        // In a more complex system, you might want to store the previous status
        return self::STATUS_NEW_LEAD;
    }

    public function getStatusColor()
    {
        return match($this->status) {
            self::STATUS_NEW_LEAD => \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-100 text-blue-800', 'bg-blue-900/30 text-blue-300'),
            self::STATUS_INITIAL_CONTACT => \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-yellow-100 text-yellow-800', 'bg-yellow-900/30 text-yellow-300'),
            self::STATUS_QUALIFICATION_CALL => \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-orange-100 text-orange-800', 'bg-orange-900/30 text-orange-300'),
            self::STATUS_PROPOSAL_SENT => \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-purple-100 text-purple-800', 'bg-purple-900/30 text-purple-300'),
            self::STATUS_CONVERTED => \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-green-100 text-green-800', 'bg-green-900/30 text-green-300'),
            self::STATUS_DEAD => \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-red-100 text-red-800', 'bg-red-900/30 text-red-300'),
            self::STATUS_ON_HOLD => \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100 text-gray-800', 'bg-slate-700 text-slate-300'),
            default => \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100 text-gray-800', 'bg-slate-700 text-slate-300'),
        };
    }

    public function remarks()
    {
        return $this->hasMany(LeadRemark::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}