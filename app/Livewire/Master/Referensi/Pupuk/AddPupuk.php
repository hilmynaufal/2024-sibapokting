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

class AddPupuk extends Component
{
    use LivewireAlert;

    public $id;
    public $namapupuk;
    public $notelp;
    public $alamat;
    public $provinsi;
    public $kabupaten;
    public $kecamatan;
    public $desa;
    public $rt;
    public $rw;
    public $token;
    public $keterangan;
    public $id_distributor;
    
    public $provinsiList;
    public $kabupatenList;
    public $kecamatanList;
    public $kelurahanList;
    public $distributorList;

    #[Layout('components.layouts.keenthemes.page')]
    public function render()
    {
        return view('livewire.master.referensi.pupuk.add-pupuk');
    }
    
    public function mount()
    {
        $this->distributorList     = RefDistributor::orderBy('namadistributor','ASC')->get();
        $this->provinsiList        = RefProvinsi::orderBy('name','ASC')->get();
        $this->kabupatenList       = RefKabupaten::where('province_id', $this->provinsi)->orderBy('name','ASC')->get();
        $this->kecamatanList       = RefKecamatan::where('regency_id', $this->kabupaten)->orderBy('name','ASC')->get();
        $this->kelurahanList       = RefDesa::where('district_id', $this->kecamatan)->orderBy('name','ASC')->get();
    }

    public function create()
    {
        $this->validate([
                'namapupuk'    => 'required',
                'notelp'           => 'required',
                'alamat'           => 'required',
                'provinsi'          => 'required',
                'kabupaten'         => 'required',
                'kecamatan'         => 'required',
                'id_distributor'    => 'required',
                'desa'              => 'required',
                'keterangan'           => 'required',
            ]);

            $model = Model::create([
                'id_distributor'     => $this->id_distributor,
                'namapupuk'         => $this->namapupuk,
                'notelp'          => $this->notelp,
                'provinsi'      => $this->provinsi,
                'kabupaten'     => $this->kabupaten,
                'kecamatan'     => $this->kecamatan,
                'rt'            => $this->rt,
                'rw'            => $this->rw,
                'desa'          => $this->desa,
                'alamat'        => $this->alamat,
                'keterangan'        => $this->keterangan,
                'created_id'    => Auth::user()->id,
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
            if($model->save()){
                $this->alert('success', 'Data Kios Pupuk Berhasil di Simpan', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('master.referensi.mapspupuk', [Crypt::encrypt($model->id)]);
            }else{
                $this->alert('error', 'Data Kios Pupuk Gagal di Simpan', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('master.referensi.mapspupuk', [Crypt::encrypt($model->id)]);
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

