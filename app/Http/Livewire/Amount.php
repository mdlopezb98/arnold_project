<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Amount extends Component
{

    public $text= '';

    public function render()
    {
        return view('livewire.amount');
    }
}
