<?php

namespace App\Livewire\Main\SuratMasuk;
use Livewire\Component;

class Timeline extends Component
{
    public $primaryId;   
    public $surat_masuk_id;   
    
    public function mount($id)
    {
        // dd($id);
        $this->primaryId = $id;
        $this->surat_masuk_id = $id;
        setActivity('Pengguna Melihat Timeline Surat Masuk dengan ID# '.$id);
    }
    
    public function render()
    {
        return view('livewire.main.surat-masuk.timeline',['primaryId'=>$this->primaryId]);
    }
}
