<?php

namespace App\Livewire\Main\DisposisiMasuk;
use Livewire\Attributes\On; 
use Livewire\Component;

class CetakModal extends Component
{
    public $primaryId;   
    public $surat_masuk_id;   
    
    #[On('view-lembardisposisi')]
    public function viewCetak($primaryId)
    {
        $this->primaryId = $primaryId;
    }
    
    public function render()
    {
        return view('livewire.main.disposisi-masuk.cetak-modal',['primaryId'=>$this->primaryId]);
    }
}
