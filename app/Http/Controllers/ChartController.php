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
        $pasar  = $request->pasar;
        $tgl_start = $request->tgl_start;      
        $tgl_end = $request->tgl_end;      

        if ($pasar == '') {
            $namapasar = '';
                $show = DB::table("t_siba_komoditas")
                ->select(
                    DB::raw("komoditas_id"),
                    DB::raw("namakomoditas"),
                    DB::raw('AVG(harga_publish) as total'),
                    DB::raw('AVG(harga_dinamik) as total_kemaren')
                )
                ->join('ref_siba_komoditas', 'ref_siba_komoditas.id', '=', 't_siba_komoditas.komoditas_id')
                ->where('detail_tgl', $tgl_start)
                ->groupBy('t_siba_komoditas.komoditas_id','namakomoditas')
                ->orderBy('namakomoditas','asc')
                ->get();

                $show1 = DB::table("t_siba_komoditas")
                ->select(
                    DB::raw("komoditas_id"),
                    DB::raw("namakomoditas"),
                    DB::raw('AVG(harga_publish) as total'),
                    DB::raw('AVG(harga_dinamik) as total_kemaren')
                )
                ->join('ref_siba_komoditas', 'ref_siba_komoditas.id', '=', 't_siba_komoditas.komoditas_id')
                ->where('detail_tgl', $tgl_end)
                ->groupBy('t_siba_komoditas.komoditas_id','namakomoditas')
                ->orderBy('namakomoditas','asc')
                ->get();
                
        } else {
            // $namapasar = $pasar;
            $show = DB::table("t_siba_komoditas")
            ->select(
                DB::raw("komoditas_id"),
                DB::raw("kondisi"),
                DB::raw("namakomoditas"),
                DB::raw('AVG(harga_publish) as total'),
                DB::raw('AVG(harga_dinamik) as total_kemaren')
            )
            ->join('ref_siba_komoditas', 'ref_siba_komoditas.id', '=', 't_siba_komoditas.komoditas_id')
            ->where('pasar_id', $pasar)
            ->where('detail_tgl', $tgl_start)
            ->groupBy('t_siba_komoditas.komoditas_id','namakomoditas','kondisi')
            ->orderBy('namakomoditas','asc')
            ->get();

            $show1 = DB::table("t_siba_komoditas")
            ->select(
                DB::raw("komoditas_id"),
                DB::raw("kondisi"),
                DB::raw("namakomoditas"),
                DB::raw('AVG(harga_publish) as total'),
                DB::raw('AVG(harga_dinamik) as total_kemaren')
            )
            ->join('ref_siba_komoditas', 'ref_siba_komoditas.id', '=', 't_siba_komoditas.komoditas_id')
            ->where('pasar_id', $pasar)
            ->where('detail_tgl', $tgl_end)
            ->groupBy('t_siba_komoditas.komoditas_id','namakomoditas','kondisi')
            ->orderBy('namakomoditas','asc')
            ->get();
        }

        $data = [];
        $kondisi ="";
        $persen ="";
        $harga_sebelum ="";
        foreach ($show as $i) {
            foreach($show1 as $k){
                if($i->komoditas_id == $k->komoditas_id){
                    if($i->total > $k->total){
                        $kondisi = 'naik';
                        $persen = (($i->total-$k->total)/$i->total*100);
                        $harga_sekarang = $k->total;
                        $harga_sebelum = $i->total;
                    }else if($i->total < $k->total){
                        $kondisi = 'turun';
                        $persen = (($k->total-$i->total)/$i->total*100);
                        $harga_sekarang = $k->total;
                        $harga_sebelum = $i->total;
                    }else{
                        $kondisi = 'stabil';
                        $persen = 0;
                        $harga_sekarang = $k->total;
                        $harga_sebelum = $i->total;
                        
                    }
                }
                
            }
                                                       

            $data[] =[
                'id'=>ucfirst(strtolower($i->namakomoditas)), 
                'price_start'=>'Rp '.number_format($harga_sekarang,0,',','.'), 
                'price_end'=>'Rp '.number_format($harga_sebelum,0,',','.') ,
                'persen'=>round(ltrim($persen,'-'), 2).'%' ,
                'kondisi'=>$kondisi];
        }
        return  json_encode(["data" => $data]);

    }
}