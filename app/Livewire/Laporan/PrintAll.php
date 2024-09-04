<?php

namespace App\Livewire\Laporan;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Referensi\RefPasar;
use App\Models\Referensi\RefKomoditas;
use App\Models\Transaksi\Komoditas as Model;

class PrintAll extends Component
{
    public $jsonData,$end;
    #[Layout('components.layouts.keenthemes.frontend.print_no_table_landscape')]

    public function mount($end){
        $this->end = $end;
    }
    public function render()
    {
        $tgl_end = $this->end;

        // Ambil semua data yang diperlukan dalam satu query
        $show = RefKomoditas::orderBy('namakomoditas', 'asc')->get();
        $showPasar = RefPasar::get();

        // Buat array untuk menampung id pasar dan komoditas yang diperlukan
        $pasarIds = $showPasar->pluck('id')->toArray();
        $komoditasIds = $show->pluck('id')->toArray();

        // Mengambil semua data Model dalam satu query
        $modelData = Model::where('detail_tgl', $tgl_end)
            ->whereIn('komoditas_id', $komoditasIds)
            ->whereIn('pasar_id', $pasarIds)
            ->get()
            ->groupBy('pasar_id');

        $data = [];
        $list_pasar = $showPasar->pluck('namapasar')->toArray();
        $total_harga = 0;
        $total_entries = 0;
        $count_input = 0;

        // Mengisi data pasar dan komoditas
        foreach ($showPasar as $s) {
            $by_data = [];
            if (isset($modelData[$s->id])) {
                $count_input++; // Menghitung jumlah pasar yang menginput data
                foreach ($modelData[$s->id] as $dp) {
                    $by_data[] = (object)[
                        'komoditas' => $dp->toKomoditas->namakomoditas,
                        'harga' => $dp->harga_publish
                    ];
                    $total_harga += $dp->harga_publish; // Menambahkan harga untuk rata-rata
                    $total_entries++;
                }
            }

            $data[] = (object)[
                'name' => $s->namapasar,
                'data' => $by_data
            ];
        }

        // Menghitung rata-rata harga jika ada data yang tersedia
        $avg_price = $total_entries > 0 ? $total_harga / $total_entries : 0;

        // Mengatur data untuk dikirim ke view
        $this->jsonData = (object)[
            'success' => 'true',
            'meta' => (object)[
                'pasar' => $list_pasar,
                'komoditas' => $show,
                'date' => '2024-09-02',
                'count_input' => $count_input,
                'avg_price' => $avg_price
            ],
            'data' => $data
        ];

        return view('livewire.laporan.print-all', [
            'jsonData' => $this->jsonData
        ]);
    }
}
