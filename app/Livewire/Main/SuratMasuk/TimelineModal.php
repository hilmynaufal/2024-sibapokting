<?php

namespace App\Livewire\Main\SuratMasuk;
use Livewire\Attributes\On; 
use Livewire\Component;
use App\Models\SuratMasuk as Model;

class TimelineModal extends Component
{
    public $primaryId;   
    public $tokenId;   
    public $no_surat;   
    public $tgl_surat;   
    public $pengirim_surat;   
    
    #[On('view-timeline')]
    public function viewTimeline($primaryId)
    {
        
        // Model::where('')
        $model = Model::where('token',$primaryId)->first();
        $this->primaryId = $model->id;
        $this->tokenId = $model->token;
        $this->no_surat = $model->no_surat;
        $this->tgl_surat = $model->tgl_surat;
        $this->pengirim_surat = $model->pengirim_surat;
        // dd($model->token);
        setActivity('Lihat Timeline Surat Masuk dengan ID# '.$primaryId);
    }
    
    public function render()
    {
        return view('livewire.main.surat-masuk.timeline-modal',[
            'primaryId'=>$this->primaryId,
            'tokenId'=>$this->tokenId
        ]);
    }
}
