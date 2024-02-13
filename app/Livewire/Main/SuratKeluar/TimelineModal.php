<?php

namespace App\Livewire\Main\SuratKeluar;
use Livewire\Attributes\On; 
use Livewire\Component;
use App\Models\SuratKeluar as Model;

class TimelineModal extends Component
{
    public $primaryId;   
    public $tokenId;   
    
    #[On('view-timeline')]
    public function viewTimeline($primaryId)
    {
        // dd($primaryId);
        // Model::where('')
        $model = Model::where('token',$primaryId)->first();
        $this->primaryId = $model->id;
        $this->tokenId = $model->token;
        setActivity('Lihat Timeline Surat Keluar dengan ID# '.$primaryId);
    }
    
    public function render()
    {
        return view('livewire.main.surat-keluar.timeline-modal',[
            'primaryId'=>$this->primaryId,
            'tokenId'=>$this->tokenId
        ]);
    }
}
