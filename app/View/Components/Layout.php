<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Route;

class Layout extends Component
{
    /**
     * Create a new component instance.
     */

    public bool $showHero;

    public function __construct(bool $showHero = false)
    {
        $this->showHero = $showHero || Route::is('home');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout');
    }
}
