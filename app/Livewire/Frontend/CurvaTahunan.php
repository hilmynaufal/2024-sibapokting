<?php

namespace App\Livewire\Frontend;

use App\Models\Referensi\RefKomoditas;
use App\Models\Referensi\RefPasar;
use Livewire\Component;
use Livewire\Attributes\Layout;

class CurvaTahunan extends Component
{
    public $search = '';
    public $searchPasar = 8;
    public $searchKomoditas = 89;
    public $date;
    public $date_before;
    
    public $komoditas_id = 89;
    public $komoditas_sekarang;
    public $komoditas_kemarin;
    public $list_komoditas;
    public $list_komoditas_search;
    public $list_pasar;

    public $chart2023 = array();
    public $chart2024 = array();

    #[Layout('components.layouts.keenthemes.frontend.dash')]

    public function mount(){
        $this->list_pasar = RefPasar::get();
        $this->list_komoditas_search = RefKomoditas::get();
    }
    public function render()
    {
        return view('livewire.frontend.curva-tahunan');
    }

    public function setKomoditas($komoditasId){
        $this->komoditas_id = $komoditasId;
        $this->mount();
    }
}
