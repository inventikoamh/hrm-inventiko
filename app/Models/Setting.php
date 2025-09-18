<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'options',
        'is_public',
    ];

    protected $casts = [
        'options' => 'array',
        'is_public' => 'boolean',
    ];

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        return Cache::remember("setting.{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }

            return static::castValue($setting->value, $setting->type);
        });
    }

    /**
     * Set a setting value by key
     */
    public static function set($key, $value, $type = 'string', $group = 'general', $label = null, $description = null, $options = null, $isPublic = false)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $type === 'json' ? json_encode($value) : $value,
                'type' => $type,
                'group' => $group,
                'label' => $label ?? ucfirst(str_replace('_', ' ', $key)),
                'description' => $description,
                'options' => $options,
                'is_public' => $isPublic,
            ]
        );

        Cache::forget("setting.{$key}");
        Cache::forget("settings.public");
        Cache::forget("settings.group.{$group}");
        
        return $setting;
    }

    /**
     * Get all settings by group
     */
    public static function getByGroup($group)
    {
        return Cache::remember("settings.group.{$group}", 3600, function () use ($group) {
            return static::where('group', $group)->get()->mapWithKeys(function ($setting) {
                return [$setting->key => static::castValue($setting->value, $setting->type)];
            });
        });
    }

    /**
     * Get all public settings
     */
    public static function getPublic()
    {
        return Cache::remember('settings.public', 3600, function () {
            return static::where('is_public', true)->get()->mapWithKeys(function ($setting) {
                return [$setting->key => static::castValue($setting->value, $setting->type)];
            });
        });
    }

    /**
     * Cast value based on type
     */
    protected static function castValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return (int) $value;
            case 'json':
                return json_decode($value, true);
            case 'file':
                return $value; // File paths as strings
            default:
                return $value;
        }
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        Cache::forget('settings.public');
        Cache::flush();
    }

    /**
     * Get app display name
     */
    public static function getAppName()
    {
        return static::get('app_name', 'ProjectFlow');
    }

    /**
     * Get logo path
     */
    public static function getLogo()
    {
        return static::get('logo', null);
    }

    /**
     * Get favicon path
     */
    public static function getFavicon()
    {
        return static::get('favicon', null);
    }

    /**
     * Get login background path
     */
    public static function getLoginBackground()
    {
        return static::get('login_background', null);
    }

    /**
     * Get theme color
     */
    public static function getThemeColor()
    {
        return static::get('theme_color', '#3B82F6');
    }

    /**
     * Get late clock in threshold (minutes)
     */
    public static function getLateClockInThreshold()
    {
        return static::get('late_clock_in_threshold', 15);
    }

    /**
     * Get auto clock out threshold (hours)
     */
    public static function getAutoClockOutThreshold()
    {
        return static::get('auto_clock_out_threshold', 12);
    }

    /**
     * Get late clock in time
     */
    public static function getLateClockInTime()
    {
        return static::get('late_clock_in_time', '11:30');
    }

    /**
     * Get auto clock out time
     */
    public static function getAutoClockOutTime()
    {
        return static::get('auto_clock_out_time', '23:59');
    }

    /**
     * Get enum values for a specific enum type
     */
    public static function getEnumValues($enumType)
    {
        return static::get("enum_{$enumType}", []);
    }

    /**
     * Set enum values for a specific enum type
     */
    public static function setEnumValues($enumType, $values)
    {
        return static::set("enum_{$enumType}", $values, 'json', 'enums', "{$enumType} Options", "Available options for {$enumType}");
    }

    /**
     * Get enum colors for a specific enum type
     */
    public static function getEnumColors($enumType)
    {
        return static::get("{$enumType}_colors", []);
    }

    /**
     * Get color for a specific enum value
     */
    public static function getEnumColor($enumType, $value, $default = '#6B7280')
    {
        $colors = static::getEnumColors($enumType);
        return $colors[$value] ?? $default;
    }

    /**
     * Set enum colors for a specific enum type
     */
    public static function setEnumColors($enumType, $colors)
    {
        return static::set("{$enumType}_colors", $colors, 'json', 'theme', "{$enumType} Colors", "Color mapping for {$enumType} labels");
    }
}