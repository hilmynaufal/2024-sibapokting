<?php

namespace App\Http\Controllers;
use App\Models\SuratMasuk as Model;
use App\Models\Lampiran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LampiranController extends Controller
{
    // surat_masuk_id, tipe, nama_file, file_lampiran
    public function uploadLampiran(Request $request)
    {
        if (!$request->hasFile('file_lampiran')) {
            return response()->json(['error' => 'No files were uploaded.'], 400);
        }
        $request->validate([
            'file_lampiran' => 'file|mimes:pdf,jpg,jpeg,png|max:10000',
        ]);
        
        $model = Model::where('id',$request->surat_masuk_id)->first();
        // dd($model);
        $tgl_masuk = Carbon::parse($model->tgl_terima);
        $year = $tgl_masuk->year;
        $month = $tgl_masuk->month;
        $day = $tgl_masuk->day;
        $folderPath = "file_lampiran/{$year}/{$month}/{$day}/{$model->token}/";
        
        if (!file_exists(Storage::disk('public')->path($folderPath))) {
            Storage::disk('public')->makeDirectory($folderPath, 0755, true);
        }
        
        $file = $request->file('file_lampiran');
        $lampiran = Lampiran::create([
            'file_lampiran' => $file->getClientOriginalName(),
            'file_lampiran_url' => $file->store($folderPath, 'public'),
            'file_lampiran_size' => $file->getSize(),
            'file_lampiran_ekstensi' => $file->getExtension(),
            'surat_id' => $model->id,
            'tipe' => $request->tipe,
        ]);
        return response()->json([
            'message' => 'Files uploaded successfully.',
            'data'=>Lampiran::where('surat_id_token',$model->token)->get()
        ]);
    }
}
