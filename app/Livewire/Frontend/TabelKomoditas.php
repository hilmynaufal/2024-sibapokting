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
    public $start;
    public $end;


    #[Layout('components.layouts.keenthemes.frontend.app')]

    public function mount()
    {
        $dt = new \Carbon\Carbon(now());
        $tanggal = $dt->format('Y-m-d');
        $this->start = date('Y-m-d',strtotime($tanggal . "-1 days"));
        $this->end = $tanggal;

        $this->list_komoditas_search = RefKomoditas::get();
        $this->list_pasar = RefPasar::orderBy('id','asc')->get();


        foreach($this->list_pasar as $pasar){
            array_push($this->kategori,$pasar->namapasar);
        }

    }
    
    public function render()
    {
        $pasar = $this->pasar_tabel;
        $tgl_start = $this->start;      
        $tgl_end = $this->end;

        $baseQuery = DB::table("t_siba_komoditas")
            ->select(
                DB::raw("komoditas_id"),
                DB::raw("namakomoditas"),
                DB::raw('AVG(harga_publish) as total'),
                DB::raw('AVG(harga_dinamik) as total_kemaren')
            )
            ->join('ref_siba_komoditas', 'ref_siba_komoditas.id', '=', 't_siba_komoditas.komoditas_id');

        if ($pasar == '') {
            $show = clone $baseQuery;
            $show->where('detail_tgl', $tgl_start)
                ->groupBy('t_siba_komoditas.komoditas_id', 'namakomoditas')
                ->orderBy('namakomoditas', 'asc');
            $show1 = clone $baseQuery;
            $show1->where('detail_tgl', $tgl_end)
                ->groupBy('t_siba_komoditas.komoditas_id', 'namakomoditas')
                ->orderBy('namakomoditas', 'asc');
        } else {
            $show = clone $baseQuery;
            $show->where('pasar_id', $pasar)
                ->where('detail_tgl', $tgl_start)
                ->groupBy('t_siba_komoditas.komoditas_id', 'namakomoditas', 'kondisi')
                ->orderBy('namakomoditas', 'asc');
            $show1 = clone $baseQuery;
            $show1->where('pasar_id', $pasar)
                ->where('detail_tgl', $tgl_end)
                ->groupBy('t_siba_komoditas.komoditas_id', 'namakomoditas', 'kondisi')
                ->orderBy('namakomoditas', 'asc');
        }

        $show = $show->get();
        $show1 = $show1->get();

        $data = [];
        foreach ($show as $i) {
            $k = $show1->where('komoditas_id', $i->komoditas_id)->first();

            if ($k) {
                if ($i->total > $k->total) {
                    $kondisi = 'turun';
                } else if ($i->total < $k->total) {
                    $kondisi = 'naik';
                } else {
                    $kondisi = 'stabil';
                }

                $persen = $i->total != 0 ? abs(($k->total - $i->total) / $i->total * 100) : 0;
                $harga_sekarang_conversi = empty($k->total) ? 0 : $k->total;
                $harga_sebelum_conversi = empty($i->total) ? 0 : $i->total;

                $data[] = [
                    'nama' => ucfirst(strtolower($i->namakomoditas)),
                    'price_end' => 'Rp ' . number_format($harga_sekarang_conversi, 0, ',', '.'),
                    'price_start' => 'Rp ' . number_format($harga_sebelum_conversi, 0, ',', '.'),
                    'persen' => round($persen, 2) . '%',
                    'kondisi' => $kondisi
                ];
            }
        }
        return view('livewire.frontend.tabel-komoditas', [
            'model'=> $data
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


}