<?php

namespace App\Livewire\Website\Galeri;
use Livewire\Component;
use App\Models\Website\RefGaleri as Model;
use App\Models\Website\RefKategori;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Storage;

class Add extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $id;
    public $nama;
    public $gambar;
    public $kategori;
    public $token;
    public $multi_gambar = [];
    public $images = [];
    public $kategoriList;

    #[Layout('components.layouts.keenthemes.page')]
    public function render()
    {
        return view('livewire.website.galeri.add');
    }
    
    public function mount()
    {
        $this->kategoriList     = RefKategori::orderBy('nama','ASC')->get();
    }


    public function create()
    {
        $this->validate([
            'nama' => 'required',
            'gambar' => 'required',
            'kategori' => 'required',
            ]);

            // dd($this->gambar->getRealPath())->toMediaCollection('gambar');
            if(!empty($this->gambar)){
                $folderPathImage = "website/galeri/headline";
                if (!file_exists(Storage::disk('public')->path($folderPathImage))) {
                    Storage::disk('public')->makeDirectory($folderPathImage, 0755, true);
                }
                $uploadedFileImage = $this->gambar;
                $fileNameImage = $this->gambar->getClientOriginalName(); // Mengambil nama asli file yang diunggah
                $newFileNameImage = time() . '_' . str_replace(' ','_',strtolower($fileNameImage)); // Menyusun nama baru file
                $this->gambar->storeAs($folderPathImage, $newFileNameImage, 'public');
            }
            if(!empty($this->multi_gambar)){
                $folderPathImages = "website/galeri/etc";
                if (!file_exists(Storage::disk('public')->path($folderPathImages))) {
                    Storage::disk('public')->makeDirectory($folderPathImages, 0755, true);
                }
                foreach($this->multi_gambar as $value){
                    $uploadedFileImages = $value;
                    $fileNameImages = $value->getClientOriginalName(); // Mengambil nama asli file yang diunggah
                    $newFileNameImages = time() . '_' . str_replace(' ','_',strtolower($fileNameImages)); // Menyusun nama baru file  
                    array_push($this->images,$folderPathImages.'/'.$newFileNameImages);
                    $value->storeAs($folderPathImages, $newFileNameImages, 'public');

                }
            }

            $model = Model::create([
                'nama'             => $this->nama,
                'gambar'            => $folderPathImage.'/'.$newFileNameImage,
                'multi_gambar'      => json_encode($this->images),
                'kategori'          => $this->kategori,
                'created_id'        => Auth::user()->id,
                'created_at'        => date('Y-m-d H:i:s'),
            ]);
            // dd($this->images);
            // die;
            if($model->save()){
                $this->alert('success', 'Data Galeri Berhasil di Simpan', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('website.galeri.index');
            }else{
                $this->alert('error', 'Data Galeri Gagal di Simpan', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('website.galeri.index');
            }
            
    }
}

