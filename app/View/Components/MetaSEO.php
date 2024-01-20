<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MetaSEO extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $metas;
    public function __construct($metas)
    {
        $this->metas = $metas;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.meta-s-e-o');
    }
}
