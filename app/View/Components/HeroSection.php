<?php

namespace App\View\Components;

use Illuminate\View\Component;

class HeroSection extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

     public $pengaturan;

    public function __construct($pengaturan)
    {
        $this->pengaturan = $pengaturan;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.hero-section');
    }
}
