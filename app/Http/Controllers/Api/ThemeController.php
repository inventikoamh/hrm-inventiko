<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ThemeController extends Controller
{
    /**
     * Toggle theme mode
     */
    public function toggle(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'mode' => 'required|in:light,dark'
            ]);

            Setting::setThemeMode($validated['mode']);
            Setting::clearCache();

            return response()->json([
                'success' => true,
                'message' => 'Theme updated successfully',
                'data' => [
                    'mode' => $validated['mode']
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update theme',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current theme mode
     */
    public function getMode(): JsonResponse
    {
        try {
            $mode = Setting::getThemeMode();

            return response()->json([
                'success' => true,
                'data' => [
                    'mode' => $mode
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get theme mode',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
