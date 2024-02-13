<?php

namespace App\Livewire\Main\Layanan\Bphtb\Detail;
use App\Models\Bphtb\ObjekPajak as Model;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class ObjekPajak extends Component
{
    public $listPersyaratanVerifikasi;
    public $listPersyaratanValidasi;
    public $objek_pajak;
    public $file_dokumen;
    public $id_bphtb;
    
    public function render()
    {
        return view('livewire.main.layanan.bphtb.detail.objek-pajak');
    }
    
    public function mount($id)
    {
        $bphtb = Crypt::decrypt($id);
        $this->objek_pajak = Model::where('id_bphtb',$bphtb)->first();
        $model = Model::where('id_bphtb',$bphtb)->first();
        $this->id_bphtb = $model->id_bphtb;
    }
    
}

