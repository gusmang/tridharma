<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class ErrorNotif extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $datas;
    public $filename;

    public function __construct($datas,$filename)
    {
        $this -> datas = $datas;
        $this -> filename = $filename;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.error-notif');
    }
}
