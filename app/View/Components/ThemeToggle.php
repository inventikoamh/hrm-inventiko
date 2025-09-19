<?php

namespace App\View\Components;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ThemeToggle extends Component
{
    public string $currentMode;
    public string $oppositeMode;
    public string $oppositeLabel;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->currentMode = Setting::getThemeMode();
        $this->oppositeMode = $this->currentMode === 'light' ? 'dark' : 'light';
        $this->oppositeLabel = $this->currentMode === 'light' ? 'Dark' : 'Light';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.theme-toggle');
    }
}
