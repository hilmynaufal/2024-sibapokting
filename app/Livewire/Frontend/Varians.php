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
    public $search = '';
    public $searchPasar = 8;
    public $searchKomoditas = 89;
    public $date = '';
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
       
    }
    
    public function render()
    {
        $query = RefKomoditas::query();
        $rows = $query->paginate($this->perpage);
        
        return view('livewire.frontend.varians', [
          'model'=> $rows
        ]);
    }

}