<?php

namespace App\Livewire\Master\Referensi;
use Livewire\Component;
use App\Models\Referensi\RefPasar as Model;
use App\Models\Wilayah\RefDesa;
use App\Models\Wilayah\RefKecamatan;
use App\Models\Wilayah\RefKabupaten;
use Livewire\Attributes\Layout;
use App\Models\Wilayah\RefProvinsi;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AddPasar extends Component
{
    use LivewireAlert;

    
    public $id;
    public $namapasar;
    public $tipe;
    public $alamat;
    public $provinsi;
    public $kabupaten;
    public $kecamatan;
    public $desa;
    public $rt;
    public $rw;
    public $token;
    
    public $provinsiList;
    public $kabupatenList;
    public $kecamatanList;
    public $kelurahanList;

    #[Layout('components.layouts.keenthemes.page')]
    public function render()
    {
        return view('livewire.master.referensi.add-pasar');
    }
    
    public function mount()
    {
        $this->provinsiList        = RefProvinsi::orderBy('name','ASC')->get();
        $this->kabupatenList       = RefKabupaten::where('province_id', $this->provinsi)->orderBy('name','ASC')->get();
        $this->kecamatanList       = RefKecamatan::where('regency_id', $this->kabupaten)->orderBy('name','ASC')->get();
        $this->kelurahanList       = RefDesa::where('district_id', $this->kecamatan)->orderBy('name','ASC')->get();
    }

    public function create()
    {
        $this->validate([
                'namapasar'    => 'required',
                'tipe'           => 'required',
                'provinsi'           => 'required',
                'kabupaten'          => 'required',
                'kecamatan'           => 'required',
                'desa'           => 'required',
            ]);

            $model = Model::create([
                'namapasar'     => $this->namapasar,
                'tipe'          => $this->tipe,
                'provinsi'      => $this->provinsi,
                'kabupaten'     => $this->kabupaten,
                'kecamatan'     => $this->kecamatan,
                'desa'          => $this->desa,
                'created_id'    => Auth::user()->id,
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
            if($model->save()){
                $this->alert('success', 'Data Pasar Berhasil di Simpan', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('master.referensi.mapspasar', [Crypt::encrypt($model->id)]);
            }else{
                $this->alert('error', 'Data Pasar Gagal di Simpan', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('master.referensi.mapspasar', [Crypt::encrypt($model->id)]);
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

