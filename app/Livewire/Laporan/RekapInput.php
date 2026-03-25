<?php

namespace App\Livewire\Laporan;

use App\Models\Referensi\RefPasar;
use App\Models\Transaksi\Komoditas as Model;
use Livewire\Attributes\Layout;
use Livewire\Component;
use DB;

class RekapInput extends Component
{
    #[Layout('components.layouts.keenthemes.page')]
    public function mount()
    {
        //
    }

    public function render()
    {
        // Ambil 5 tanggal terbaru yang ada datanya
        $tanggals = DB::table('t_siba_komoditas')
            ->select('detail_tgl')
            ->whereNotNull('detail_tgl')
            ->groupBy('detail_tgl')
            ->orderBy('detail_tgl', 'desc')
            ->limit(5)
            ->pluck('detail_tgl')
            ->toArray();

        // Urutkan dari yang terlama ke terbaru untuk ditampilkan kiri ke kanan
        $tanggals = array_reverse($tanggals);

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
