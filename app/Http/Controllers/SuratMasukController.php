<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\SuratMasuk as Model;
use App\Models\User;
use App\Models\Verifikasi;
use App\Models\DisposisiMasuk;
use DB;
use Storage;
use Illuminate\Support\Collection;
class SuratMasukController extends Controller
{
    function create(Request $request)
    {
        $judul_surat_keuangan = array(
            "Permohonan Pinjaman Usaha untuk PT ABC Finance",
            "Konfirmasi Pembayaran Tagihan kepada PT XYZ Electronics",
            "Pemberitahuan Kenaikan Gaji Karyawan di PT LMN Manufacturing",
            "Laporan Keuangan Tahunan dari PT PQR Holdings",
            "Permintaan Penundaan Pembayaran kepada PT MNO Suppliers",
            "Nota Debit atas Keterlambatan Pembayaran dari PT RST Services",
            "Surat Peringatan terkait Utang kepada PT UVW Contractors",
            "Pemberitahuan Perubahan Tarif Harga untuk Produk PT EFG Pharmaceuticals",
            "Permintaan Keringanan Pajak untuk PT GHI Investments",
            "Pemberitahuan Pensiun Dana Pensiun untuk Karyawan PT JKL Corporation"
        );
        // Memilih judul surat secara acak
        $judul_surat_acak = $judul_surat_keuangan[array_rand($judul_surat_keuangan)];
        
        $judul_nama_perusahaan = array(
            "PT ABC Finance",
            "PT XYZ Electronics",
            "PT LMN Manufacturing",
            "PT PQR Holdings",
            "PT MNO Suppliers",
            "PT RST Services",
            "PT UVW Contractors",
            "PT EFG Pharmaceuticals",
            "PT GHI Investments",
            "PT JKL Corporation"
        );
        // Memisahkan nama perusahaan dari judul surat
        $nama_perusahaan = $judul_nama_perusahaan[array_rand($judul_nama_perusahaan)];
        // Membuat contoh nomor surat
        $nomor_surat = "SURAT/" . date("Y") . "/" . strtoupper(substr($nama_perusahaan, 0, 3)) . "/" . rand(100, 999);
        
        
        $model = new Model();
        $model->id = Model::max('id') + 1;   
        // $model = new Model();
        $model->create_id = $request->create_id;
        $model->tgl_terima = $request->tgl_terima;
        $model->tgl_surat = $request->tgl_surat;
        
        $pembuat_surat = User::where('id',$request->create_id)->first();
        $model->pembuat_surat_id = $pembuat_surat->id;
        $model->pembuat_surat_token = $pembuat_surat->jabatan_id;
        $model->satuan_kerja_token = $pembuat_surat->satuan_kerja_id;
        
        $sekretaris = User::where('id',$request->sekretaris_surat_id)->first();
        $model->sekretaris_surat_id = $sekretaris->id;
        $model->sekretaris_surat_token = $sekretaris->jabatan_id;
        
        $tujuan = User::where('id',$request->tujuan_surat_id)->first();
        $model->tujuan_surat_id = $tujuan->id;
        $model->tujuan_surat_token = $tujuan->jabatan_id;
        
        $model->no_arsip = $request->no_arsip == NULL ? generateArsipMasukNumber($tujuan->id) : $request->no_arsip;
        $model->no_surat = $request->no_surat == NULL ? $nomor_surat : $request->no_surat;
        $model->alamat = $request->alamat_pengirim;
        
        $model->perihal_surat = $request->perihal_surat == NULL ? $judul_surat_acak : $request->perihal_surat;
        $model->isi_surat = $request->isi_surat;
        $model->keterangan_surat = $request->keterangan_surat;
        $model->pengirim_surat = $request->pengirim_surat == NULL ? $nama_perusahaan : $request->pengirim_surat; 
        $model->is_active       = 1;
        $model->is_delete       = 0;
        $model->is_read         = 0;
        
        if ($model->save()) {
            // Berhasil
            setVerifikasi($model->create_id,$model->token,$model->pembuat_surat_id,$model->pembuat_surat_token,"Entry Surat Masuk",1,1);
            setVerifikasi($model->create_id,$model->token,$model->sekretaris_surat_id,$model->sekretaris_surat_token,"Review & Forward ke Tujuan Surat Masuk",0,1);
            setVerifikasi($model->create_id,$model->token,$model->tujuan_surat_id,$model->tujuan_surat_token,"Tujuan Penerima Surat Masuk",0,1);
            
            // Reset input atau apa pun yang diperlukan
            $data_verifikasi = Verifikasi::where('surat_id', $model->id)->get();
            return response()->json([
                'pageTitle' => 'Surat Masuk',
                'message' => 'Surat Masuk Berhasil di Simpan',
                'status' => 200,
                'data' => $model,
                'data_verifikasi' => $data_verifikasi
            ], 200);
            
        } else {
            // Gagal
            return response()->json([
                'pageTitle' => 'Surat Masuk',
                'message' => 'Surat Masuk Gagal di Simpan',
                'status' => 500,
                'data' => $model
            ], 500);
        }
    }
    
    function tracking(Request $request)
    {
        $model = Verifikasi::where('surat_id', $request->surat_masuk_id)->get();
        $model_disposisi = Disposisi::where('surat_id', $request->surat_masuk_id)->first();
        $model_disposisi_detail = DisposisiMasuk::where('surat_id', $request->surat_masuk_id)->get();
        return response()->json([
            'pageTitle' => 'Surat Masuk',
            'message' => 'Tracking Surat Masuk dengan ID #'.$request->surat_masuk_id,
            'status' => 200,
            'data_verifikasi' => $model,
            'data_disposisi' => $model_disposisi,
            'data_disposisi_detail' => $model_disposisi_detail
        ],200);
    }
    
    public function index(Request $request)
    {        
        $user = User::where('id', $request->create_id)->first();
        $role_id = $user->role_id;
        $user_id = $user->id;
        $jabatan_id = getJabatanCheck($user->id,"ID");
        $satuan_kerja_id = $user->satuan_kerja_id;
        $search = $request->search;
        $offset = $request->offset;
        $limit = $request->limit;
        $sortColoumName = 't_surat_masuk.created_at';
        $sortDirection = 'ASC';
        if ($role_id == 1) {
            $model = Model::where('is_delete', 0)
            ->where('satuan_kerja_token', $satuan_kerja_id)
            ->whereRaw('LOWER(perihal_surat) like ?', ['%' . strtolower($search) . '%'])
            ->orderBy($sortColoumName, $sortDirection)
            ->skip($offset)
            ->take($limit)
            ->get();
        } elseif ($role_id == 6 || $role_id == 7) {
            $model = Model::select('t_surat_masuk.*', 't_verifikasi.jabatan_penerima_token', 't_verifikasi.id as verifikasi_id', 't_verifikasi.is_read as verifikasi_is_read')
            ->leftJoin('t_verifikasi', 't_surat_masuk.id', '=', 't_verifikasi.surat_id')
            ->where('t_surat_masuk.pembuat_surat_id', $user->id)
            ->where('t_verifikasi.jabatan_penerima_token', $jabatan_id)
            ->where('t_surat_masuk.satuan_kerja_token', $satuan_kerja_id)
            ->where('t_surat_masuk.is_delete', 0)
            ->where(DB::raw('LOWER(t_surat_masuk.perihal_surat)'), 'LIKE', '%' . strtolower($search) . '%')
            ->orderBy($sortColoumName, $sortDirection)
            ->skip($offset)
            ->take($limit)
            ->get();
        } else {
            $model = Model::select('t_surat_masuk.*', 't_verifikasi.jabatan_penerima_token', 't_verifikasi.id as verifikasi_id', 't_verifikasi.is_read as verifikasi_is_read')
            ->leftJoin('t_verifikasi', 't_surat_masuk.id', '=', 't_verifikasi.surat_id')
            ->where('t_verifikasi.jabatan_penerima_token', $jabatan_id)
            ->where('t_surat_masuk.satuan_kerja_token', $satuan_kerja_id)
            ->where('t_surat_masuk.is_delete', 0)
            ->where(DB::raw('LOWER(t_surat_masuk.perihal_surat)'), 'LIKE', '%' . strtolower($search) . '%')
            ->orderBy($sortColoumName, $sortDirection)
            ->skip($offset)
            ->take($limit)
            ->get();
        }
        $total = $model->count();
        if ($total > 0) {    
            return response()->json([
                'pageTitle' => 'Surat Masuk',
                'message' => 'List Data Surat Masuk Tersedia', 
                'status' => 200, 
                'total' => $total,
                'data' => $model
            ]);
        } else {
            return response()->json([
                'pageTitle' => 'Surat Masuk',
                'message' => 'List Data Surat Masuk Belum Tersedia',
                'status' => 500,
                'total' => $total
            ], 500);
        }
    }
    
}
