<?php

namespace App\Livewire\Master\Referensi\Pupuk;
use Livewire\Component;
use App\Models\Referensi\RefPupuk as Model;
use App\Models\Referensi\RefDistributor;
use App\Models\Wilayah\RefDesa;
use App\Models\Wilayah\RefKecamatan;
use App\Models\Wilayah\RefKabupaten;
use Livewire\Attributes\Layout;
use App\Models\Wilayah\RefProvinsi;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EditPupuk extends Component
{
    use LivewireAlert;

    
    public $id_pupuk;
    public $id_distributor;
    public $namapupuk;
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
    public $distributorList;

    #[Layout('components.layouts.keenthemes.page')]
    public function render()
    {
        return view('livewire.master.referensi.pupuk.edit-pupuk');
    }
    
    public function mount($id)
    {
        $idPupuk = Crypt::decrypt($id);
        $model = Model::where('id',$idPupuk)->first();
        $this->id_pupuk         = $model->id;
        $this->id_distributor   = $model->id_distributor;
        $this->namapupuk        = $model->namapupuk;
        $this->notelp           = $model->notelp;
        $this->alamat           = $model->alamat;
        $this->provinsi         = $model->provinsi;
        $this->kabupaten            = $model->kabupaten;
        $this->kecamatan            = $model->kecamatan;
        $this->desa                 = $model->desa;
        $this->rt                   = $model->rt;
        $this->rw                   = $model->rw;
        $this->keterangan           = $model->keterangan;


        $this->distributorList     = RefDistributor::orderBy('namadistributor','ASC')->get();
        $this->provinsiList        = RefProvinsi::orderBy('name','ASC')->get();
        $this->kabupatenList       = RefKabupaten::where('province_id', $this->provinsi)->orderBy('name','ASC')->get();
        $this->kecamatanList       = RefKecamatan::where('regency_id', $this->kabupaten)->orderBy('name','ASC')->get();
        $this->kelurahanList       = RefDesa::where('district_id', $this->kecamatan)->orderBy('name','ASC')->get();
    }

    public function create()
    {
        $this->validate([
                'id_distributor'     => 'required',
                'namapupuk'         => 'required',
                'notelp'           => 'required',
                'alamat'           => 'required',
                'provinsi'           => 'required',
                'kabupaten'          => 'required',
                'kecamatan'           => 'required',
                'desa'           => 'required',
                'keterangan'           => 'required',
            ]);
            $model = Model::where('id',$this->id_pupuk)->first();
            $model->namapupuk    = $this->namapupuk;
            $model->notelp           = $this->notelp;
            $model->id_distributor           = $this->id_distributor;
            $model->alamat           = $this->alamat;
            $model->provinsi           = $this->provinsi;
            $model->kabupaten          = $this->kabupaten;
            $model->kecamatan           = $this->kecamatan;
            $model->keterangan           = $this->keterangan;
            $model->rt           = $this->rt;
            $model->rw           = $this->rw;
            $model->desa            = $this->desa;
            $model->updated_id      = Auth::user()->id;
            $model->updated_at      = date('Y-m-d H:i:s');        
            if($model->update()){
                $this->alert('success', 'Data Kios Pupuk Berhasil di Ubah', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('master.referensi.pupuk');
            }else{
                $this->alert('error', 'Data Kios Pupuk Gagal di Ubah', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('master.referensi.pupuk');
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

