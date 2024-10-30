<?php
namespace App\Livewire\Frontend;
use Livewire\Component;
use App\Models\Transaksi\Komoditas as Model;
use App\Models\Referensi\RefPasar;
use App\Models\Referensi\RefKomoditas;
use App\Models\Website\RefBanner;
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

class RentangHarga extends Component
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
    public $start;
    public $end;


    #[Layout('components.layouts.keenthemes.frontend.app')]
    public $jsonData;

    public function mount()
    {
        // Contoh data JSON
        $dt = new \Carbon\Carbon(now());
        $tanggal = $dt->format('Y-m-d');
        $this->start = date('Y-m-d',strtotime($tanggal . "-15 days"));
        $this->end = $tanggal;

        $this->list_komoditas_search = RefKomoditas::get();
    }

    public function render()
    {
        $komoditas = $this->komoditas;
        $tgl_start = $this->start;
        $tgl_end = $this->end;

        $show = Model::with('toPasar')->whereBetween('detail_tgl', [$tgl_start, $tgl_end])
        ->where('komoditas_id', $komoditas)
        ->get();
        
        $date = Model::select(
                    DB::raw("detail_tgl")
                )
        ->whereBetween('detail_tgl', [$tgl_start, $tgl_end])
        ->where('komoditas_id', $komoditas)
        ->groupBy('detail_tgl')
        ->get();
        $list_date = [];
        $list_date_str = [];
        $count = 0;

        foreach($date as $d){
            $count = $count + 1;
            array_push($list_date,$d->detail_tgl);
            $dt = new \Carbon\Carbon($d->detail_tgl);
            $new = $dt->format('d/m/Y');
            array_push($list_date_str,$new);
        }
        $data = [];
        foreach ($show as $s) {
            $by_date = []; // Reset variabel $by_date di setiap iterasi loop utama

            $dataPasar = Model::with('toPasar')->whereBetween('detail_tgl', [$tgl_start, $tgl_end])
                ->where('komoditas_id', $komoditas)
                ->where('pasar_id', $s->toPasar->id)
                ->orderBy('detail_tgl', 'asc')
                ->get();

            foreach ($dataPasar as $dp) {
                $by_date[] = (object)[
                    'date' => $dp->detail_tgl,
                    'prices' => $dp->harga_publish,
                    'geomean' => $dp->harga_publish
                ];
            }

            $data[$s->toPasar->id] = (object)[ // Gunakan pasar_id sebagai kunci untuk data pasar yang unik
                'name' => $s->toPasar->namapasar,
                'by_date' => $by_date
            ];
        }

        // Ubah array $data dari asosiatif menjadi numerik
        $data = array_values($data);
        
        $this->jsonData =(object)[
            'success' => 'true',
            'meta' => (object)[
                'date' => $list_date,
                'date_str' => $list_date_str,
                'date_count' => $count
            ],
            'data' => $data
        ];

        return view('livewire.frontend.rentang-harga',[
            'jsonData' => $this->jsonData
        ]);
    }

    public function updatedStart(){
        $dt = new \Carbon\Carbon($this->start);
        $this->start = $dt->format('Y-m-d');
    }

    public function updatedEnd(){
        $dt = new \Carbon\Carbon($this->end);
        $this->end = $dt->format('Y-m-d');
    }

    public function updatedKomoditas(){
        $this->komoditas = $this->komoditas;
    }


}