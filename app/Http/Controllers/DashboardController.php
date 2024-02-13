<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function Index(Request $request)
    {   
        $user_id = $request->user_id;
        $dataUser = User::select('nama','email','jabatan','jabatan_pembantu')->where('id',$user_id)->first();
        $data = array(
            'surat_masuk'=>array(
                'belum'=>getTotalStatistik("Surat Masuk","is_status",0,$user_id),
                'dilihat'=>getTotalStatistik("Surat Masuk","is_status",1,$user_id),
                'dibaca'=>getTotalStatistik("Surat Masuk","is_status",2,$user_id),
                'total'=>getTotalStatistik("Surat Masuk","is_active",1,$user_id),
            ),
            'surat_keluar'=>array(
                'belum'=>getTotalStatistik("Surat Keluar","is_status",0,$user_id),
                'dilihat'=>getTotalStatistik("Surat Keluar","is_status",1,$user_id),
                'dibaca'=>getTotalStatistik("Surat Keluar","is_status",2,$user_id),
                'total'=>getTotalStatistik("Surat Keluar","is_active",1,$user_id),
            ),
            'disposisi_masuk'=>array(
                'belum'=>getTotalStatistik("Disposisi Masuk","is_status",0,$user_id),
                'dilihat'=>getTotalStatistik("Disposisi Masuk","is_status",1,$user_id),
                'dibaca'=>getTotalStatistik("Disposisi Masuk","is_status",2,$user_id),
                'total'=>getTotalStatistik("Disposisi Masuk","is_active",1,$user_id),
            ),
            'disposisi_keluar'=>array(
                'belum'=>getTotalStatistik("Disposisi Keluar","is_status",0,$user_id),
                'dilihat'=>getTotalStatistik("Disposisi Keluar","is_status",1,$user_id),
                'dibaca'=>getTotalStatistik("Disposisi Keluar","is_status",2,$user_id),
                'total'=>getTotalStatistik("Disposisi Keluar","is_active",1,$user_id),
                )
            );
            return response()->json([
                'pageTitle' => 'Dashboard',
                'message' => 'Statistik Dashboard Surat Masuk & Keluar, Disposisi Masuk & Keluar',
                'code' => 200,
                'dataUser' => $dataUser,
                'dataDashboard' => $data
            ], 200);
        }   
    }
    