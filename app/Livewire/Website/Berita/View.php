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

class View extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $id_berita;
    public $judul;
    public $slug;
    public $tanggal;
    public $konten;
    public $gambar;
    public $gambar_edit;
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
    public $multi_gambar_edit = [];
    public $images = [];
    public $kategoriList;

    #[Layout('components.layouts.keenthemes.page')]
    public function render()
    {
        return view('livewire.website.berita.view');
    }
    
    public function mount($id)
    {

        $idBerita = Crypt::decrypt($id);
        $model = Model::where('id',$idBerita)->first();
        $this->id_berita    = $model->id;
        $this->judul        = $model->judul;
        $this->konten       = $model->konten;
        $this->gambar       = $model->gambar;
        $this->multi_gambar = json_decode($model->multi_gambar);
        $this->sumber       = $model->sumber;
        $this->kategori     = $model->kategori;
        $this->kategoriList = RefKategori::orderBy('nama','ASC')->get();

    }

}

