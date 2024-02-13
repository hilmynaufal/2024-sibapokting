<?php

namespace App\Livewire\Main\DisposisiKeluar;
use Livewire\Component;
use Livewire\Attributes\On; 
use App\Models\DisposisiLaporan as Model;

class IndexLaporan extends Component
{
    public $primaryId;   
    public $surat_masuk_id;   
    
    #[On('laporan_view')]
    public function mount($id)
    {
        // dd($id);
        $this->primaryId = $id;
        $this->surat_masuk_id = $id;
    }
    
    
    // #[On('laporan_insert')]
    public function render()
    {
        $models = Model::where('surat_id_token', $this->primaryId)->OrderBy('created_at','DESC')->get();
        // dd($models);
        return view('livewire.main.disposisi-keluar.index-laporan', [ 'disposisi_laporan' => $models, 'primaryId'=>$this->primaryId ]);
    }
}
