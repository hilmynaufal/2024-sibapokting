<?php
namespace App\Livewire\Frontend;
use Livewire\Component;
use App\Models\transaksi\Komoditas as Model;
use App\Models\Referensi\RefPasar;
use App\Models\referensi\RefKomoditas;
use App\Models\RefSetting;
use App\Models\website\RefBanner;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Storage;
use DB;

class Home extends Component
{
    use WithPagination,WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $listBannerTop;
    public $listBannerActive;
    public $search = '';
    public $searchPasar = 8;
    public $searchKomoditas = 89;
    public $date;
    public $date_before;
    public $perpage = 12;
    
    public $komoditas_id = 89;
    public $komoditas_sekarang;
    public $komoditas_kemarin;
    public $list_komoditas;
    public $list_komoditas_search;
    public $list_pasar;

    public $chart2023 = array();
    public $chart2024 = array();

    #[Layout('components.layouts.keenthemes.frontend.app')]

    public function mount()
    {
        $this->listBannerTop = RefBanner::where('kategori','Header')->orderBy('id','asc')->get();
        $this->listBannerActive = RefBanner::where('kategori','Header')->orderBy('id','asc')->first();  
        
        $dt = new \Carbon\Carbon(now());
        $tanggal = $dt->format('Y-m-d');
        $this->date = $tanggal;
        $this->date_before = date('Y-m-d',strtotime($tanggal . "-1 days"));

        $this->list_pasar = RefPasar::get();
        $this->list_komoditas_search = RefKomoditas::get();

    }
    
    public function render(){
        $visitor = RefSetting::find(1);
        if($visitor){
            $visitor->visit()->withIP()->withSession()->withUser();
        }
        $query = RefKomoditas::query();
        $rows = $query->paginate($this->perpage);
        
        return view('livewire.frontend.home', [
          'model'=> $rows
        ]);
    }

    public function setKomoditas($komoditasId){
        $this->komoditas_id = $komoditasId;
        $this->mount();
    }

    public function updatedDate(){
        $dt = new \Carbon\Carbon($this->date);
        $tanggal = $dt->format('Y-m-d');
            
        $this->date_before = date('Y-m-d',strtotime($tanggal . "-1 days"));
    }

    public function show(RefSetting $visitor){
        $visitor->visit()->withIP()->withSession()->withUser();
    }
    
    
}