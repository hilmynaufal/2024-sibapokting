<?php

namespace App\Livewire\Laporan;

use App\Models\Referensi\RefPasar;
use App\Models\Transaksi\Komoditas as Model;
use Livewire\Attributes\Layout;
use Livewire\Component;
use DB;
use Carbon\Carbon;

class RekapInput extends Component
{
    #[Layout('components.layouts.keenthemes.page')]

    public $dateFrom;
    public $dateTo;

    public function mount()
    {
        $this->dateTo   = Carbon::today()->format('Y-m-d');
        $this->dateFrom = Carbon::today()->subDays(6)->format('Y-m-d');
    }

    public function render()
    {
        // Ambil semua tanggal dalam range yang ada datanya
        $tanggals = DB::table('t_siba_komoditas')
            ->select('detail_tgl')
            ->whereNotNull('detail_tgl')
            ->when($this->dateFrom, fn($q) => $q->where('detail_tgl', '>=', $this->dateFrom))
            ->when($this->dateTo,   fn($q) => $q->where('detail_tgl', '<=', $this->dateTo))
            ->groupBy('detail_tgl')
            ->orderBy('detail_tgl', 'asc')
            ->pluck('detail_tgl')
            ->toArray();

        // Ambil semua pasar
        $pasars = RefPasar::orderBy('namapasar', 'asc')->get();

        // Hitung jumlah data per pasar per tanggal
        $counts = DB::table('t_siba_komoditas')
            ->select('pasar_id', 'detail_tgl', DB::raw('COUNT(*) as jumlah'))
            ->whereIn('detail_tgl', $tanggals)
            ->groupBy('pasar_id', 'detail_tgl')
            ->get()
            ->groupBy('pasar_id');

        return view('livewire.laporan.rekap-input', [
            'tanggals' => $tanggals,
            'pasars'   => $pasars,
            'counts'   => $counts,
        ]);
    }
}
