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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Storage;
use DB;

class TabelKomoditas extends Component
{
    use WithPagination,WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $listBannerTop;
    public $listBannerActive;
    public $perpage = 100;
    
    public $komoditas = 89;
    public $list_komoditas_search;
    public $list_pasar;

    public $kategori=[];
    public $pasar_tabel;
    public $date_start;
    public $date_end;


    #[Layout('components.layouts.keenthemes.frontend.app')]

    public function mount()
    {
        $dt = new \Carbon\Carbon(now());
        $tanggal = $dt->format('Y-m-d');
        $this->date_start = date('Y-m-d',strtotime($tanggal . "-1 days"));
        $this->date_end = $tanggal;

        $this->list_komoditas_search = RefKomoditas::get();
        $this->list_pasar = RefPasar::orderBy('id','asc')->get();


        foreach($this->list_pasar as $pasar){
            array_push($this->kategori,$pasar->namapasar);
        }
    }
    
    public function render()
    {
        return view('livewire.frontend.tabel-komoditas');
    }


}