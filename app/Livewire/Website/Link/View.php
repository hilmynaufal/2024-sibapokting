<?php

namespace App\Livewire\Website\Link;
use Livewire\Component;
use App\Models\Website\RefLink as Model;
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

    public $id_link;
    public $nama;
    public $link;
    public $kategori;
    public $gambar;
    public $gambar_edit;
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
        return view('livewire.website.link.view');
    }
    
    public function mount($id)
    {

        $idLink = Crypt::decrypt($id);
        $model = Model::where('id',$idLink)->first();
        $this->id_link    = $model->id;
        $this->nama        = $model->nama;
        $this->gambar       = $model->gambar;
        $this->link       = $model->link;
        $this->kategori     = $model->kategori;
    }

}

