<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\DisposisiMasuk;
use App\Models\User;
use App\Models\LampiranLaporan as Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

class DisposisiLaporanController extends Controller
{
    public function create(Request $request)
    {
        $surat = SuratMasuk::where('id', $request->surat_id)->first();
        $user = User::where('id', $request->create_id)->first();
        $jabatan_id = getJabatanCheck($user->id,"ID");
        
        $model = new Model();
        $model->id = Model::max('id') + 1;
        $model->create_id = $user->id;
        $model->surat_id = $surat->id;
        $model->surat_id_token = $surat->token;
        $model->jabatan_id_token = $jabatan_id;
        $model->deskripsi = $request->deskripsi;
        $model->jabatan_nama = $user->nama;
        $model->jabatan_posisi = getJabatanCheck($user->id,"NAMA");
        $model->is_status = 0;
        $model->is_delete = 0;
        $model->is_read = 0;
        $model->is_view = 0;
        $model->is_response = 0;
        
        if ($request->hasFile('file_lampiran')) {
            $request->validate([
                'file_lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png|max:10000',
            ]);
            
            $tgl_masuk = Date::parse($model->tgl_terima);
            $year = $tgl_masuk->year;
            $month = $tgl_masuk->month;
            $day = $tgl_masuk->day;
            $folderPath = "file_lampiran_laporan/{$year}/{$month}/{$day}/{$model->token}/";
            
            if (!Storage::disk('public')->exists($folderPath)) {
                Storage::disk('public')->makeDirectory($folderPath, 0755, true);
            }
            
            foreach ($request->file('file_lampiran') as $file) {
                $fileName = $file->getClientOriginalName();
                $fileSize = $file->getSize();
                
                Model::create([
                    'file_lampiran' => $fileName,
                    'file_lampiran_url' => $file->store($folderPath, 'public'),
                    'file_lampiran_size' => $fileSize,
                    'disposisi_detail_laporan_id' => $model->id,
                    'tipe' => 1,
                ]);
            }
        }
        
        if ($model->save()) {
            
            $detail_disposisi = DisposisiMasuk::where('is_read', 1)
            ->where('is_status', 2)
            ->where('surat_id', $request->surat_masuk_id)
            ->where('jabatan_penerima_token', getJabatan())
            ->update(['is_response' => 1]);
            return response()->json([
                'pageTitle' => 'Laporan Disposisi',
                'message' => 'Laporan Tindaklanjut Disposisi Berhasil di Simpan',
                'status' => 200,
                'data_laporan' => $model,
                'data_disposisi' => $detail_disposisi
            ], 200);
            
        } else {
            return response()->json([
                'pageTitle' => 'Laporan Disposisi',
                'message' => 'Laporan Tindaklanjut Disposisi Gagal di Simpan',
                'status' => 500,
            ], 500);
        }
    }
}
