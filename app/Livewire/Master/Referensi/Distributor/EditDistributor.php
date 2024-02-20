<?php

namespace App\Livewire\Master\Referensi\Distributor;
use Livewire\Component;
use App\Models\Referensi\RefDistributor as Model;
use App\Models\Wilayah\RefDesa;
use App\Models\Wilayah\RefKecamatan;
use App\Models\Wilayah\RefKabupaten;
use Livewire\Attributes\Layout;
use App\Models\Wilayah\RefProvinsi;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EditDistributor extends Component
{
    use LivewireAlert;

    
    public $id_distributor;
    public $namadistributor;
    public $notelp;
    public $alamat;
    public $provinsi;
    public $kabupaten;
    public $kecamatan;
    public $desa;
    public $rt;
    public $rw;
    public $keterangan;
    public $token;
    
    public $provinsiList;
    public $kabupatenList;
    public $kecamatanList;
    public $kelurahanList;

    #[Layout('components.layouts.keenthemes.page')]
    public function render()
    {
        return view('livewire.master.referensi.distributor.edit-distributor');
    }
    
    public function mount($id)
    {
        $idDistributor = Crypt::decrypt($id);
        $model = Model::where('id',$idDistributor)->first();
        $this->id_distributor           = $model->id;
        $this->namadistributor            = $model->namadistributor;
        $this->notelp                 = $model->notelp;
        $this->alamat           = $model->alamat;
        $this->provinsi         = $model->provinsi;
        $this->kabupaten            = $model->kabupaten;
        $this->kecamatan            = $model->kecamatan;
        $this->desa                 = $model->desa;
        $this->rt                   = $model->rt;
        $this->rw                   = $model->rw;
        $this->keterangan           = $model->keterangan;


        $this->provinsiList        = RefProvinsi::orderBy('name','ASC')->get();
        $this->kabupatenList       = RefKabupaten::where('province_id', $this->provinsi)->orderBy('name','ASC')->get();
        $this->kecamatanList       = RefKecamatan::where('regency_id', $this->kabupaten)->orderBy('name','ASC')->get();
        $this->kelurahanList       = RefDesa::where('district_id', $this->kecamatan)->orderBy('name','ASC')->get();
    }

    public function create()
    {
        $this->validate([
                'namadistributor'    => 'required',
                'notelp'           => 'required',
                'alamat'           => 'required',
                'provinsi'           => 'required',
                'kabupaten'          => 'required',
                'kecamatan'           => 'required',
                'desa'           => 'required',
                'keterangan'           => 'required',
            ]);
            $model = Model::where('id',$this->id_distributor)->first();
            $model->namadistributor    = $this->namadistributor;
            $model->notelp           = $this->notelp;
            $model->alamat           = $this->alamat;
            $model->provinsi           = $this->provinsi;
            $model->kabupaten          = $this->kabupaten;
            $model->kecamatan           = $this->kecamatan;
            $model->rt           = $this->rt;
            $model->rw           = $this->rw;
            $model->desa            = $this->desa;
            $model->updated_id      = Auth::user()->id;
            $model->updated_at      = date('Y-m-d H:i:s');        
            if($model->update()){
                $this->alert('success', 'Data Distributor Berhasil di Ubah', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('master.referensi.distributor');
            }else{
                $this->alert('error', 'Data Distributor Gagal di Ubah', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('master.referensi.distributor');
            }
            
    }
    

    public function updatedProvinsi($provinsi){
        $this->kabupatenList = RefKabupaten::where('province_id', $this->provinsi)->get();
    }
    
    public function updatedKabupaten($kabupaten){
        $this->kecamatanList = RefKecamatan::where('regency_id', $this->kabupaten)->get();
        
    }
    
    public function updatedKecamatan($kecamatan){
        $this->kelurahanList = RefDesa::where('district_id', $this->kecamatan)->get();
        
    }

    public static function destroyOnClose(): bool
    {
        return true;
    }

    public static function closeModalOnClickAway(): bool
{
    return false;
}
    
}

