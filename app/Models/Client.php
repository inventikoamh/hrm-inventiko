<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'company_name',
        'description',
        'email',
        'mobile',
    ];

    // Relationships
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    // Accessors
    public function getDisplayNameAttribute()
    {
        return $this->client_name . ' (' . $this->company_name . ')';
    }

    public function getFormattedMobileAttribute()
    {
        // Format mobile number for display
        $mobile = preg_replace('/[^0-9]/', '', $this->mobile);
        if (strlen($mobile) === 10) {
            return substr($mobile, 0, 5) . ' ' . substr($mobile, 5);
        }
        return $this->mobile;
    }

    // Scopes
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('client_name', 'like', '%' . $search . '%')
              ->orWhere('company_name', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%')
              ->orWhere('mobile', 'like', '%' . $search . '%');
        });
    }

    // Helper methods
    public function getProjectCount()
    {
        return $this->projects()->count();
    }

    public function getActiveProjectCount()
    {
        return $this->projects()->whereIn('status', ['planned', 'in_progress'])->count();
    }
}