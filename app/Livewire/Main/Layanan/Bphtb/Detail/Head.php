<?php

namespace App\Livewire\Main\Layanan\Bphtb\Detail;
use App\Models\Bphtb\PembayaranPajak as Model;
use App\Models\Bphtb\ObjekPajak;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class Head extends Component
{
    public $pembayaran_pajak;
    public $objek_pajak;
    public $id_bphtb;
    
    public function render()
    {
        return view('livewire.main.layanan.bphtb.detail.head');
    }
    
    public function mount($id)
    {
        $bphtb = Crypt::decrypt($id);
        $this->pembayaran_pajak = Model::where('id_bphtb',$bphtb)->first();
        $this->objek_pajak = ObjekPajak::where('id_bphtb',$bphtb)->first();
        $this->id_bphtb = $bphtb;
    }
    
}

