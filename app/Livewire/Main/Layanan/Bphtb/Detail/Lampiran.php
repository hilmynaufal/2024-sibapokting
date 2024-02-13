<?php

namespace App\Livewire\Main\Layanan\Bphtb\Detail;
use App\Models\Bphtb\ObjekPajak as Model;
use App\Models\Pajak\RefPersyaratan;
use App\Models\Bphtb\Persyaratan;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Storage;


class Lampiran extends Component
{
    public $listPersyaratanVerifikasi;
    public $listPersyaratanValidasi;
    public $model;
    public $file_dokumen;
    public $id_bphtb;
    
    public function render()
    {
        return view('livewire.main.layanan.bphtb.detail.lampiran');
    }
    
    public function mount($id)
    {
        $bphtb = Crypt::decrypt($id);
        $this->model = Model::where('id_bphtb',$bphtb)->first();
        $model = Model::where('id_bphtb',$bphtb)->first();
        $this->id_bphtb = $model->id_bphtb;
        $this->listPersyaratanVerifikasi = Persyaratan::where('jenis_transaksi_id', $model->jenis_transaksi_id)
        ->where('jenis_persyaratan', 1)
        ->where('id_bphtb', $bphtb)
        // ->orderBy('nama_persyaratan','ASC')
        ->get();
        
        $this->listPersyaratanValidasi = Persyaratan::where('jenis_transaksi_id', $model->jenis_transaksi_id)
        ->where('jenis_persyaratan', 3)
        ->where('id_bphtb', $bphtb)
        // ->orderBy('nama_persyaratan','ASC')
        ->get();
    }
    
    
    
}

