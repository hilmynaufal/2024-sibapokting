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

class View extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $id_galeri;
    public $nama;
    public $gambar;
    public $gambar_edit;
    public $kategori;
    public $created_at;
    public $created_id;
    public $updated_at;
    public $updated_id;
    public $deleted_at;
    public $deleted_id;
    public $token;
    public $multi_gambar = [];
    public $kategoriList;

    #[Layout('components.layouts.keenthemes.page')]
    public function render()
    {
        return view('livewire.website.galeri.view');
    }
    
    public function mount($id)
    {
        $idGaleri = Crypt::decrypt($id);
        $model = Model::where('id',$idGaleri)->first();
        $this->id_galeri    = $model->id;
        $this->nama        = $model->nama;
        $this->gambar       = $model->gambar;
        $this->multi_gambar = json_decode($model->multi_gambar);
        $this->kategori     = $model->kategori;
        $this->kategoriList = RefKategori::orderBy('nama','ASC')->get();

    }

}

