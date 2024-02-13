<?php

namespace App\Livewire\Main\SuratMasuk;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\SuratMasuk as Model;

class DetailSurat extends Component
{
    public $primaryId;   
    public $surat_masuk_id;   
    
    public $tgl_terima;
    public $tgl_surat;
    
    public $pembuat_surat_id;
    public $satuan_kerja_id;
    public $no_surat;
    public $alamat_pengirim;
    public $perihal_surat;
    public $sekretaris_surat_id;
    public $tujuan_surat_id;
    public $no_arsip;
    public $isi_surat;
    public $keterangan_surat;
    public $pengirim_surat;
    public $file_lampiran;
    public $surat_masuk_token;
    
    public function mount($id)
    {
        $this->primaryId = $id;
        $model = Model::where('id','=',$this->primaryId)->first();
        $this->tgl_terima = Carbon::parse($model->tgl_terima)->locale('id')->isoFormat('LL');
        $this->tgl_surat = Carbon::parse($model->tgl_surat)->locale('id')->isoFormat('LL');
        $this->pembuat_surat_id = $model->pembuat_surat_id;
        $this->no_surat = $model->no_surat;
        $this->alamat_pengirim = $model->alamat;
        $this->perihal_surat = $model->perihal_surat;
        $this->tujuan_surat_id = $model->tujuan->jabatan;
        $this->no_arsip = $model->no_arsip;
        $this->isi_surat = $model->isi_surat;
        $this->keterangan_surat = $model->keterangan_surat;
        $this->pengirim_surat = $model->pengirim_surat; 
        $this->surat_masuk_id = $model->id;
        $this->surat_masuk_token = $model->token;
        // dd($model->token);
    }
    
    
    public function render()
    {
        return view('livewire.main.surat-masuk.detail-surat',['primaryId'=>$this->primaryId]);
    }
    
}
