<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class infoPanelElement extends Component
{
    public string $label;
    public $value;
    public $icon;

    public function __construct($label, $value, $icon)
    {
        $this->label = $label;
        $this->value = $value;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.info-panel-element');
    }
}
