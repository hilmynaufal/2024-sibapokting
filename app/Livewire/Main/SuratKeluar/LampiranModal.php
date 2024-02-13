<?php

namespace App\Livewire\Main\SuratKeluar;
use Livewire\Attributes\On; 
use Livewire\Component;
use App\Models\Lampiran as Model;
use Storage;
class LampiranModal extends Component
{
    public $primaryId;   
    public $tokenId;   
    public $file_lampiran_url;   
    public $file_lampiran;   
    
    #[On('view-lampiran')]
    public function viewTimeline($primaryId)
    {
        // dd($primaryId);
        $model = Model::where('file_lampiran_url',$primaryId)->first();
        // dd($model->token);
        $this->primaryId = $model->id;
        $this->tokenId = $model->token;
        $this->file_lampiran = $model->file_lampiran;
        // $this->file_lampiran_url = Storage::disk('public')->url($model->file_lampiran_url);
        $this->file_lampiran_url = getApp()->storage_url.$model->file_lampiran_url;
        setActivity('Lihat Timeline Surat Keluar dengan ID# '.$primaryId);
    }
    
    public function render()
    {
        return view('livewire.main.surat-keluar.lampiran-modal');
    }
}
