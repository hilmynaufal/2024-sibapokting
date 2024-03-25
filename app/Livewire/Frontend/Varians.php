<?php
namespace App\Livewire\Frontend;
use Livewire\Component;
use App\Models\transaksi\Komoditas as Model;
use App\Models\Referensi\RefPasar;
use App\Models\referensi\RefKomoditas;
use App\Models\website\RefBanner;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Storage;
use DB;

class Varians extends Component
{
    use WithPagination,WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $listBannerTop;
    public $listBannerActive;
    public $perpage = 1000;
    
    public $komoditas = 89;
    public $list_komoditas_search;
    public $list_pasar;

    public $date_komoditas;
    public $kategori=[];


    #[Layout('components.layouts.keenthemes.frontend.app')]

    public function mount()
    {
        $dt = new \Carbon\Carbon(now());
        $tanggal = $dt->format('Y-m-d');
        $this->date_komoditas = $tanggal;

        $this->list_komoditas_search = RefKomoditas::get();
        $this->list_pasar = RefPasar::orderBy('id','asc')->get();

        foreach($this->list_pasar as $pasar){
            array_push($this->kategori,$pasar->namapasar);
        }
    }
    
    public function render()
    {
        $query = RefKomoditas::query();
        $rows = $query->orderBy('namakomoditas','asc')->paginate($this->perpage);
        
        return view('livewire.frontend.varians', [
          'model'=> $rows
        ]);
    }


}