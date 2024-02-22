<?php

namespace App\Livewire\Website\Banner;
use Livewire\Component;
use App\Models\Website\RefBanner as Model;
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

    public $id_banner;
    public $nama;
    public $sumber;
    public $kategori;
    public $deskripsi;
    public $gambar;
    public $created_at;
    public $created_id;
    public $updated_at;
    public $updated_id;
    public $deleted_at;
    public $deleted_id;
    public $token;

    #[Layout('components.layouts.keenthemes.page')]
    public function render()
    {
        return view('livewire.website.banner.view');
    }
    
    public function mount($id)
    {

        $idBanner = Crypt::decrypt($id);
        $model = Model::where('id',$idBanner)->first();
        $this->id_banner    = $model->id;
        $this->nama        = $model->nama;
        $this->deskripsi       = $model->deskripsi;
        $this->gambar       = $model->gambar;
        $this->sumber       = $model->sumber;
        $this->kategori     = $model->kategori;


    }

}

