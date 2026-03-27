<?php

namespace App\Exports;

use App\Models\Referensi\RefPasar;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\DB;

class RekapInputExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public $dateFrom;
    public $dateTo;

    public function __construct($dateFrom, $dateTo)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function view(): View
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

        return view('exports.rekap-input', [
            'tanggals' => $tanggals,
            'pasars'   => $pasars,
            'counts'   => $counts,
            'dateFrom' => $this->dateFrom,
            'dateTo'   => $this->dateTo,
        ]);
    }
}
