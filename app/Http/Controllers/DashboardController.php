<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\requests;
use Illuminate\Support\Facades\DB;
use Carbon;


class DashboardController extends Controller
{


    public function apiPasar(Request $request)
    {
        if($request->tokenApi == 'Sibapokting123*'){
            $value = array(
                            "status"=>"success",
                            "message"=>"Data retrieved successfully.",
                            "pageTitle"=>"Data Pasar Kabupaten Bandung",
                            "data" => DB::table('ref_siba_pasar')->get()
                        );
        }else{
            $value = array(
                "status"=>"error",
                "message"=>"Token API not active"
            );
        }
        
        return json_encode($value);
        die;
    }

    public function apiKomoditas(Request $request)
    {
        if($request->tokenApi == 'Sibapokting123*'){
            $data = DB::table('ref_siba_komoditas')
                ->select(
                    'ref_siba_komoditas.id',
                    'namakomoditas',
                    'ref_siba_satuan.satuan as satuan',
                    'gambar',
                    'created_at',
                    'created_id',
                    'updated_at',
                    'updated_id',
                    'deleted_at',
                    'deleted_id',
                    'token',
                    'het',
                    'id_silinda',
                    'prioritas'
                )
                ->join('ref_siba_satuan', 'ref_siba_komoditas.satuan', '=', 'ref_siba_satuan.id')
                ->get();

            $value = array(
                "status" => "success",
                "message" => "Data retrieved successfully.",
                "pageTitle" => "Data Komoditas Kabupaten Bandung",
                "data" => $data
            );
        }else{
            $value = array(
                "status"=>"error",
                "message"=>"Token API not active"
            );
        }
        
        return json_encode($value);
    }

    public function apiHargaKomoditas(Request $request)
    {
        if($request->tokenApi != 'Sibapokting123*'){
            $value = array(
                "status"=>"error",
                "message"=>"Token API not active"
            );
            return json_encode($value);
        }

        $avg = DB::table('t_siba_komoditas')
            ->join('ref_siba_komoditas', 'ref_siba_komoditas.id', '=', 't_siba_komoditas.komoditas_id')
            ->join('ref_siba_satuan', 'ref_siba_komoditas.satuan', '=', 'ref_siba_satuan.id')
            ->select(
                't_siba_komoditas.id',
                't_siba_komoditas.komoditas_id',
                't_siba_komoditas.pasar_id',
                't_siba_komoditas.users_id',
                't_siba_komoditas.tanggal',
                't_siba_komoditas.harga_publish',
                't_siba_komoditas.harga_admin',
                't_siba_komoditas.harga_dinamik',
                't_siba_komoditas.kondisi',
                't_siba_komoditas.status',
                't_siba_komoditas.tanggal_update',
                't_siba_komoditas.harga_pasar',
                't_siba_komoditas.detail_tgl',
                'ref_siba_komoditas.namakomoditas',
                'ref_siba_satuan.nama as satuan',
                'ref_siba_komoditas.gambar',
                DB::raw('AVG(t_siba_komoditas.harga_publish::numeric) as total'),
                DB::raw('AVG(t_siba_komoditas.harga_dinamik::numeric) as total_kemaren')
            )
            ->where('t_siba_komoditas.detail_tgl', $request->tanggal);

        $groupByColumns = [
            't_siba_komoditas.id',
            't_siba_komoditas.komoditas_id',
            't_siba_komoditas.pasar_id',
            't_siba_komoditas.users_id',
            't_siba_komoditas.tanggal',
            't_siba_komoditas.harga_publish',
            't_siba_komoditas.harga_admin',
            't_siba_komoditas.harga_dinamik',
            't_siba_komoditas.kondisi',
            't_siba_komoditas.status',
            't_siba_komoditas.tanggal_update',
            't_siba_komoditas.harga_pasar',
            't_siba_komoditas.detail_tgl',
            'ref_siba_komoditas.namakomoditas',
            'ref_siba_satuan.nama',
            'ref_siba_komoditas.gambar'
        ];

        if ($request->pasar != 'semua') {
            $avg->where('t_siba_komoditas.pasar_id', $request->pasar)
                ->groupBy($groupByColumns);
        } else {
            $avg->groupBy($groupByColumns);
        }

        $data['avg'] = $avg->get();

        $value = array(
            "status"=>"success",
            "message"=>"Data retrieved successfully.",
            "pageTitle"=>"Data Harga Komoditas Kabupaten Bandung",
            "data" => $data
        );

        return json_encode($value);
    }

}
