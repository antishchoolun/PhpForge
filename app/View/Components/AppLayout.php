<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public $slot;
    public $header;

    /**
     * Create a new component instance.
     */
    public function __construct($slot = '', $header = '')
    {
        $this->slot = $slot;
        $this->header = $header;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
