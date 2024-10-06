<?php
namespace App\Livewire\Frontend;
use Livewire\Component;
use App\Models\Website\RefArticles as Model;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class Berita extends Component
{
    use WithPagination,WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $perpage = 6;
    public $list_berita;
    public $first_berita;


    #[Layout('components.layouts.keenthemes.frontend.app')]

    public function mount()
    {
        $this->first_berita = Model::where('status','PUBLISED')->where('kategori',1)->orderBy('created_at','asc')->first();
        $this->list_berita = Model::where('status','PUBLISED')->where('kategori',1)->orderBy('created_at','asc')->skip(1)->limit(3)->get();
    }
    
    public function render()
    {
        $query = Model::query();
        $rows = $query->where('status','PUBLISED')->where('kategori',1)->orderBy('created_at','asc')->skip(4)->paginate($this->perpage);
        return view('livewire.frontend.berita', [
          'model'=> $rows
        ]);
    }


}