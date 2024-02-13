<?php

namespace App\Livewire\Main\Layanan\Bphtb\Detail;
use App\Models\Bphtb\PenerimaHak as Model;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class PenerimaHak extends Component
{
    public $penerima_hak;
    public $id_bphtb;
    
    public function render()
    {
        return view('livewire.main.layanan.bphtb.detail.penerima-hak');
    }
    
    public function mount($id)
    {
        $bphtb = Crypt::decrypt($id);
        $this->penerima_hak = Model::where('id_bphtb',$bphtb)->first();
        $this->id_bphtb = $bphtb;
    }
    
}

