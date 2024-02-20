<?php

namespace App\Livewire\Master\Referensi\Pangkalan;
use Livewire\Component;
use App\Models\Referensi\RefPangkalan as Model;
use App\Models\Wilayah\RefDesa;
use App\Models\Wilayah\RefKecamatan;
use App\Models\Wilayah\RefKabupaten;
use Livewire\Attributes\Layout;
use App\Models\Wilayah\RefProvinsi;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class MapsPangkalan extends Component
{
    use LivewireAlert;

    
    public $id;
    public $lng;
    public $lat;

    #[Layout('components.layouts.keenthemes.page')]
    public function render()
    {
        return view('livewire.master.referensi.pangkalan.maps-pangkalan');
    }
    
    public function mount($id)
    {
        
        $idPangkalan = Crypt::decrypt($id);
        $model = Model::where('id',$idPangkalan)->first();
        $this->id = $model->id;
        $this->lat = $model->latitude;
        $this->lng = $model->longitude;
        
    }

    public function create()
    {
        
            $model = Model::where('id',$this->id)->first();
            $model->latitude = $this->lat;
            $model->longitude = $this->lng;

            if($model->update()){
                $this->alert('success', 'Perubahan Data Kios Pangkalan Berhasil di Simpan', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('master.referensi.pangkalan');
            }else{
                $this->alert('error', 'Perubahan Data Kios Pangkalan Gagal di Simpan', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('master.referensi.pangkalan');
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

