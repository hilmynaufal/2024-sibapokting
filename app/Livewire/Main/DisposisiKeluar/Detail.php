<?php

namespace App\Livewire\Main\DisposisiKeluar;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\SuratMasuk as Model;
use App\Models\Disposisi;
use Livewire\Attributes\On; 
class Detail extends Component
{
    public $primaryId;   
    public $surat_masuk_id;   
    public $surat_masuk_token;   
    
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
    
    public $disposisi_id;
    public $disposisi_at;
    public $disposisi_batas_waktu;
    public $disposisi_tujuan;
    public $disposisi_instruksi;
    public $disposisi_catatan;
    
    public $disposisiId;
    public $disposisiDetailId;
    public $disposisiDetailTipe;
    public $disposisiDetailDirect;
    
    #[On('disposisi_view')] 
    public function detail($id)
    {
        $this->primaryId = $id;
        $disposisi = Disposisi::where('id','=',$this->primaryId)->first();
        // dd($id);
        $model = Model::where('id','=',$disposisi->surat_id)->first();
        $this->tgl_terima = Carbon::parse($model->tgl_terima)->locale('id')->isoFormat('LL');
        $this->tgl_surat = Carbon::parse($model->tgl_surat)->locale('id')->isoFormat('LL');
        $this->pembuat_surat_id = $model->pembuat_surat_id;
        $this->no_surat = $model->no_surat;
        $this->alamat_pengirim = $model->alamat;
        $this->perihal_surat = $model->perihal_surat;
        $this->tujuan_surat_id = $model->tujuan_surat_id;
        $this->no_arsip = $model->no_arsip;
        $this->isi_surat = $model->isi_surat;
        $this->keterangan_surat = $model->keterangan_surat;
        $this->pengirim_surat = $model->pengirim_surat; 
        $this->surat_masuk_id = $model->id;
        $this->surat_masuk_token = $model->token;
        // dd($model->token);
        $this->disposisi_id = $disposisi->disposisi_id;
        $this->disposisi_at = $disposisi->disposisi_at;
        $this->disposisi_batas_waktu = $disposisi->disposisi_batas_waktu;
        $this->disposisi_tujuan = $disposisi->disposisi_tujuan;
        $this->disposisi_instruksi = $disposisi->disposisi_instruksi;
        $this->disposisi_catatan = $disposisi->disposisi_catatan;  
        
        $this->disposisiId = $disposisi->disposisi_id;
        $this->disposisiDetailId = $disposisi->id;
        $this->disposisiDetailTipe = $disposisi->tipe;
        $this->disposisiDetailDirect = $disposisi->is_direct;
        
    }
    
    
    public function render()
    {
        return view('livewire.main.disposisi-keluar.detail',['primaryId'=>$this->primaryId]);
    }
    
}
