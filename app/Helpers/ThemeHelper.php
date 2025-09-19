<?php

namespace App\Helpers;

use App\Models\User;

class ThemeHelper
{
    /**
     * Get the effective theme mode for the current user
     * Returns 'light' or 'dark' based on user preference
     */
    public static function getEffectiveThemeMode()
    {
        if (!auth()->check()) {
            return 'light'; // Default for guests
        }

        $user = auth()->user();
        $preference = $user->getThemePreference();

        // Ensure we only return 'light' or 'dark'
        return in_array($preference, ['light', 'dark']) ? $preference : 'light';
    }

    /**
     * Check if the current theme is dark
     */
    public static function isDarkMode()
    {
        return self::getEffectiveThemeMode() === 'dark';
    }

    /**
     * Get theme classes for conditional styling
     */
    public static function getThemeClasses($lightClass, $darkClass)
    {
        $isDark = self::isDarkMode();
        return $isDark ? $darkClass : $lightClass;
    }

    /**
     * Get theme classes with transition
     */
    public static function getThemeClassesWithTransition($lightClass, $darkClass)
    {
        $isDark = self::isDarkMode();
        return 'transition-colors duration-200 ' . ($isDark ? $darkClass : $lightClass);
    }
}
