<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Checkbox extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $labels;
    public $mainLabel;
    public $name;
    public $values;
    public $checkeds;
    public $errors;
    public $filename;
    public function __construct($mainLabel,$labels,$name,$values,$checkeds,$errors,$filename)
    {
        $this->name = $name;
        $this->mainLabel = $mainLabel;
        $this->labels = $labels;
        $this->values = $values;
        $this->checkeds = $checkeds;
        $this->errors = $errors;
        $this->filename = $filename;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.checkbox');
    }
}
