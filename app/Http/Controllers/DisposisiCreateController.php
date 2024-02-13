<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SuratMasuk as Model;
use App\Models\Disposisi;
use App\Models\DisposisiMasuk;
use App\Models\RefJabatan;
use App\Models\User;

class DisposisiCreateController extends Controller
{
    function create(Request $request)
    {
        $jenis_disposisi = $request->jenis_disposisi; // 1 = Disposisi Masuk, 2 = Disposisi Keluar
        if($jenis_disposisi==1){
            $jenis_disposisi_nama = "Disposisi Masuk";
        }else{
            $jenis_disposisi_nama = "Disposisi Keluar";
        }
        
        $collection1 = collect(explode(',', $request->disposisi_tujuan));
        $collection2 = collect(explode(',', $request->disposisi_instruksi));
        $array1 = $collection1->toArray();
        $array2 = $collection2->toArray();
        $disposisiTujuanString = implode(',', $array1);
        $disposisiInstruksiString = implode(',', $array2);
        
        $model = Model::firstOrNew(['id' =>  $request->surat_masuk_id]);
        
        $model->disposisi_id = $request->create_id;
        $model->disposisi_at = now(); 
        $model->disposisi_tujuan = $disposisiTujuanString;
        $model->disposisi_instruksi = $disposisiInstruksiString;
        $model->disposisi_batas_waktu = $request->disposisi_batas_waktu;
        $model->disposisi_catatan = $request->disposisi_catatan;
        $model->disposisi_nomor = generateDisposisiNumber();
        
        if ($model->update()) {
            
            // Berhasil
            Disposisi::where('surat_id', $model->id)->delete();
            DisposisiMasuk::where('surat_id', $model->id)->delete();
            
            $disposisi = Disposisi::firstOrNew(
                [
                    'surat_id' => $model->id,
                    'surat_id_token' => $model->token,
                    'is_active' => 1,
                ],
                [
                    'create_id' => $request->create_id,
                    'created_at' => now(), 
                    'tipe' => $jenis_disposisi,
                    'disposisi_id' => $model->disposisi_id,
                    'disposisi_at' => $model->disposisi_at,
                    'disposisi_tujuan' => $model->disposisi_tujuan,
                    'disposisi_instruksi' => $model->disposisi_instruksi,
                    'disposisi_batas_waktu' => $model->disposisi_batas_waktu,
                    'disposisi_catatan' => $model->disposisi_catatan,
                    ]
                );
                
                if ($disposisi->save()) {
                    
                    $disposisi_tujuan_array = explode(",",$model->disposisi_tujuan);
                    $pegawai_atasan = User::where('id', $model->tujuan_surat_id)->first();
                    $atasan = RefJabatan::where(['token' => $pegawai_atasan->jabatan_id])->first();
                    
                    foreach ($disposisi_tujuan_array as $data) {
                        list($userID, $jabatanID) = explode(":", $data);
                        $pegawai = User::where('id', $userID)->first();
                        $pegawai_tujuan = RefJabatan::where(['token' => $jabatanID])->first();
                        // dd($pegawai_tujuan->level_jabatan);
                        
                        $directMessage = "Disposisi Surat Masuk Langsung dari " . $atasan->jabatan . " ke " . $pegawai_tujuan->jabatan;
                        $directType = 1;
                        $ccType = 0;
                        $disposisiType = 1;
                        if ($pegawai_tujuan->level_jabatan == 7) {
                            
                            // Tujuan Utama
                            setDisposisi($disposisi->create_id, $model->token, $pegawai->id, $directMessage, $disposisi->token, $directType, $disposisiType, $pegawai_tujuan->token);
                            
                            // Level 1
                            $level1UserID = getAtasanByJabatan(1,$pegawai_tujuan->atasan_id_token)->id;
                            $level1JabatanID = getAtasanByJabatan(2,$pegawai_tujuan->atasan_id_token)->token;
                            $level1JabatanPosisi = getAtasanByJabatan(2,$pegawai_tujuan->atasan_id_token)->jabatan;
                            $ccMessage = "CC ke " . $level1JabatanPosisi . " Disposisi Surat Masuk Langsung dari " . $atasan->jabatan . " ke " . $pegawai_tujuan->jabatan;
                            setDisposisi($disposisi->create_id, $model->token, $level1UserID, $ccMessage, $disposisi->token, $ccType, $disposisiType, $level1JabatanID);
                            
                            // Level 2
                            $level2UserID = getAtasanByJabatan(1,$level1JabatanID)->id;
                            $level2JabatanID = getAtasanByJabatan(2,$level1JabatanID)->atasan_id_token;
                            setDisposisi($disposisi->create_id, $model->token, $level2UserID, $ccMessage, $disposisi->token, $ccType, $disposisiType, $level2JabatanID);
                            
                            // Level 3
                            $level3UserID = getAtasanByJabatan(1,$level2JabatanID)->id;
                            $level3JabatanID = getAtasanByJabatan(2,$level2JabatanID)->atasan_id_token;
                            setDisposisi($disposisi->create_id, $model->token, $level3UserID, $ccMessage, $disposisi->token, $ccType, $disposisiType, $level3JabatanID);
                            
                            
                        }elseif ($pegawai_tujuan->level_jabatan == 6) {
                            
                            // Tujuan Utama
                            setDisposisi($disposisi->create_id, $model->token, $pegawai->id, $directMessage, $disposisi->token, $directType, $disposisiType, $pegawai_tujuan->token);
                            
                            // Level 1
                            $level1UserID = getAtasanByJabatan(1,$pegawai_tujuan->atasan_id_token)->id;
                            $level1JabatanID = getAtasanByJabatan(2,$pegawai_tujuan->atasan_id_token)->token;
                            $level1JabatanPosisi = getAtasanByJabatan(2,$pegawai_tujuan->atasan_id_token)->jabatan;
                            $ccMessage = "CC ke " . $level1JabatanPosisi . " Disposisi Surat Masuk Langsung dari " . $atasan->jabatan . " ke " . $pegawai_tujuan->jabatan;
                            setDisposisi($disposisi->create_id, $model->token, $level1UserID, $ccMessage, $disposisi->token, $ccType, $disposisiType, $level1JabatanID);
                            
                            // Level 2
                            $level2UserID = getAtasanByJabatan(1,$level1JabatanID)->id;
                            $level2JabatanID = getAtasanByJabatan(2,$level1JabatanID)->atasan_id_token;
                            setDisposisi($disposisi->create_id, $model->token, $level2UserID, $ccMessage, $disposisi->token, $ccType, $disposisiType, $level2JabatanID);
                            // Level 3
                            $level3UserID = getAtasanByJabatan(1,$level2JabatanID)->id;
                            $level3JabatanID = getAtasanByJabatan(2,$level2JabatanID)->token;
                            setDisposisi($disposisi->create_id, $model->token, $level3UserID, $ccMessage, $disposisi->token, $ccType, $disposisiType, $level3JabatanID);
                            
                            
                        } elseif ($pegawai_tujuan->level_jabatan == 5) {
                            
                            // Level 1
                            $level1UserID = getAtasanByJabatan(1,$pegawai_tujuan->atasan_id_token)->id;
                            $level1JabatanID = getAtasanByJabatan(2,$pegawai_tujuan->token)->atasan_id_token;
                            $level1JabatanPosisi = getAtasanByJabatan(2,$pegawai_tujuan->atasan_id_token)->jabatan;
                            $ccMessage = "CC ke " . $level1JabatanPosisi . " Disposisi Surat Masuk Langsung dari " . $atasan->jabatan . " ke " . $pegawai_tujuan->jabatan;
                            setDisposisi($disposisi->create_id, $model->token, $level1UserID, $ccMessage, $disposisi->token, $ccType, $disposisiType, $level1JabatanID);
                            
                            // Tujuan Utama
                            setDisposisi($disposisi->create_id, $model->token, $pegawai->id, $directMessage, $disposisi->token, $directType, $disposisiType, $pegawai_tujuan->token);
                            
                        }else{
                            // Tujuan Utama
                            setDisposisi($disposisi->create_id, $model->token, $pegawai->id, $directMessage, $disposisi->token, $directType, $disposisiType, $pegawai_tujuan->token);
                            
                        }
                    }
                    
                }
                $model_disposisi = Disposisi::where('surat_id', $disposisi->surat_id)->first();
                $model_disposisi_detail = DisposisiMasuk::where('surat_id', $disposisi->surat_id)->get();
                return response()->json([
                    'pageTitle' => $jenis_disposisi_nama,
                    'message' => 'Data '.$jenis_disposisi_nama.' Surat ID #'.$model_disposisi->surat_id.' dan Disposisi ID #'.$model_disposisi->id,
                    'status' => 200,
                    // 'data' => $disposisi,
                    'data_disposisi' => $model_disposisi,
                    'data_disposisi_detail' => $model_disposisi_detail
                ], 200);
                
            } else {
                return response()->json([
                    'pageTitle' => 'Disposisi Masuk',
                    'message' => 'Disposisi '.$jenis_disposisi_nama.' Gagal Di Insert',
                    'status' => 500
                ], 500);
            }
        }
    } 
    
    