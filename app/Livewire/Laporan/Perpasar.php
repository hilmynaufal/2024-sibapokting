<?php

namespace App\Livewire\Laporan;

use App\Models\Referensi\RefPasar;
use App\Models\Referensi\RefKomoditas;
use App\Models\Transaksi\Komoditas as Model;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use DB;

class Perpasar extends Component
{
    use WithPagination,WithoutUrlPagination;
    use LivewireAlert;
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

    #[Layout('components.layouts.keenthemes.page')]
    public function mount(){
        $dt = new \Carbon\Carbon(now());
        $tanggal = $dt->format('Y-m-d');
        $this->start = date('Y-m-d',strtotime($tanggal . "-1 days"));
        $this->end = $tanggal;
        $this->pasar_tabel = 100;

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

        if ($pasar == 100) {
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
                    'price_end' =>  $harga_sekarang_conversi,
                    'price_start' =>  $harga_sebelum_conversi,
                    'persen' => round($persen, 2) . '%',
                    'kondisi' => $kondisi
                ];
            }
        }
        return view('livewire.laporan.perpasar', [
          'model'=> $data
        ]);
    }


    public function updatedEnd(){
        $dt = new \Carbon\Carbon($this->end);
        $this->end = $dt->format('Y-m-d');
        $this->start = date('Y-m-d',strtotime($this->end . "-1 days"));;

    }
}
