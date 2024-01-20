<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class DeleteButton extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $url;
    public $id;

    public function __construct($url,$id)
    {
        $this->url = $url;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $url = $this->url;
        $id = $this->id;
        return view('components.form.delete-button', compact('url', 'id'));
    }
}
