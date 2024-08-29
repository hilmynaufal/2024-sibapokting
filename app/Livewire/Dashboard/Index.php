<?php

namespace App\Livewire\Dashboard;
use Livewire\Attributes\Layout;
use App\Models\Referensi\RefKomoditas;
use App\Models\Referensi\RefBarang;
use App\Models\Referensi\RefDistributor;
use App\Models\Referensi\RefPasar;
use App\Models\Transaksi\Komoditas;
use Livewire\Component;
use DB;

class Index extends Component
{
    #[Layout('components.layouts.keenthemes.dashboard')] 
    public $komoditas,$stok,$pasar,$distributor;
    public $komoditasTurun;
    public $komoditasNaik;
    public $date;
    public $date_before;
    

    public function mount(){
        $dt = new \Carbon\Carbon(now());
        $tanggal = $dt->format('Y-m-d');
        $this->date = '2024-04-29';
        $this->date_before = date('Y-m-d',strtotime('2024-04-29' . "-1 days"));


        $this->komoditas = RefKomoditas::count();
        $this->stok = RefBarang::count();
        $this->pasar = RefPasar::count();
        $this->distributor = RefDistributor::count();

        $this->komoditasTurun = Komoditas::select(
                                'komoditas_id',
                                DB::raw('AVG(harga_publish) as rata_harga'),
                                DB::raw('AVG(harga_dinamik) as rata_harga_dinamik'),
                                DB::raw('(AVG(harga_publish) / (AVG(harga_publish) - AVG(harga_dinamik))) * 100 as persentase_turun')
                            )
                            ->join('ref_siba_komoditas', 'ref_siba_komoditas.id', '=', 't_siba_komoditas.komoditas_id')
                            ->where('detail_tgl', '2024-04-29') // Menampilkan hanya harga yang turun pada tanggal tertentu
                            ->groupBy('komoditas_id')
                            ->having(DB::raw('AVG(harga_publish)'), '<', DB::raw('(AVG(harga_publish) + AVG(harga_dinamik))')) // Memastikan hanya komoditas yang mengalami penurunan harga
                            ->orderBy('persentase_turun', 'asc')
                            ->limit(3)
                            ->get();

                                
        $this->komoditasNaik = Komoditas::select(
                                'komoditas_id',
                                DB::raw('AVG(harga_publish) as rata_harga'),
                                DB::raw('AVG(harga_dinamik) as rata_harga_dinamik'),
                                DB::raw('((AVG(harga_publish) - AVG(harga_dinamik)) / AVG(harga_publish)) * 100 as persentase_turun')
                            )
                            ->join('ref_siba_komoditas', 'ref_siba_komoditas.id', '=', 't_siba_komoditas.komoditas_id')
                            // ->where('kondisi', 'turun')
                            ->where('detail_tgl', '2024-04-29') // Menampilkan hanya harga yang turun pada tanggal tertentu
                            ->groupBy('komoditas_id')
                            ->having(DB::raw('AVG(harga_publish)'), '>', DB::raw('(AVG(harga_publish) - AVG(harga_dinamik))')) // Memastikan hanya komoditas yang mengalami penurunan harga
                            ->orderBy('persentase_turun', 'asc')
                            ->limit(3)
                            ->get();
        // $this->komoditasTurun = DB::table("t_siba_komoditas")
        // ->select(
        //     DB::raw("komoditas_id"),
        //     DB::raw("namakomoditas"),
        //     DB::raw('AVG(harga_publish) as total'),
        //     DB::raw('AVG(harga_dinamik) as total_kemaren')
        // )
        // ->join('ref_siba_komoditas', 'ref_siba_komoditas.id', '=', 't_siba_komoditas.komoditas_id')
        // ->where('detail_tgl', '2024-04-29')
        // ->groupBy('t_siba_komoditas.komoditas_id', 'namakomoditas')
        // ->orderBy('namakomoditas', 'asc')
        // ->get();
        // dd($this->komoditasTurun);

    }

    public function render()
    {
        return view('livewire.dashboard.index');
    }
}
