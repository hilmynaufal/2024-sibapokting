<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use App\Models\transaksi\Komoditas as Model;
use App\Models\Referensi\RefPasar;
use App\Models\referensi\RefKomoditas;
use DB;
use DateTime;
use DatePeriod;
use DateInterval;

class ChartController extends Controller
{
    public $chart2022 = array();
    public $chart2023 = array();
    public $chart2024 = array();

    public $barNow = array();
    public $barBefore = array();

    public $priceList = array();
    public $dateList = array();

    public function dataChart(Request $request){
        $chartData = [];
        $years = [2022, 2023, 2024];
        $komoditas = RefKomoditas::where('id',$request->komoditas)->first();
        $het = $komoditas->het;

        foreach ($years as $year) {
            $komData = Model::select(
                DB::raw("pasar_id"),
                DB::raw("komoditas_id"),
                DB::raw("AVG(harga_publish) as data"),
                DB::raw("to_char(CAST(detail_tgl AS timestamp), 'mm') as bulan")
            )
            ->whereYear(DB::raw("CAST(detail_tgl AS timestamp)"), '=', $year)
            ->where('pasar_id', $request->pasar)
            ->where('komoditas_id', $request->komoditas)
            ->groupBy(DB::raw("to_char(CAST(detail_tgl AS timestamp), 'mm')"), 'pasar_id', 'komoditas_id')
            ->orderBy(DB::raw("to_char(CAST(detail_tgl AS timestamp), 'mm')"), 'asc')
            ->get();
            
            $chartYear = [];
            foreach ($komData as $val) {
                array_push($chartYear, round($val->data));
            }

            $chartData['data' . substr($year, -2)] = $chartYear;
        }
        $chartData['het'] = array_fill(0, count($chartData['data24']), $het);
        return response()->json($chartData);
    }

    public function komoditasBar(Request $request){
        $date = \Carbon\Carbon::createFromFormat('Y-m-d', $request->date);
        $date_before = date('Y-m-d',strtotime($date . "-1 days"));

        $pasar_id = RefPasar::orderBy('id','asc')->pluck('id');
        $nowPrices = Model::whereIn('pasar_id', $pasar_id)
            ->where('detail_tgl', $request->date)
            ->where('komoditas_id', $request->komoditas)
            ->get()
            ->keyBy('pasar_id');

        $beforePrices = Model::whereIn('pasar_id', $pasar_id)
            ->where('detail_tgl', $date_before)
            ->where('komoditas_id', $request->komoditas)
            ->get()
            ->keyBy('pasar_id');

        $barNow = [];
        $barBefore = [];

        foreach ($pasar_id as $id) {
            $harga = $nowPrices[$id]->harga_publish ?? 0;
            $harga_sebelumnya = $beforePrices[$id]->harga_publish ?? 0;

            array_push($barNow, round($harga));
            array_push($barBefore, round($harga_sebelumnya));
        }

        return response()->json([
            'price_now' => $barNow,
            'price_before' => $barBefore
        ]);
    }

    public function komoditasLine(Request $request){
        $dt = new \Carbon\Carbon($request->date);
        $end_date = $dt->format('Y-m-d');
        $date = date('Y-m-d',strtotime($end_date . "-20 days"));
        while (strtotime($date) <= strtotime($end_date)) {
            array_push($this->dateList,TglIndoBulan($date));
            array_push($this->priceList,avgHarga($request->komoditas,0,$date));
            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
        }

        return response()->json([
            'categori' => $this->dateList,
            'price_before' => $this->priceList
        ]);

    }

    public function chartPasarStatistik(Request $request)
    {
        $komoditas  = $request->komoditas;
        $tgl_start = $request->tgl_start;      
        $tgl_end = $request->tgl_end; 
        $show = Model::with('toPasar')->whereBetween('detail_tgl', [$tgl_start, $tgl_end])
        ->where('komoditas_id', $komoditas)
        ->get();
        
        $date = Model::select(
                    DB::raw("detail_tgl")
                )
        ->whereBetween('detail_tgl', [$tgl_start, $tgl_end])
        ->where('komoditas_id', $komoditas)
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
                ->where('komoditas_id', $komoditas)
                ->where('pasar_id', $s->toPasar->id)
                ->orderBy('detail_tgl', 'asc')
                ->get();

            foreach ($dataPasar as $dp) {
                $by_date[] = [
                    'date' => $dp->detail_tgl,
                    'prices' => $dp->harga_publish,
                    'geomean' => $dp->harga_publish
                ];
            }

            $data[$s->toPasar->id] = [ // Gunakan pasar_id sebagai kunci untuk data pasar yang unik
                'name' => $s->toPasar->namapasar,
                'by_date' => $by_date
            ];
        }

        // Ubah array $data dari asosiatif menjadi numerik
        $data = array_values($data);
        
        return response()->json([
            'success' => 'true',
            'meta' => [
                'date' => $list_date,
                'date_str' => $list_date_str,
                'date_count' => $count
            ],
            'data' => $data
        ]);
        
    }
}