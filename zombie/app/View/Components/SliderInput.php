<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SliderInput extends Component
{
    public $name;
    public $label;
    public $initialValue;

    public function __construct($name, $label, $initialValue)
    {
        $this->name = $name;
        $this->label = $label;
        $this->initialValue = $initialValue;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.slider-input');
    }
}