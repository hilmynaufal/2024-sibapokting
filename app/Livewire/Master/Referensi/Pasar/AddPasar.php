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

class AddPasar extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    
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

    public $sejarah;
    public $area_pasar;
    public $jam_oprasional;
    public $luas_pasar;
    public $jumlah_kios;
    public $jumlah_pedagang;
    public $jenis_barang;
    public $fasilitas_umum;
    public $gambar_utama;
    public $gambar_lainnya = [];
    // public $folderPathImage;
    // public $newFileNameImage;

    #[Layout('components.layouts.keenthemes.page')]
    public function render()
    {
        return view('livewire.master.referensi.pasar.add-pasar');
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
                'alamat'           => 'required',
                'provinsi'           => 'required',
                'kabupaten'          => 'required',
                'kecamatan'           => 'required',
                'desa'           => 'required',
            ]);
            // dd($this->gambar->getRealPath())->toMediaCollection('gambar');
            if(!empty($this->gambar_utama)){
                $folderPathImage = "pasar/headline";
                if (!file_exists(Storage::disk('public')->path($folderPathImage))) {
                    Storage::disk('public')->makeDirectory($folderPathImage, 0755, true);
                }
                $uploadedFileImage = $this->gambar_utama;
                $fileNameImage = $this->gambar_utama->getClientOriginalName(); // Mengambil nama asli file yang diunggah
                $newFileNameImage = time() . '_' . str_replace(' ','_',strtolower($fileNameImage)); // Menyusun nama baru file
                $this->gambar_utama->storeAs($folderPathImage, $newFileNameImage, 'public');
            }
            if(!empty($this->gambar_lainnya)){
                $folderPathImagesEtc = "pasar/etc";
                if (!file_exists(Storage::disk('public')->path($folderPathImagesEtc))) {
                    Storage::disk('public')->makeDirectory($folderPathImagesEtc, 0755, true);
                }
                $newFileNames = []; // Menyimpan nama file yang baru
                foreach($this->gambar_lainnya as $value){
                    $fileName = $value->getClientOriginalName(); // Mengambil nama asli file yang diunggah
                    $newFileName = time() . '_' . str_replace(' ','_',strtolower($fileName)); // Menyusun nama baru file  
                    array_push($newFileNames, $folderPathImagesEtc.'/'.$newFileName);
                    $value->storeAs($folderPathImagesEtc, $newFileName, 'public');
                }
                $this->gambar_lainnya = $newFileNames; 
            }
            $model = Model::create([
                'namapasar'     => $this->namapasar,
                'tipe'          => $this->tipe,
                'provinsi'      => $this->provinsi,
                'kabupaten'     => $this->kabupaten,
                'kecamatan'     => $this->kecamatan,
                'desa'          => $this->desa,
                'alamat'        => $this->alamat,
                'rt'            => $this->rt,
                'rw'            => $this->rw,
                'sejarah'       => $this->sejarah,
                'gambar_utama'  => $folderPathImage.'/'.$newFileNameImage,
                'gambar_lainnya'=> json_encode($this->gambar_lainnya),
                'area_pasar'    => $this->area_pasar,
                'jam_oprasional'=> $this->jam_oprasional,
                'luas_pasar'    => $this->luas_pasar,
                'jumlah_kios'   => $this->jumlah_kios,
                'jumlah_pedagang'=> $this->jumlah_pedagang,
                'jenis_barang'  => $this->jenis_barang,
                'fasilitas_umum'=> $this->fasilitas_umum,
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

