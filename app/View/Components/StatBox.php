<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatBox extends Component
{
    public $title, $value, $bg;
    /**
     * Create a new component instance.
     */
    public function __construct($title, $value, $bg = 'primary')
    {
        $this->title = $title;
        $this->value = $value;
        $this->bg = $bg;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.stat-box');
    }
}
