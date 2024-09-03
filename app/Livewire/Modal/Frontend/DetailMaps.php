<?php
namespace App\Livewire\Modal\Frontend;

use App\Models\Referensi\RefPasar;
use LivewireUI\Modal\ModalComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DetailMaps extends ModalComponent
{
    use LivewireAlert;
    public $informasi;
    
    public function render()
    {
        return view('livewire.main.transaksi.barang.modal.add');
    }
    
    public function mount($id)
    {
        $this->informasi = RefPasar::where('id',$id)->first();
        
    }

}

