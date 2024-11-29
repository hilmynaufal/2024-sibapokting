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
    public $cek_komoditas;
    

    public function mount(){
        
        $dt = new \Carbon\Carbon(now());
        $tanggal = $dt->format('Y-m-d');
        $this->date = $tanggal;
        $this->date_before = date('Y-m-d',strtotime($tanggal . "-1 days"));

        $pasar = RefPasar::get();
        $cekkomoditas = [];

        // Hitung jumlah total komoditas
        $totalKomoditas = RefKomoditas::count();

        // Ambil tanggal tertentu
        $tanggal = $this->date; // Ganti dengan tanggal yang relevan

        // Iterasi setiap pasar untuk memeriksa input komoditas
        foreach ($pasar as $p) {
            // Hitung jumlah komoditas yang sudah diinputkan oleh pasar pada tanggal tertentu
            $komoditasInput = Komoditas::where('pasar_id', $p->id)
                                    ->whereDate('tanggal', $tanggal)
                                    ->count();
            
            // Hitung persentase komoditas yang diinputkan
            $persentaseInput = ($komoditasInput / $totalKomoditas) * 100;
            
            // Cek apakah persentase input kurang dari atau sama dengan 75%
            if ($persentaseInput <= 75) {
                $cekkomoditas[] = [
                    'pasar_id' => $p->id,
                    'pasar_name' => $p->namapasar, // Ganti dengan atribut nama pasar yang sesuai
                    'komoditas_input' => $komoditasInput,
                    'persentase_input' => $persentaseInput,
                    'total_komoditas' => $totalKomoditas,
                ];
            }
        }

        // Tampilkan pasar yang belum menginputkan data lebih dari 50%
        $this->cek_komoditas = $cekkomoditas;

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
                            ->where('detail_tgl', $this->date) // Menampilkan hanya harga yang turun pada tanggal tertentu
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
                            ->where('detail_tgl', $this->date) // Menampilkan hanya harga yang turun pada tanggal tertentu
                            ->groupBy('komoditas_id')
                            ->having(DB::raw('AVG(harga_publish)'), '>', DB::raw('(AVG(harga_publish) - AVG(harga_dinamik))')) // Memastikan hanya komoditas yang mengalami penurunan harga
                            ->orderBy('persentase_turun', 'asc')
                            ->limit(3)
                            ->get();
        

    }

    public function render()
    {
        return view('livewire.dashboard.index');
    }
}
