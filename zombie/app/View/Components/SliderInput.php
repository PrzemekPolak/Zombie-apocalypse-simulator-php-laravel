<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SliderInput extends Component
{
    public string $name;
    public string $label;
    public int $initialValue;
    public int $maxValue;
    public int $minValue;

    public function __construct($name, $label, $initialValue, $maxValue = 100, $minValue = 0)
    {
        $this->name = $name;
        $this->label = $label;
        $this->initialValue = $initialValue;
        $this->maxValue = $maxValue;
        $this->minValue = $minValue;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.slider-input');
    }
}
