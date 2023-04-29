<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AmountController extends Component
{

    public $text= '';

    public function render()
    {
        return view('livewire.amount');
    }
}
