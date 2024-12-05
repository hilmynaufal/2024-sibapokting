<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Livewire\Attributes\Layout;


class CurvaTahunan extends Component
{
    #[Layout('components.layouts.keenthemes.frontend.dash')]
    public function mount(){
        
    }
    public function render()
    {
        return view('livewire.frontend.curva-tahunan');
    }
}
