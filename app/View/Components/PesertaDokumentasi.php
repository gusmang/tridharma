<?php

namespace App\View\Components;

use App\Models\Peserta;
use Illuminate\View\Component;

class PesertaDokumentasi extends Component
{

    public $peserta;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Peserta $peserta)
    {
        $this->peserta = $peserta;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.peserta-dokumentasi');
    }
}
