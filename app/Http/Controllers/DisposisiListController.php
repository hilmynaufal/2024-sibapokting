<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Disposisi as Model;
use App\Models\SuratMasuk;
use App\Models\DisposisiMasuk;
use App\Models\RefJabatan;
use App\Models\User;
use DB;

class DisposisiListController extends Controller
{
    public function index(Request $request)
    {        
        $jenis_disposisi = $request->jenis_disposisi; // 1 = Disposisi Masuk, 2 = Disposisi Keluar
        $jabatan_token = $request->jabatan_token;
        if($jenis_disposisi==1){
            $jenis_disposisi_nama = "Disposisi Masuk";
        }else{
            $jenis_disposisi_nama = "Disposisi Keluar";
        }
        
        $user = User::where('id', $request->create_id)->first();
        $role_id = $user->role_id;
        $user_id = $user->id;
        $jabatan_id = getJabatanCheck($user->id,"ID");
        $satuan_kerja_id = $user->satuan_kerja_id;
        $search = $request->search;
        $offset = $request->offset;
        $limit = $request->limit;
        $sortColoumName = 't_disposisi.created_at';
        $sortDirection = 'ASC';
        if ($role_id == 1) {
            $model = Model::where('is_active', 1)
            // ->where('satuan_kerja_token', $satuan_kerja_id)
            ->where('t_disposisi.tipe', $jenis_disposisi)
            ->whereRaw('LOWER(catatan) like ?', ['%' . strtolower($search) . '%'])
            ->orderBy($sortColoumName, $sortDirection)
            ->skip($offset)
            ->take($limit)
            ->get();
        } elseif ($role_id == 6 || $role_id == 7) {
            $model = Model::select('t_disposisi.*', 't_disposisi_detail.jabatan_penerima_token', 't_disposisi_detail.id as disposisi_id', 't_disposisi_detail.is_read as disposisi_is_read')
            ->leftJoin('t_disposisi_detail', 't_disposisi.id', '=', 't_disposisi_detail.disposisi_id')
            ->where('t_disposisi_detail.jabatan_penerima_id', $user_id)
            ->where('t_disposisi_detail.is_active', 1)
            ->where('t_disposisi.tipe', $jenis_disposisi)
            ->where(DB::raw('LOWER(t_disposisi.disposisi_catatan)'), 'LIKE', '%' . strtolower($search) . '%')
            ->orderBy($sortColoumName, $sortDirection)
            ->skip($offset)
            ->take($limit)
            ->get();
            
        } else {
            if($jenis_disposisi==1){
                // dd($jabatan_id);
                $model = Model::select('t_disposisi.*', 't_disposisi_detail.jabatan_penerima_token', 't_disposisi_detail.id as disposisi_id', 't_disposisi_detail.is_read as disposisi_is_read')
                ->leftJoin('t_disposisi_detail', 't_disposisi.id', '=', 't_disposisi_detail.disposisi_id')
                ->where('t_disposisi_detail.jabatan_penerima_token', $jabatan_token)
                ->where('t_disposisi_detail.is_active', 1)
                ->where('t_disposisi.tipe', $jenis_disposisi)
                ->where(DB::raw('LOWER(t_disposisi.disposisi_catatan)'), 'LIKE', '%' . strtolower($search) . '%')
                ->orderBy($sortColoumName, $sortDirection)
                ->skip($offset)
                ->take($limit)
                ->get();
            }else{
                $model = Model::select('t_disposisi.id', 't_disposisi.surat_id', 't_disposisi.create_id', 't_disposisi.surat_id_token', 't_disposisi.token',
                't_disposisi.tipe', 't_disposisi.disposisi_nomor', 't_disposisi.disposisi_tujuan', 't_disposisi.disposisi_instruksi', 't_disposisi.disposisi_batas_waktu',
                't_disposisi.disposisi_catatan', 't_disposisi.disposisi_id', 't_disposisi.is_active')
                ->join('t_disposisi_detail', 't_disposisi.id', '=', 't_disposisi_detail.disposisi_id')
                ->where('t_disposisi_detail.jabatan_pengirim_token', $jabatan_token)
                // ->where('t_disposisi_detail.is_active', 1)
                // ->where('t_disposisi.tipe', $jenis_disposisi)
                ->where(DB::raw('LOWER(t_disposisi.disposisi_catatan)'), 'LIKE', '%' . strtolower($search) . '%')
                ->groupBy('t_disposisi.id', 't_disposisi.surat_id', 't_disposisi.create_id', 't_disposisi.surat_id_token', 't_disposisi.token',
                't_disposisi.tipe', 't_disposisi.disposisi_nomor', 't_disposisi.disposisi_tujuan', 't_disposisi.disposisi_instruksi', 't_disposisi.disposisi_batas_waktu',
                't_disposisi.disposisi_catatan', 't_disposisi.disposisi_id', 't_disposisi.is_active')
                ->orderBy($sortColoumName, $sortDirection)
                ->skip($offset)
                ->take($limit)
                ->get();
                // ->groupBy('t_disposisi.id');
            }
            
        }
        
        $total = $model->count();
        if ($total > 0) {    
            return response()->json([
                'pageTitle' => $jenis_disposisi_nama,
                'message' => 'List Data '.$jenis_disposisi_nama.' Tersedia', 
                'status' => 200, 
                'total' => $total,
                'data' => $model
            ]);
        } else {
            return response()->json([
                'pageTitle' => $jenis_disposisi_nama,
                'message' => 'List Data '.$jenis_disposisi_nama.' Belum Tersedia', 
                'status' => 500,
                'data' => [],
                'total' => $total
            ], 500);
        }
    }
    
    
    function tracking(Request $request)
    {
        $jenis_disposisi = $request->jenis_disposisi; // 1 = Disposisi Masuk, 2 = Disposisi Keluar
        if($jenis_disposisi==1){
            $jenis_disposisi_nama = "Disposisi Masuk";
        }else{
            $jenis_disposisi_nama = "Disposisi Keluar";
        }
        $model_disposisi = Model::where('surat_id', $request->surat_id)->where('tipe',$jenis_disposisi)->first();
        $model_disposisi_detail = DisposisiMasuk::where('surat_id', $request->surat_id)->where('tipe',$jenis_disposisi)->first();
        return response()->json([
            'pageTitle' => $jenis_disposisi_nama,
            'message' => 'Tracking '.$jenis_disposisi_nama.' Surat ID #'.$model_disposisi->surat_id.' dan Disposisi ID #'.$model_disposisi->id,
            'status' => 200,
            'data_disposisi' => $model_disposisi,
            'data_disposisi_detail' => $model_disposisi_detail
        ],200);
    }
    
}
