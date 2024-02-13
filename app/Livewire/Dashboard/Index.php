<?php

namespace App\Livewire\Dashboard;
use Livewire\Attributes\Layout;

use Livewire\Component;

class Index extends Component
{
    #[Layout('components.layouts.keenthemes.app')] 
    public function render()
    {
        return view('livewire.dashboard.index');
    }
}
