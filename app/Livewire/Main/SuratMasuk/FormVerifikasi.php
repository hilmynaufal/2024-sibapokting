<?php

namespace App\Livewire\Main\SuratMasuk;
use App\Models\SuratMasuk as Model;
use Livewire\Component;

class FormVerifikasi extends Component
{
    public $primaryId;   
    public $surat_masuk_id;   
    public $tujuan_surat_token;   
    
    public function mount($id)
    {
        $model = Model::where('id',$id)->first();
        // dd($model->id);
        $this->primaryId = $id;
        $this->surat_masuk_id = $model->id;
        $this->tujuan_surat_token = $model->tujuan_surat_token;
    }
    
    public function render()
    {
        return view('livewire.main.surat-masuk.form-verifikasi',['primaryId'=>$this->surat_masuk_id]);
    }
}
