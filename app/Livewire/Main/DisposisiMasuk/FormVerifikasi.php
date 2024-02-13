<?php

namespace App\Livewire\Main\DisposisiMasuk;
use Livewire\Component;

class FormVerifikasi extends Component
{
    public $primaryId;   
    public $surat_masuk_id;   
    
    public function mount($id)
    {
        // dd($id);
        $this->primaryId = $id;
        $this->surat_masuk_id = $id;
    }
    
    public function render()
    {
        return view('livewire.main.disposisi-masuk.form-verifikasi',['primaryId'=>$this->primaryId]);
    }
}
