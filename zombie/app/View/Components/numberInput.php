<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class numberInput extends Component
{
    public string $name;
    public string $label;
    public int $initialValue;
    public int $maxValue;

    public function __construct($name, $label, $initialValue, $maxValue)
    {
        $this->name = $name;
        $this->label = $label;
        $this->initialValue = $initialValue;
        $this->maxValue = $maxValue;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.number-input');
    }
}
