<?php

namespace App\Livewire\Main\Layanan\Bphtb\Detail;
use App\Models\Bphtb\ObjekPajakVerifikasi as Model;
use App\Models\Bphtb\PembayaranPajakKurang;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class HeadKb extends Component
{
    public $pembayaran_pajak;
    public $objek_pajak;
    public $id_bphtb;
    
    public function render()
    {
        return view('livewire.main.layanan.bphtb.detail.head-kb');
    }
    
    public function mount($id)
    {
        $bphtb = Crypt::decrypt($id);
        $this->objek_pajak = Model::where('id_bphtb',$bphtb)->first();
        $this->pembayaran_pajak = PembayaranPajakKurang::where('id_bphtb',$bphtb)->first();
        $this->id_bphtb = $bphtb;
    }
    
}

