<?php

namespace App\Livewire\Components;

use App\Helpers\ThemeHelper;
use Livewire\Component;

class ThemeToggle extends Component
{
    public $currentTheme;

    public function mount()
    {
        $this->currentTheme = auth()->user()?->getThemePreference() ?? 'light';
    }

    public function setTheme($theme)
    {
        if (!auth()->check()) {
            return;
        }

        auth()->user()->setThemePreference($theme);
        $this->currentTheme = $theme;
        
        // Emit event to update the page
        $this->dispatch('theme-changed', $theme);
        
        // Auto-refresh the page to apply theme changes
        $this->dispatch('refresh-page');
    }

    public function render()
    {
        return view('livewire.components.theme-toggle');
    }
}
