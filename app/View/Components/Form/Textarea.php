<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Textarea extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $value;
    public $name;
    public $errors;
    public $label;
    public $filename;
    public $class;

    public function __construct($value,$name,$errors,$label,$filename,$class = null)
    {
        $this->value = $value;
        $this->name = $name;
        $this->errors = $errors;
        $this->label = $label;
        $this->filename = $filename;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.textarea');
    }
}
