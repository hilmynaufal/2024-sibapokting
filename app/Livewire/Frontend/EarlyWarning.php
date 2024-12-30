<?php

namespace App\Livewire\Frontend;

use App\Models\Referensi\RefKomoditas;
use Livewire\Attributes\Layout;
use Livewire\Component;

class EarlyWarning extends Component
{
    public $search='';
    public $date;
    public $date_before;
    #[Layout('components.layouts.keenthemes.frontend.dash')]

    public function mount(){
        $dt = new \Carbon\Carbon(now());
        $this->date = $dt->startOfWeek()->format('Y-m-d');
        // $this->date_before = $dt->subMonth()->startOfWeek()->format('Y-m-d');
        $this->date_before = $dt->subWeek()->startOfWeek()->format('Y-m-d');
        // dd($this->date.'-'.$this->date_before);
    }
    public function render()
    {
        $query = RefKomoditas::where('prioritas',1)->get();
        return view('livewire.frontend.early-warning', [
            'model'=> $query
        ]);
    }
}
