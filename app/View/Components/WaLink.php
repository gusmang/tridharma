<?php

namespace App\View\Components;

use Illuminate\View\Component;

class WaLink extends Component
{

    public $telepon;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($telepon)
    {
        $this->telepon = $telepon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $telepon = $this->telepon;
        return view('components.wa-link', compact('telepon'));
    }
}
