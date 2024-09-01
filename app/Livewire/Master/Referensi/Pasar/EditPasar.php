<?php

namespace App\Livewire\Master\Referensi\Pasar;
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
use Livewire\WithFileUploads;
use Storage;

class EditPasar extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    
    public $id_pasar;
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

    public $sejarah;
    public $area_pasar;
    public $jam_oprasional;
    public $luas_pasar;
    public $jumlah_kios;
    public $jumlah_pedagang;
    public $jenis_barang;
    public $fasilitas_umum;
    public $gambar_utama;
    public $gambar_utama_edit;
    public $gambar_lainnya = [];
    public $gambar_lainnya_edit = [];
    public $images = [];

    #[Layout('components.layouts.keenthemes.page')]
    public function render()
    {
        return view('livewire.master.referensi.pasar.edit-pasar');
    }
    
    public function mount($id)
    {
        $idPasar = Crypt::decrypt($id);
        $model = Model::where('id',$idPasar)->first();
        $this->id_pasar             = $model->id;
        $this->namapasar            = $model->namapasar;
        $this->tipe                 = $model->tipe;
        $this->alamat               = $model->alamat;
        $this->provinsi             = $model->provinsi;
        $this->kabupaten            = $model->kabupaten;
        $this->kecamatan            = $model->kecamatan;
        $this->desa                 = $model->desa;
        $this->rt                   = $model->rt;
        $this->rw                   = $model->rw;
        $this->sejarah              = $model->sejarah;
        $this->area_pasar           = $model->area_pasar;
        $this->jam_oprasional       = $model->jam_oprasional;
        $this->luas_pasar           = $model->luas_pasar;
        $this->jumlah_kios          = $model->jumlah_kios;
        $this->jumlah_pedagang      = $model->jumlah_pedagang;
        $this->jenis_barang         = $model->jenis_barang;
        $this->fasilitas_umum       = $model->fasilitas_umum;
        $this->gambar_utama         = $model->gambar_utama;
        $this->gambar_lainnya       = json_decode($model->gambar_lainnya);



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
                'alamat'           => 'required',
                'provinsi'           => 'required',
                'kabupaten'          => 'required',
                'kecamatan'           => 'required',
                'desa'           => 'required',
            ]);
            $model = Model::where('id',$this->id_pasar)->first();
            $model->namapasar       = $this->namapasar;
            $model->tipe            = $this->tipe;
            $model->alamat          = $this->alamat;
            $model->rt              = $this->rt;
            $model->rw              = $this->rw;
            $model->provinsi        = $this->provinsi;
            $model->kabupaten       = $this->kabupaten;
            $model->kecamatan       = $this->kecamatan;
            $model->desa            = $this->desa;
            $model->sejarah         = $this->sejarah;
            $model->area_pasar      = $this->area_pasar;
            $model->jam_oprasional  = $this->jam_oprasional;
            $model->luas_pasar      = $this->luas_pasar;
            $model->jumlah_kios     = $this->jumlah_kios;
            $model->jumlah_pedagang = $this->jumlah_pedagang;
            $model->jenis_barang    = $this->jenis_barang;
            $model->fasilitas_umum  = $this->fasilitas_umum;
            $model->updated_id      = Auth::user()->id;
            $model->updated_at      = date('Y-m-d H:i:s');

            if(!empty($this->gambar_utama_edit)){
                $folderPathImage = "pasar/headline";
                if (!file_exists(Storage::disk('public')->path($folderPathImage))) {
                    Storage::disk('public')->makeDirectory($folderPathImage, 0755, true);
                }
                $uploadedFileImage = $this->gambar_utama_edit;
                $fileNameImage = $this->gambar_utama_edit->getClientOriginalName(); // Mengambil nama asli file yang diunggah
                $newFileNameImage = time() . '_' . str_replace(' ','_',strtolower($fileNameImage)); // Menyusun nama baru file
                $this->gambar_utama_edit->storeAs($folderPathImage, $newFileNameImage, 'public');
            }
            if(!empty($this->gambar_lainnya_edit)){
                $folderPathImages = "pasar/etc";
                if (!file_exists(Storage::disk('public')->path($folderPathImages))) {
                    Storage::disk('public')->makeDirectory($folderPathImages, 0755, true);
                }
                $newFileNames = []; // Menyimpan nama file yang baru
                foreach($this->gambar_lainnya_edit as $value){
                    $fileName = $value->getClientOriginalName(); // Mengambil nama asli file yang diunggah
                    $newFileName = time() . '_' . str_replace(' ','_',strtolower($fileName)); // Menyusun nama baru file  
                    array_push($newFileNames, $folderPathImages.'/'.$newFileName);
                    $value->storeAs($folderPathImages, $newFileName, 'public');
                }
                $this->gambar_lainnya_edit = $newFileNames; // Menyimpan nama file baru ke variabel gambar_lainnya_edit
            }        
            if(!empty($this->gambar_utama_edit)){
                $model->gambar_utama      = $folderPathImage.'/'.$newFileNameImage;
            }
            if(!empty($this->gambar_lainnya_edit)){
                $model->gambar_lainnya    = json_encode($this->gambar_lainnya_edit);
            }

            if($model->update()){
                $this->alert('success', 'Data Pasar Berhasil di Ubah', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('master.referensi.pasar');
            }else{
                $this->alert('error', 'Data Pasar Gagal di Ubah', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('master.referensi.pasar');
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

