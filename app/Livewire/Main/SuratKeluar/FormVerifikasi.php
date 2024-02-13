<?php

namespace App\Livewire\Main\SuratKeluar;
use App\Models\SuratKeluar as Model;
use Livewire\Component;

class FormVerifikasi extends Component
{
    public $primaryId;   
    public $surat_masuk_id;   
    public $surat_masuk_token;    
    public $tujuan_surat_token;    
    
    public function mount($id)
    {
        $model = Model::where('id',$id)->first();
        $this->primaryId = $id;
        $this->surat_masuk_id = $model->id;
        $this->surat_masuk_token = $model->token;
        $this->tujuan_surat_token = $model->tujuan_surat_token;
    }
    
    public function render()
    {
        return view('livewire.main.surat-keluar.form-verifikasi',['primaryId'=>$this->surat_masuk_id]);
    }
}
