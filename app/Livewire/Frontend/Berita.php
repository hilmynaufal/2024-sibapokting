<?php
namespace App\Livewire\Frontend;
use Livewire\Component;
use App\Models\website\RefArticles as Model;
use App\Models\Referensi\RefPasar;
use App\Models\referensi\RefKomoditas;
use App\Models\website\RefBanner;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Storage;
use DB;
use DateTime;
use DateInterval;

class Berita extends Component
{
    use WithPagination,WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $listBannerTop;
    public $listBannerActive;
    public $perpage = 100;
    
    public $komoditas = 89;
    public $list_berita;
    public $first_berita;

    public $date_komoditas;
    public $date_komoditas_before;
    public $kategori=[];

    public $pasar_tabel;
    public $date_start;
    public $date_end;


    #[Layout('components.layouts.keenthemes.frontend.app')]

    public function mount()
    {
        $this->first_berita = Model::where('status','PUBLISED')->orderBy('created_at','asc')->first();
        $this->list_berita = Model::where('status','PUBLISED')->orderBy('created_at','asc')->skip(1)->limit(3)->get();
        // dd($this->list_berita);
    }
    
    public function render()
    {
        $query = Model::query();
        $rows = $query->orderBy('judul','asc')->paginate($this->perpage);
        return view('livewire.frontend.berita', [
          'model'=> $rows
        ]);
    }


}