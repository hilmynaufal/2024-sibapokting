<?php
namespace App\Livewire\Frontend;
use Livewire\Component;
use App\Models\website\RefGaleri as Model;
use App\Models\Website\RefKategori;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Crypt;

class DetailGaleri extends Component
{
    use WithPagination,WithoutUrlPagination;
    public $id_galeri;
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
    
    #[Layout('components.layouts.keenthemes.frontend.app')]
    public function render()
    {
        return view('livewire.frontend.detail-galeri');
    }
    
    public function mount($id)
    {

        $idGaleri = Crypt::decrypt($id);
        $model = Model::where('id',$idGaleri)->first();
        $this->id_galeri    = $model->id;
        $this->judul        = $model->nama;
        $this->gambar       = $model->gambar;
        $this->multi_gambar = json_decode($model->multi_gambar);
        $this->kategoriList = RefKategori::orderBy('nama','ASC')->get();

    }


}