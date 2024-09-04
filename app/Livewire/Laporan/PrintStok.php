<?php

namespace App\Livewire\Laporan;

use Livewire\Component;
use App\Models\Referensi\RefPasar;
use App\Models\Referensi\RefBarang;
use App\Models\Transaksi\Barang as Model;
use DB;
use Livewire\Attributes\Layout;


class PrintStok extends Component
{    
    public $jsonData,$komoditas,$start,$end;

    #[Layout('components.layouts.keenthemes.frontend.print_no_table_landscape')]
    
    // #[Layout('components.layouts.keenthemes.frontend.print_no_table')]
    public function mount($start,$end){
        $this->start = $start;
        $this->end = $end;
    }
    public function render()
    {
        $tgl_start = $this->start;
        $tgl_end = $this->end;

        $show = Model::with('toPasar')->whereBetween('detail_tgl', [$tgl_start, $tgl_end])
        ->get();

        
        $date = Model::select(
                    DB::raw("detail_tgl")
                )
        ->whereBetween('detail_tgl', [$tgl_start, $tgl_end])
        // ->where('komoditas_id', $komoditas)
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
                ->where('pasar_id', $s->toPasar->id)
                ->orderBy('detail_tgl', 'asc')
                ->get();

            foreach ($dataPasar as $dp) {
                $by_date[] = (object)[
                    'date' => $dp->detail_tgl,
                    'awal' => $dp->stok_awal,
                    'masuk' => $dp->stok_masuk,
                    'keluar' => $dp->stok_keluar,
                    'akhir' => $dp->stok_akhir
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
        // dd($this->jsonData);

        return view('livewire.laporan.print-stok', [
            'jsonData' => $this->jsonData
        ]);
    }
}
