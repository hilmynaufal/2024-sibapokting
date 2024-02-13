<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Hash;

class RefController extends Controller
{
    public function Test(Request $request)
    {
        $Users = DB::table('ref_users')->get();
        
        $UsersToArray = $Users->toArray();
        
        if ($UsersToArray !== []) {
            return response()->json([
                'code' => 200,
                'dataUsers' => $Users
            ], 200);
        } else {
            return response()->json([
                'code' => 201,
                'dataUsers' => 'Tidak ada data user'
            ], 200);
        }
    }
    
    function getJenisDisposisi(Request $request){
        $JenisDisposisi = DB::table('ref_jenis_disposisi')->get();
        
        $JenisDisposisiToArray = $JenisDisposisi->toArray();
        
        if ($JenisDisposisiToArray !== []) {
            return response()->json([
                'code' => 200,
                'jenisDisposisi' => $JenisDisposisi
            ], 200);
        } else {
            return response()->json([
                'code' => 201,
                'message' => 'Tidak ada data jenis disposisi'
            ], 200);
        }
    }
    
    function getJenisSurat(Request $request){
        $JenisSurat = DB::table('ref_jenis_surat')->get();
        
        $JenisSuratToArray = $JenisSurat->toArray();
        
        if ($JenisSuratToArray !== []) {
            return response()->json([
                'code' => 200,
                'jenisSurat' => $JenisSurat
            ], 200);
        } else {
            return response()->json([
                'code' => 201,
                'message' => 'Tidak ada data jenis surat'
            ], 200);
        }
    }
    
    function getSifatSurat(Request $request){
        $SifatSurat = DB::table('ref_sifat_surat')->get();
        
        $SifatSuratToArray = $SifatSurat->toArray();
        
        if ($SifatSuratToArray !== []) {
            return response()->json([
                'code' => 200,
                'sifatSurat' => $SifatSurat
            ], 200);
        } else {
            return response()->json([
                'code' => 201,
                'message' => 'Tidak ada data sifat surat'
            ], 200);
        }
    }
    
    function getPegawai(Request $request){
        
        // $Pegawai = DB::table('ref_users')->get();
        $a = DB::table('ref_users as a')
        ->select('a.id as pegawai_id', 'a.token as pegawai_id_token', 'a.nama as pegawai_nama', 'b.token as jabatan_id_token', 'b.jabatan as jabatan_nama', 'b.kode as jabatan_kode')
        ->leftJoin('ref_jabatan as b', 'a.jabatan_id', '=', 'b.token')
        ->where('b.is_active','=',1)->where('b.is_delete','=',0)->where('b.status_jabatan',1)->where('a.id','!=',$request->user_id)
        ->orderBy('a.nama','asc');
        // ->get();
        
        $b = DB::table('ref_users as a')
        ->select('a.id as pegawai_id', 'a.token as pegawai_id_token', 'a.nama as pegawai_nama', 'b.token as jabatan_id_token', 'b.jabatan as jabatan_nama', 'b.kode as jabatan_kode')
        ->leftJoin('ref_jabatan as b', 'a.jabatan_pembantu_id', '=', 'b.token')
        ->where('b.is_active','=',1)->where('b.is_delete','=',0)->where('b.status_jabatan',1)->where('a.id','!=',$request->user_id)
        ->orderBy('a.nama','asc')
        ->union($a);
        // ->get();
        
        $Pegawai = $b->orderBy('pegawai_nama','ASC')->get();        
        
        $PegawaiToArray = $Pegawai->toArray();
        
        if ($PegawaiToArray !== []) {
            return response()->json([
                'code' => 200,
                'pegawai' => $Pegawai
            ], 200);
        } else {
            return response()->json([
                'code' => 201,
                'message' => 'Tidak ada data pegawai'
            ], 200);
        }
    }
    
    function getUnitKerja(Request $request){
        $UnitKerja = DB::table('ref_unit_kerja')->get();
        
        $UnitKerjaToArray = $UnitKerja->toArray();
        
        if ($UnitKerjaToArray !== []) {
            return response()->json([
                'code' => 200,
                'unitKerja' => $UnitKerja
            ], 200);
        } else {
            return response()->json([
                'code' => 201,
                'message' => 'Tidak ada data sifat surat'
            ], 200);
        }
    }
}
