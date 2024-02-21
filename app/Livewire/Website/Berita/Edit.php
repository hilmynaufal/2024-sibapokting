<?php

namespace App\Livewire\Website\Berita;
use Livewire\Component;
use App\Models\Website\RefArticles as Model;
use App\Models\Website\RefKategori;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Storage;

class Edit extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $id_berita;
    public $judul;
    public $slug;
    public $tanggal;
    public $konten;
    public $gambar;
    public $sumber;
    public $kategori;
    public $status;
    public $created_at;
    public $created_id;
    public $updated_at;
    public $updated_id;
    public $deleted_at;
    public $deleted_id;
    public $token;
    public $multi_gambar = [];
    public $images = [];
    public $kategoriList;

    #[Layout('components.layouts.keenthemes.page')]
    public function render()
    {
        return view('livewire.website.berita.edit');
    }
    
    public function mount($id)
    {

        $idPangkalan = Crypt::decrypt($id);
        $model = Model::where('id',$idPangkalan)->first();
        $this->id_berita    = $model->id_berita;
        $this->judul        = $model->judul;
        $this->konten       = $model->konten;
        $this->gambar       = $model->gambar;
        $this->multi_gambar = json_decode($model->multi_gambar);
        $this->sumber       = $model->sumber;
        $this->kategori     = $model->kategori;
        $this->kategoriList = RefKategori::orderBy('nama','ASC')->get();


    }


    public function create()
    {
        $this->validate([
            'judul' => 'required',
            'sumber' => 'required',
            'gambar' => 'required',
            'kategori' => 'required',
            ]);

            // dd($this->gambar->getRealPath())->toMediaCollection('gambar');
            if(!empty($this->gambar)){
                $folderPathImage = "website/articles/headline";
                if (!file_exists(Storage::disk('public')->path($folderPathImage))) {
                    Storage::disk('public')->makeDirectory($folderPathImage, 0755, true);
                }
                $uploadedFileImage = $this->gambar;
                $fileNameImage = $this->gambar->getClientOriginalName(); // Mengambil nama asli file yang diunggah
                $newFileNameImage = time() . '_' . str_replace(' ','_',strtolower($fileNameImage)); // Menyusun nama baru file
                $this->gambar->storeAs($folderPathImage, $newFileNameImage, 'public');
            }
            if(!empty($this->multi_gambar)){
                $folderPathImages = "website/articles/etc";
                if (!file_exists(Storage::disk('public')->path($folderPathImages))) {
                    Storage::disk('public')->makeDirectory($folderPathImages, 0755, true);
                }
                foreach($this->multi_gambar as $value){
                    $uploadedFileImages = $value;
                    $fileNameImages = $value->getClientOriginalName(); // Mengambil nama asli file yang diunggah
                    $newFileNameImages = time() . '_' . str_replace(' ','_',strtolower($fileNameImages)); // Menyusun nama baru file  
                    array_push($this->images,$newFileNameImages);
                    $value->storeAs($folderPathImages, $newFileNameImages, 'public');

                }
            }

            $model = Model::create([
                'judul'             => $this->judul,
                'slug'              => str_replace(' ','_',strtolower($this->judul)),
                'tanggal'           => date('Y-m-d H:i:s'),
                'konten'            => $this->konten,
                'gambar'            => $newFileNameImage,
                'multi_gambar'      => json_encode($this->images),
                'sumber'            => $this->sumber,
                'kategori'          => $this->kategori,
                'status'            => 'DRAFT',
                'created_id'        => Auth::user()->id,
                'created_at'        => date('Y-m-d H:i:s'),
            ]);
            // dd($this->images);
            // die;
            if($model->save()){
                $this->alert('success', 'Data Pangkalan Berhasil di Simpan', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('website.berita.index');
            }else{
                $this->alert('error', 'Data Pangkalan Gagal di Simpan', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('website.berita.index');
            }
            
    }
}

