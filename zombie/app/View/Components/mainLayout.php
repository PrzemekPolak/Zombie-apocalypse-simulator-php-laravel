<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class mainLayout extends Component
{
    public $title;
    public bool $showSettingsButton;

    public function __construct($title, $showSettingsButton = false)
    {
        $this->title = $title;
        $this->showSettingsButton = $showSettingsButton;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.main-layout');
    }
}
