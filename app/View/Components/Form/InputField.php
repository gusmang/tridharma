<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class InputField extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $value;
    public $type;
    public $name;
    public $errors;
    public $label;
    public $filename;
    public $placeholder;
    public $required;

    public function __construct($value,$name,$errors,$filename,$type, $label=null,$placeholder=null,$required=null)
    {
        $this->value = $value;
        $this->type = $type;
        $this->name = $name;
        $this->errors = $errors;
        $this->label = $label;
        $this->filename = $filename;
        $this->placeholder = $placeholder;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.input-field');
    }
}
