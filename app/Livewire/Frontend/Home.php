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

class Home extends Component
{
    use WithPagination,WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $listBannerTop;
    public $listBannerActive;
    public $search = '';
    public $date = '';
    public $perpage = 12;
    
    public $komoditas_id = 89;
    public $komoditas_sekarang;
    public $komoditas_kemarin;
    public $list_komoditas;
    public $list_pasar;

    #[Layout('components.layouts.keenthemes.frontend.app')]
    
    public function mount()
    {
        $this->listBannerTop = RefBanner::where('kategori','Header')->orderBy('id','asc')->get();
        $this->listBannerActive = RefBanner::where('kategori','Header')->orderBy('id','asc')->first();  
        
        $dt = new \Carbon\Carbon(now());
        $tanggal = $dt->format('Y-m-d');
        $this->date = $tanggal;
        $this->date_before = date('Y-m-d',strtotime($this->date . "-1 days"));;
        // $this->search = $dt->format('Y-m-d');

        $tanggal_sebelum = date('Y-m-d',strtotime($tanggal . "-1 days"));
        $tanggal_sebelum_1 = date('Y-m-d',strtotime($tanggal_sebelum . "-1 days"));
        $komoditas = Model::with('toKomoditas')->where('detail_tgl',$tanggal)
                    ->where('komoditas_id',$this->komoditas_id)->first();
        if(empty($komoditas)){
            $before_komoditas = Model::with('toKomoditas')->where('detail_tgl',$tanggal_sebelum)
            ->where('komoditas_id',$this->komoditas_id)->first();
            if(empty($before_komoditas->pasar_id)){
                $befores_komoditas = Model::with('toKomoditas')->orderBy('detail_tgl','desc')
                ->where('komoditas_id',$this->komoditas_id)->first();
                $komoditas_sebelum = Model::where('pasar_id',$befores_komoditas->pasar_id)
                ->where('komoditas_id',$befores_komoditas->komoditas_id)
                ->where('detail_tgl',$tanggal_sebelum)->first(); 
            }else{
                $komoditas_sebelum = Model::where('pasar_id',$before_komoditas->pasar_id)
                ->where('komoditas_id',$before_komoditas->komoditas_id)
                ->where('detail_tgl',$tanggal_sebelum)->first();
            }
        }else{  
            $komoditas_sebelum = Model::where('pasar_id',$komoditas->pasar_id)
            ->where('komoditas_id',$komoditas->komoditas_id)
            ->where('detail_tgl',$tanggal_sebelum)->first();
        }

        $this->list_komoditas = RefKomoditas::where('prioritas',1)->limit(9)->get();
        $this->list_pasar = RefPasar::get();

        $this->komoditas_sekarang   = empty($komoditas) ? $before_komoditas : $komoditas;
        $this->komoditas_kemarin    = $komoditas_sebelum;

        $data = Model::count();
        if ($data) {
            $this->id = $data + 1;
        } else {
            $this->id = 1;
        }
    }
    
    public function render()
    {
        $query = RefKomoditas::query();
        // $query->when($this->search != "", function ($q) {
        //     return $q->where('detail_tgl','=', $this->search);
        // });
        $rows = $query->paginate($this->perpage);
        
        return view('livewire.frontend.home', [
          'model'=> $rows
        ]);
    }

    public function setKomoditas($komoditasId){
        $this->komoditas_id = $komoditasId;
        $this->mount();
    }
    
    
    
}