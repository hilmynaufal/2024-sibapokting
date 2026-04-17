<?php

namespace App\Livewire\Frontend;

use App\Models\Referensi\RefPasar;
use App\Models\Referensi\RefKomoditas;
use App\Models\Transaksi\Komoditas as Model;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use DB;

class Harian extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $end;
    public $jsonData;

    #[Layout('components.layouts.keenthemes.frontend.app')]
    public function mount()
    {
        $dt = new \Carbon\Carbon(now());
        $this->end = $dt->format('Y-m-d');
    }

    public function render()
    {
        $tgl_end = $this->end;

        $show = RefKomoditas::orderBy('namakomoditas', 'asc')->get();
        $showPasar = RefPasar::get();

        $pasarIds = $showPasar->pluck('id')->toArray();
        $komoditasIds = $show->pluck('id')->toArray();

        $modelData = Model::where('detail_tgl', $tgl_end)
            ->whereIn('komoditas_id', $komoditasIds)
            ->whereIn('pasar_id', $pasarIds)
            ->get()
            ->groupBy('pasar_id');

        $data = [];
        $list_pasar = $showPasar->pluck('namapasar')->toArray();

        foreach ($showPasar as $s) {
            $by_data = [];
            if (isset($modelData[$s->id])) {
                foreach ($modelData[$s->id] as $dp) {
                    $by_data[] = (object)[
                        'komoditas' => $dp->toKomoditas->namakomoditas,
                        'harga' => $dp->harga_publish
                    ];
                }
            }

            $data[] = (object)[
                'name' => $s->namapasar,
                'data' => $by_data
            ];
        }

        $this->jsonData = (object)[
            'success' => 'true',
            'meta' => (object)[
                'pasar' => $list_pasar,
                'komoditas' => $show,
            ],
            'data' => $data
        ];

        return view('livewire.frontend.harian', [
            'jsonData' => $this->jsonData
        ]);
    }

    public function updatedEnd()
    {
        $dt = new \Carbon\Carbon($this->end);
        $this->end = $dt->format('Y-m-d');
    }
}
