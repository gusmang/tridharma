<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class EditButton extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $url;
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $url = $this->url;
        return view('components.form.edit-button', compact('url'));
    }
}
