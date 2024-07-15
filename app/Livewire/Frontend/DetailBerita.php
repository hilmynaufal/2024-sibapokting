<?php
namespace App\Livewire\Frontend;
use Livewire\Component;
use App\Models\website\RefArticles as Model;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Crypt;

class DetailBerita extends Component
{
    use WithPagination,WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $perpage = 6;
    public $list_berita;
    public $first_berita;
    public $detail;


    #[Layout('components.layouts.keenthemes.frontend.app')]

    public function mount($id)
    {
        $idBerita = Crypt::decrypt($id);
        $this->detail = Model::where('id',$idBerita)->where('status','PUBLISED')->orderBy('created_at','asc')->first();
        $jmlHit = $this->detail->hit;
        $this->detail->hit = $jmlHit + 1;
        $this->detail->update();
        $this->list_berita = Model::where('id','!=',$idBerita)->where('status','PUBLISED')->where('kategori',1)->orderBy('created_at','asc')->limit(5)->get();

    }
    
    public function render()
    {
        return view('livewire.frontend.detail-berita');
    }


}