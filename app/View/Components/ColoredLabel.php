<?php

namespace App\View\Components;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ColoredLabel extends Component
{
    public string $color;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $value,
        public string $enumType,
        public string $defaultColor = '#6B7280'
    ) {
        $this->color = Setting::getEnumColor($enumType, $value, $defaultColor);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.colored-label');
    }
}
