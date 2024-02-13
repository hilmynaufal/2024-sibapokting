<?php

namespace App\Livewire\Main\Layanan\Bphtb\Detail;
use App\Models\Bphtb\PelepasHak as Model;
use App\Models\Wilayah\RefDesa;
use App\Models\Wilayah\RefKecamatan;
use App\Models\Wilayah\RefKabupaten;
use App\Models\Wilayah\RefProvinsi;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class PelepasHak extends Component
{
    public $pelepas_hak;
    public $id_bphtb;
    public $provinsiList;
    public $kabupatenList;
    public $kecamatanList;
    public $kelurahanList;
    
    public function render()
    {
        return view('livewire.main.layanan.bphtb.detail.pelepas-hak');
    }
    
    public function mount($id)
    {

        $bphtb = Crypt::decrypt($id);
        $this->pelepas_hak = Model::where('id_bphtb',$bphtb)->first();
        $this->id_bphtb = $bphtb;

        $this->provinsiList        = RefProvinsi::orderBy('name','asc')->get();
        $this->kabupatenList       = RefKabupaten::where('province_id', $this->pelepas_hak->id_provinsi)->get();
        $this->kecamatanList       = RefKecamatan::where('regency_id', $this->pelepas_hak->id_kota_kab)->get();
        $this->kelurahanList       = RefDesa::where('district_id', $this->pelepas_hak->id_kecamatan)->get();
    }
    
}

