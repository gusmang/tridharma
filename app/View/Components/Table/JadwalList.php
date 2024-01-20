<?php

namespace App\View\Components\Table;

use Illuminate\View\Component;

class JadwalList extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $acara;
    public $max;
    public function __construct($acara,$max=null)
    {
        $this->acara = $acara;
        $this->max = $max;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table.jadwal-list');
    }
}
