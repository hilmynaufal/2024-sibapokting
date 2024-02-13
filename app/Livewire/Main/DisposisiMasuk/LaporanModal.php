<?php

namespace App\Livewire\Main\DisposisiMasuk;
use Livewire\Attributes\On; 
use Livewire\Component;
use App\Models\LampiranLaporan as Model;
use Storage;
class LaporanModal extends Component
{
    public $primaryId;   
    public $tokenId;   
    public $file_lampiran_url;   
    public $file_lampiran;   
    
    #[On('view-lampiran-laporan')]
    public function viewTimeline($primaryId)
    {
        // dd($primaryId);
        $model = Model::where('file_lampiran_url',$primaryId)->first();
        // dd($model->token);
        $this->primaryId = $model->id;
        $this->tokenId = $model->token;
        $this->file_lampiran = $model->file_lampiran;
        // $this->file_lampiran_url = url($model->file_lampiran_url);
        // $this->file_lampiran_url = Storage::disk('public')->url($model->file_lampiran_url);
        $this->file_lampiran_url = getApp()->storage_url.$model->file_lampiran_url;
        setActivity('Lihat Lampiran Laporan dengan ID# '.$primaryId);
    }
    
    public function render()
    {
        return view('livewire.main.disposisi-masuk.laporan-modal');
    }
}
