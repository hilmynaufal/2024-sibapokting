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

class ChartController extends Controller
{
    public $chart2022 = array();
    public $chart2023 = array();
    public $chart2024 = array();

    public $barNow = array();
    public $barBefore = array();


    public function dataChart(Request $request){
        $kom2022 = Model::select(
            DB::raw("pasar_id"),
            DB::raw("komoditas_id"),
            DB::raw("AVG(harga_publish) as data"),
            DB::raw("to_char(detail_tgl, 'mm') as bulan"))
        ->whereYear('detail_tgl', '=', 2022)
        ->where('pasar_id',$request->pasar)
        ->where('komoditas_id',$request->komoditas)
        ->groupBy(DB::raw("to_char(detail_tgl, 'mm')"),'pasar_id','komoditas_id')
        ->orderBy(DB::raw("to_char(detail_tgl, 'mm')"),'asc')
        ->get();
        foreach($kom2022 as $val){
            array_push($this->chart2022, round($val->data));
        }

        $kom2023 = Model::select(
            DB::raw("pasar_id"),
            DB::raw("komoditas_id"),
            DB::raw("AVG(harga_publish) as data"),
            DB::raw("to_char(detail_tgl, 'mm') as bulan"))
        ->whereYear('detail_tgl', '=', 2023)
        ->where('pasar_id',$request->pasar)
        ->where('komoditas_id',$request->komoditas)
        ->groupBy(DB::raw("to_char(detail_tgl, 'mm')"),'pasar_id','komoditas_id')
        ->orderBy(DB::raw("to_char(detail_tgl, 'mm')"),'asc')
        ->get();
        foreach($kom2023 as $val){
            array_push($this->chart2023, round($val->data));
        }

        $kom2024 = Model::select(
            DB::raw("pasar_id"),
            DB::raw("komoditas_id"),
            DB::raw("AVG(harga_publish) as data"),
            DB::raw("to_char(detail_tgl, 'mm') as bulan"))
        ->whereYear('detail_tgl', '=', 2024)
        ->where('pasar_id',$request->pasar)
        ->where('komoditas_id',$request->komoditas)
        ->groupBy(DB::raw("to_char(detail_tgl, 'mm')"),'pasar_id','komoditas_id')
        ->orderBy(DB::raw("to_char(detail_tgl, 'mm')"),'asc')
        ->get();
        foreach($kom2024 as $val){
            array_push($this->chart2024, round($val->data));
        }

        return response()->json([
            'data22' => $this->chart2022,
            'data23' => $this->chart2023,
            'data24' => $this->chart2024,
        ]);
    }

    public function komoditasBar(Request $request){

        $dt = new \Carbon\Carbon($request->date);
        $tanggal = $dt->format('Y-m-d');
        $date_before = date('Y-m-d',strtotime($tanggal . "-1 days"));


        $pasar_id = RefPasar::orderBy('id','asc')->get();
        foreach($pasar_id as $valPasar){
            $now = Model::where('detail_tgl',$request->date)
            ->where('komoditas_id',$request->komoditas)
            ->where('pasar_id',$valPasar['id'])
            ->first();

            $before = Model::where('detail_tgl',$date_before)
            ->where('komoditas_id',$request->komoditas)
            ->where('pasar_id',$valPasar['id'])
            ->first();

            $harga = empty($now->harga_publish) ? 0 : $now->harga_publish;
            $harga_sebelumnya = empty($before->harga_publish) ? 0 : $before->harga_publish;

            array_push($this->barNow, round($harga));
            array_push($this->barBefore, round($harga_sebelumnya));
        }

        return response()->json([
            'price_now' => $this->barNow,
            'price_before' => $this->barBefore
        ]);
    }
}