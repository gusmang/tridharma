<?php

namespace App\View\Components;

use App\Models\Acara;
use Illuminate\View\Component;

class AcaraThumbnail extends Component
{

    public $acara;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Acara $acara)
    {
        $this->acara = $acara;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.acara-thumbnail');
    }
}
