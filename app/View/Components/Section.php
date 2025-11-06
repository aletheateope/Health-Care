<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Section extends Component
{
    /**
     * Create a new component instance.
     */

    public $title;
    public $description;
    public $class;
    public function __construct($title = null, $description = null, $class = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.section');
    }
}
