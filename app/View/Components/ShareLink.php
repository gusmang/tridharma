<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ShareLink extends Component
{

    public $url;
    /**
     * Create a new component instance.
     *
     * @return void
     */
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
        return view('components.share-link', compact('url'));
    }
}
